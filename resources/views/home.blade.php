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
            <div class="col-md-3 product" xmlns:max-height="http://www.w3.org/1999/xhtml">
                <div class="panel-title  title">
                <a href="/product/{{$product->slug}}">{{$product->name}} </a>
                    <a href ='/product/{{$product->slug}}'>
                    <img src="../images/catalog/{{$product->image}}"  style="max-height: 200px; max-width: 120px;"  alt="Product Image" class = 'img-responsive'>
                    </a>
                   <div class="down">

                        <p>
                            <strong>
                                Price:
                            </strong>
                            {{$product->price}}
                        </p>
                        <p>
                            <strong>
                                Quantity:
                            </strong>
                            {{$product->quantity}}
                        </p>
                   </div>
                </div>
                @if(!Auth::guest())
                <div class="cart" >

                    <a href = '/to-cart/{{$product->id}}'><button class="btn btn-default btn-success link up">Add</button> </a>
                    <a href = '/edit/product/{{$product->id}}'><button class="btn btn-default btn-success link up">Edit</button> </a>

                </div>
                    @endif
            </div>
        @endforeach
        @if(!empty($term))
            <?php echo $products->appends(['q' => $term])->render(); ?>
        @else
            {!! $products->render() !!}
        @endif
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