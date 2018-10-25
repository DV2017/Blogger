@extends('layouts.app')

@section('content')
    <h1>All Posts</h1>
    @if(count($posts) > 0)
        @foreach ($posts as $post)
        <div class="row">
            <div class="col-sm-2">
                <img class="card-img-top" src="/storage/cover_images/{{$post->cover_image}} " alt="Card image cap">
            </div>
            <div class="col-sm-10">
                    <h3><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h3>
                    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    <p>{!!$post->body!!}</p>
                    <!-- the curly braces replace php tags-->
                    <!-- the !! allow html parsing within php codes-->
            </div>
        </div>

        @endforeach
        <!--pagination-->
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection