<!doctype html>
@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>Laravel application from scratch series by Brad Traversy</p>
        <p>
            <a class="btn btn-primary" href="/login">Login</a>
            <a class="btn btn-info" href="/register">Register</a>
        </p>
    </div>
@endsection
