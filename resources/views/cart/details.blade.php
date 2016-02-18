@extends('app')
@section('title')
    Order details
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
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            {{--*/ $total = 0  /*--}}
            @for($i=0;$i<count($products);$i++)
                <tr>
                    <th scope="row">{{$i+1}}</th>
                    <td><a href="/product/{{$products[$i]->slug}}"> {{$products[$i]->name}} </a></td>
                    <td>{{$quantities[$i]}}</td>
                    <td>{{$products[$i]->price}}<span class="glyphicon glyphicon-euro"></span></td>
                    {{--*/ $var = $quantities[$i]*$products[$i]->price  /*--}}
                    {{--*/ $total = $total + $var  /*--}}
                    <td>{{$var}}<span class="glyphicon glyphicon-euro"></span></td>
                </tr>
            @endfor

            </tbody>
        </table>
        Total price :{{$total}}
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