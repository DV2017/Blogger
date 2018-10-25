@extends('layouts.app')

@section('content')
        <a href="/posts" class="btn btn-default">Go Back</a>
        <div class="card">
                <img class="card-img-top" src="/storage/cover_images/{{$post->cover_image}} " alt="Card image cap">
            <div class="card-body">
                <div class="card-title">
                    <h1>{{$post->title}}</h1>
                    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                </div>
                <hr>
                <div class="card-text">
                <p>{!!$post->body!!}</p>
                <!-- the curly braces replace php tags-->
                <!-- the !! allow html parsing within php codes-->
                </div>
            </div>
        </div>
        
        @if(!Auth::guest())
            @if(Auth::id() == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>

                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'class' => 'float-right']) !!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}
            @endif
        @endif

@endsection