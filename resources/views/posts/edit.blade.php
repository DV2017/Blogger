@extends('layouts.app')
@section('content')
    <h1>Edit post</h1>

    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{ Form::label('title', 'Title')}}
            {{ Form::text('title', $post->title, ['class' => 'form-control', 'placeholder'=>'title']) }}
        </div>
        <div class="form-group">
            {{ Form::label('body', 'Content') }}
            {{ Form::textarea('body', $post->body, ['id'=>'article-ckeditor', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <!-- to handle file uploads add enctype to Form open as above -->
            {{ Form::file('cover_image') }}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection