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
                <a href="/product/{{$product->slug}}">{{$product->name}} </a>
                </div>
                @if(!Auth::guest())
                <div class="cart">
                    <a href = '/to-cart/{{$product->id}}'>Add to cart </a>
                </div>
                    @endif
            </div>
        @endforeach
        {!! $products->render() !!}

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