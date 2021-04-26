<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AppBaseController
{
    use MediaUploadingTrait;
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     */
    public function index()
    {
        $categories = ['' => 'Select Category'];
        $categories = array_merge($categories,Category::all()->pluck('name', 'name')->toArray());
        $products = Product::with(['media'])->get();
        return view('products.index', compact('products','categories'));
    }

    /**
     * Show the form for creating a new Product.
     *
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->create($input);

        if ($request->input('photo', false)) {
            $product->addMedia(storage_path('tmp/uploads/'
                . basename($request->input('photo'))))->toMediaCollection('product');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::query()->whereIn('id', $media)->update(['model_id' => $product->id]);
        }

        Flash::success('Product saved successfully.');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }
        $categories = Category::all()->pluck('name', 'id');
        return view('products.edit', compact('categories'))->with('product', $product);
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        $product = $this->productRepository->update($request->all(), $id);

        if ($request->input('photo', false)) {
            if (!$product->photo || $request->input('photo') !== $product->photo->file_name) {
                if ($product->photo) {
                    $product->photo->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/'
                    . basename($request->input('photo'))))->toMediaCollection('product');
            }
        } elseif ($product->photo) {
            $product->photo->delete();
        }

        Flash::success('Product updated successfully.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Product deleted successfully.');

        return redirect(route('products.index'));
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::query()->whereIn('id', request('ids'))->delete();
        Flash::success('Products deleted successfully.');
        return response(null, Response::HTTP_NO_CONTENT);
    }

}
