@extends('app')
@section('title')
    Edit
@endsection

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
@section('content')


    {!! Form::open(array('url' => '/update/product', 'method'=>'POST', 'files'=>true)) !!}
    {!! Form::token() !!}

    {{ Form::hidden('id', $product->id) }}

    <div class="form-group">
        {!! Form::label('name','Name') !!}
        {!! Form::text('name',$product->name,['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('quantity','Quantity') !!}
        {!! Form::number('quantity',$product->quantity,['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Product Image') !!}
        {!! Form::file('image') !!}
    </div>

    <div class="form-group">
        {!! Form::label('description','Description') !!}
        {!! Form::textarea('description',$product->description,['class' => 'form-control']) !!}
    </div>
    <p>
        The actual categories are:
        <ul>
        @foreach($product->categories as $category)
            <li>
            {{$category->title}}
            </li>
        @endforeach
    </ul>
    </p>

    @foreach($categories as $category)
        <div class="form-group">
            <label>{!!  Form::checkbox("category[]",$category->title, false) !!} {{$category->title}} </label>
        </div>
    @endforeach

    <div class="form-group">
        {!!  Form::submit('Create',['class'=> ''])!!}
    </div>

    {!! Form::close() !!}


@endsection


