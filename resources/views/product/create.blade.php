@extends('app')
@section('title')
    Add a new product
@endsection
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
            Description:
            <textarea name="description" class="form-control" placeholder="Description"></textarea>
        </div>
        @foreach($categories as $category)
            <input type="checkbox"  name="category[]" value={{$category->title}}>{{$category->title}}<br>
        @endforeach
        <div class="form-group">
            <input type="submit" name="publish" value="Publish"/>
        </div>
    </form>


@endsection