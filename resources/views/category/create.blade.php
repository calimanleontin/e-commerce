@extends('app')
@section('title')
    Create a new category
@endsection
@section('title-meta')

@endsection
@section('content')

    <form action="/category/store" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
        <input required="required" value="{{ old('title') }}" placeholder="Title" type="text" name = "title"class="form-control" />
        </div>
        <div class="form-group">
        <textarea name='description'class="form-control" placeholder="Description">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
        <button class="btn btn-success" type="submit">Create</button>
        </div>
    </form>
@endsection
