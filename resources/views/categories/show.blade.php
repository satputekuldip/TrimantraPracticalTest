@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            Category
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $productCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $productCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Parent Category
                        </th>
                        <td>
                            {{ $productCategory->parent->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Photo
                        </th>
                        <td>
                            @if($productCategory->photo)
                                <a href="{{ $productCategory->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $productCategory->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
