<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
        <thead>
        <tr>
            <th width="10">

            </th>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $key => $product)
            <tr data-entry-id="{{ $product->id }}">
                <td>

                </td>
                <td>
                    {{ $product->id ?? '' }}
                </td>
                <td>
                    {{ $product->name ?? '' }}
                </td>
                <td>
                    {{ $product->description ?? '' }}
                </td>
                <td>
                        <span class="badge badge-info">{{ $product->category->name ?? '' }}</span>
                </td>
                <td>
                    @if($product->photo)
                        <a href="{{ $product->photo->getUrl() }}" target="_blank" style="display: inline-block">
                            <img src="{{ $product->photo->getUrl('thumb') }}">
                        </a>
                    @endif
                </td>
                <td>
                        <a class="btn btn-xs btn-primary" href="{{ route('products.show', $product->id) }}">
                            {{ trans('global.view') }}
                        </a>
                        <a class="btn btn-xs btn-info" href="{{ route('products.edit', $product->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return
                            confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                        </form>

                </td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
</div>
