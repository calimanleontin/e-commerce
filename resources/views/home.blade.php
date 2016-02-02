@extends('app')
@section('title')
    @if(!empty($title))
        {{$title}}
        @else
        Welcome to my shop
    @endif

    @endsection
@section('content')
    @if(!empty($products))
        @foreach($products as $product)
            <div class="col-md-3 product">
                <div class="panel-title  title">
                {{$product->name}}
                </div>
                <div class="cart">
                    Add to cart
                </div>
            </div>
        @endforeach
    @endif
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