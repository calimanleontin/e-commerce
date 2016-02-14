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
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
        @for($i=0;$i<count($products);$i++)
            <tr>
                <th scope="row">1</th>
                <td><a href="/product/{{$products[$i]->slug}}"> {{$products[$i]->name}} </a></td>
                <td>{{$quantities[$i]}}</td>
                <td>{{$products[$i]->price}}</td>
                <td><a href="/cart/increase/{{$products[$i]->id}}"><button class= " btn btn-primary btn-success" > + </button></a></td>
                <td><a href="/cart/decrease/{{$products[$i]->id}}"><button class ="btn btn-primary btn-warning"> - </button></a></td>
                <td><a href="/cart/delete/{{$products[$i]->id}}"> <button class="btn btn-primary btn-danger" >Erase</button></a> </td>
                {{--*/ $var = $quantities[$i]*$products[$i]->price  /*--}}
                <td>{{$var}}</td>
            </tr>
        @endfor
            </tbody>
        </table>
        <button class="btn btn-default" a href="/finish-cart" >Purchase</button>
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