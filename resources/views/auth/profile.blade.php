@extends('app')
@section('title')
        <img src="../images/users/{{$user->profile()->first()->picture}}", alt='{{$user->name}}', class = 'img-responsive user-image'>
        {{ $user->name }}
@endsection
@section('title-meta')
    <a href="/edit-profile">Edit Profile</a>
@endsection
@section('content')
    <div>
        <ul class="list-group">
            <li class="list-group-item">
                Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }}
            </li>

        </ul>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Details</h3></div>
        <div class="panel-body">
            <p>
            <strong>
                First Name: {{$user->profile->firstName}}<br>
                Last Name:  {{$user->profile()->first()->lastName}}<br>
                Birthday:   {{$user->profile()->first()->birthday}}<br>
                Telephone:  {{$user->profile()->first()->telephoneNumber}}
            </strong>
            </p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Latest Comments</h3></div>
        <div class="list-group">
            @if(!empty($comments))
                @foreach($comments as $comment)
                    <div class="list-group-item">
                        <p>{!! $comment->content !!} </p>
                        <p>On {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                        <p>On post <a href="{{ url('/product/'.$comment->product->slug) }}">{{ $comment->product->name }}</a></p>
                    </div>
                @endforeach
            @else
                <div class="list-group-item">
                    <p>You have not commented till now. Your latest 5 comments will be displayed here</p>
                </div>
            @endif
        </div>
    </div>
@endsection