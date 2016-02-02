@extends('app')
@section('title')
    Products in cart
@endsection
@section('content')
    @if(!empty($products))
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Increase</th>
                <th>Decrease</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
        @foreach($products as $quantity => $product)
            <tr>
                <th scope="row">1</th>
                <td><a href="/product/{{$product->slug}}"> {{$product->name}} </a></td>
                <td>{{$quantity}}</td>
                <td>{{$product->price}}</td>
                <td><a href="/cart/increase/{{$product->id}}"><button class= " btn btn-primary btn-success" > + </button></a></td>
                <td><a href="/cart/decrease/{{$product->id}}"><button class ="btn btn-primary btn-warning"> - </button></a></td>
                <td><a href="/cart/delete/{{$product->id}}"> <button class="btn btn-primary btn-danger" >Erase</button></a> </td>

            </tr>
        @endforeach
            </tbody>
        </table>
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