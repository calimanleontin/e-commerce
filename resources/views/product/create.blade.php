@extends('app')
@section('title')
    Add a new product
@endsection

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
@section('content')

    <form method="post" action="/product/store" >
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
             Name:
        <input type="text" name="name" placeholder="Name" class="form-control">
        </div>
        <div class="form-group">
            Price:
        <input type="number" name="price" placeholder="Price" class="form-control">
        </div>
        <div class="form-group">
            Quantity:
            <input type="number" name="quantity" placeholder="Quantity" class="form-control">
        </div>
        <div class="form-group">
            <input type="file" name = 'image' value="Upload">
        </div>
        <div class="form-group">
            Description:
            <textarea name="description" class="form-control" placeholder="Description"></textarea>
        </div>
        <div class="form-group">
            <input type="image" name = 'image'>
        </div>
        Check the categories this product to belong to:<br/>
        @foreach($categories as $category)
            <input type="checkbox"  name="category[]" value={{$category->title}}>{{$category->title}}<br>
        @endforeach
        <div class="form-group">
            <input type="submit" name="publish" value="Publish"/>
        </div>
    </form>


@endsection


@section('category-title')
    Categories
@endsection
@section('category-content')
    @if(!empty($categories))
        <ul class="list-group">
            @foreach($categories as $category)
                <a href = '/category/{{$category->slug}}'><li class="list-group-item">{{$category->title}} </li></a>
            @endforeach
        </ul>
    @endif
@endsection