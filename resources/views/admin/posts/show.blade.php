@extends('layouts.admin')

@section('content')
    <img src="{{$post->cover_image}}" alt="{{$post->title}}">
    <h1>{{$post->title}}</h1>
    <div class="content">{{$post->title}}</div>
    <div>Tags: 
        @if(count($post->tags) > 0) 
            @foreach($post->tags as $tag)
                {{$tag->name}}
            @endforeach
        @else 
            <span>No tags</span>

        @endif
    </div>
@endsection