@extends('layouts.app')
@section('content')
    <h1>Create post</h1>

    {!! Form::open(['action' => 'PostsController@store', 'class'=>'form', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{ Form::label('title', 'Title')}}
            {{ Form::text('title', '', ['class' => 'form-control', 'placeholder'=>'title']) }}
        </div>
        <div class="form-group">
            {{ Form::label('body', 'Content') }}
            {{ Form::textarea('body', '', ['id'=>'article-ckeditor', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <!-- to handle file uploads add enctype to Form open as above -->
            {{ Form::file('cover_image') }}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection