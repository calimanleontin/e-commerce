@extends('app')
@section('title')
    {{$product->name}}
@endsection
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

@section('content')
    Add a comment:
    <form method="post" action="/comment/store" class="form-group">
        <input type = 'hidden' name = '_token' value = "{{csrf_token()}}" >
        <input type="hidden" name = "product_id" value="{{$product->id}}">
        <textarea name ='content' class="form-control" placeholder="Comment"></textarea>
        <div class="form-group">
            <br>
        <input type="submit" value="Submit" class ='form-control-static' >
        </div>
    </form>

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

    <div>
        @if(!empty($comments))
            <ul style="list-style: none; padding: 0">
                @foreach($comments as $comment)
                    <li class="panel-body">
                        <div class="list-group">
                            <div class="list-group-item">
                                <h3>{{ $comment->author->name }}</h3>
                                <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                            </div>
                            <div class="list-group-item">
                                <p>{{ $comment->body }}</p>
                                @if(!Auth::guest() && ($comment->from_user == Auth::user()->id || Auth::user()->is_admin() || Auth::user()->is_moderator() ))
                                    <a href="{{  url('comment/delete/'.$comment->id) }}" class="btn btn-danger">Delete comment</a>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
    @endif
@endsection