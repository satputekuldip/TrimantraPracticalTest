<!-- Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('photo', 'Photo:') !!}
    <p>@if($product->photo)
            <a href="{{ $product->photo->getUrl() }}" target="_blank" style="display: inline-block">
                <img width="400" src="{{ $product->photo->getUrl() }}">
            </a>
        @endif
    </p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $product->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $product->description }}</p>
</div>

<!-- Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('category_id', 'Category :') !!}
    <p>{{ $product->category->name ?? '' }}</p>
</div>



