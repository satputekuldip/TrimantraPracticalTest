<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\MassDestroyProductCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Flash;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryController extends AppBaseController
{
    use MediaUploadingTrait;
    /** @var  CategoryRepository */
    private $categoryRepository;



    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     */
    public function index()
    {
        $productCategories = Category::with(['media'])->withCount('products')->get();
        return view('categories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $productCategory = $this->categoryRepository->create($input);

        if ($request->input('photo', false)) {
            $productCategory->addMedia(storage_path('tmp/uploads/'
                . basename($request->input('photo'))))->toMediaCollection('category');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::query()->whereIn('id', $media)->update(['model_id' => $productCategory->id]);
        }

        Flash::success('Category saved successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productCategory = Category::query()->with('parent')->find($id);

        if (empty($productCategory)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('productCategory', $productCategory);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     */
    public function edit($id)
    {
        $productCategory = $this->categoryRepository->find($id);

        if (empty($productCategory)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }
        $categories = Category::all()->pluck('name', 'id');
        return view('categories.edit', compact('categories'))->with('productCategory', $productCategory);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $productCategory = $this->categoryRepository->find($id);

        if (empty($productCategory)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $productCategory = $this->categoryRepository->update($request->all(), $id);

        if ($request->input('photo', false)) {
            if (!$productCategory->photo || $request->input('photo') !== $productCategory->photo->file_name) {
                if ($productCategory->photo) {
                    $productCategory->photo->delete();
                }
                $productCategory->addMedia(storage_path('tmp/uploads/'
                    . basename($request->input('photo'))))->toMediaCollection('category');
            }
        } elseif ($productCategory->photo) {
            $productCategory->photo->delete();
        }

        Flash::success('Category updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('categories.index'));
    }

    public function massDestroy(MassDestroyProductCategoryRequest $request)
    {
        Category::query()->whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
