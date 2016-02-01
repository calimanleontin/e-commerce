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
            {{$product->name}}
        @endforeach
    @endif

    @if(!empty($categories))
        @foreach($categories as $category)
            {{$category->title}}
        @endforeach
    @endif
@endsection