@extends('app')
@section('title')
    Edit the comment
@endsection
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

@section('content')


    @if(!Auth::guest() or Auth::user()->is_admin() or Auth::user()->is_moderator() or Auth::user()->id == $comment->author_id)
        <form method="post" action="/comment/update" class="form-group">
            <input type = 'hidden' name = '_token' value = "{{csrf_token()}}" >
            <input type="hidden" name = "comment_id" value="{{$comment->id}}">
            <textarea name ='content' class="form-control" placeholder="Comment">{!! $comment->content !!}</textarea>
            <div class="form-group">
                <br>
                <input type="submit" value="Update" class ='form-control-static btn btn-primary' >
            </div>

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