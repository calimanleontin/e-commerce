@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            {!! Form::open(array('url' => '/profile/update', 'method'=>'POST', 'files'=>true)) !!}
                            {!! Form::token() !!}

                            <div class="form-group col-md-6">
                                {!! Form::label('firstName','First Name') !!}
                                {!! Form::text('firstName','',['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('lastName','Last Name') !!}
                                {!! Form::text('lastName','',['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('age','Age') !!}
                                {!! Form::number('age','',['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-12">
                                {!! Form::label('about','About me') !!}
                                {!! Form::textarea('about','',['class' => 'form-control']) !!}
                            </div>


                            <div class="form-group col-md-3">
                                {!!  Form::submit('Submit',['class'=> 'btn btn-default'])!!}
                            </div>


                            {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
