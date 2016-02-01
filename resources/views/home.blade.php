@extends('app')
@section('content')
@foreach($products as $product)
    {{$product->name}}
    @endforeach
@foreach($categories as $category)
    {{$category->title}}
    @endforeach
@endsection