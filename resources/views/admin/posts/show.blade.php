@extends('layouts.admin')

@section('content')
    <img width="200" src="{{asset('storage/' . $post->cover_image)}}" alt="{{$post->title}}">
    <h1>{{$post->title}}</h1>
    <div class="content">{{$post->title}}</div>
@endsection