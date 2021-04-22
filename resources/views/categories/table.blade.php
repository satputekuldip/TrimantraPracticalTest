<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-ProductCategory">
        <thead>
        <tr>
            <th width="10">

            </th>
            <th>
                ID
            </th>
            <th>
                Name
            </th>
            <th>
                Photo
            </th>
            <th>
                No. of Products
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($productCategories as $key => $productCategory)
            <tr data-entry-id="{{ $productCategory->id }}">
                <td>

                </td>
                <td>
                    {{ $productCategory->id ?? '' }}
                </td>
                <td>
                    {{ $productCategory->name ?? '' }}
                </td>
                <td>
                    @if($productCategory->photo)
                        <a href="{{ $productCategory->photo->getUrl() }}" target="_blank" style="display: inline-block">
                            <img src="{{ $productCategory->photo->getUrl('thumb') }}">
                        </a>
                    @endif
                </td>

                <td>
                    {{ $productCategory->products->count() ?? '' }}
                </td>
                <td>
                        <a class="btn btn-xs btn-primary"
                           href="{{ route('categories.show', $productCategory->id) }}">
                            {{ trans('global.view') }}
                        </a>
                        <a class="btn btn-xs btn-info"
                           href="{{ route('categories.edit', $productCategory->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                        <form action="{{ route('categories.destroy', $productCategory->id) }}"
                              method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                              style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                        </form>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
