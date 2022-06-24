@extends('layouts.admin')

@section('content')
    <h2 class="py-4">Edit Post</h2>
    @include('partials.error')


    <form action="{{route('admin.posts.update', $post->id)}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group mb-4">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" aria-describedby="titleHelp" value="{{$post->title}}">
            <small id="titleHelp" class="form-text text-muted">Type the post title, max: 150 charachters</small>
        </div>

        <div class="d-flex mb-4">
            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="text" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" aria-describedby="cover_imageHelp" value="{{$post->cover_image}}">
                <small id="cover_imageHelp" class="form-text text-muted">Type the cover image link</small>
            </div>
            <div class="media mx-4">
                <img width="150" class="shadow" src="{{$post->cover_image}}" alt="{{$post->title}}">
            </div>
        </div>

        <label for="category_id">Category</label>
        <select class="form-select @error('category_id') is-invalid @enderror" aria-label="Default select example" name="category_id" id="category_id">
            <option selected>Choose Category...</option>
            @foreach ($categories as $category)
              <option value="{{$category->id}}" @if ($post->category_id == $category->id) selected="selected" @endif>{{$category->name}}</option>  
            @endforeach
        </select>
        <small id="category_idHelp" class="form-text text-muted my-3">Select post's category</small>


        <div class="form-group mb-4">
            <label for="content">Content</label>
            <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" aria-describedby="contentHelp" value="{{$post->content}}">
            <small id="contentHelp" class="form-text text-muted">Type the content</small>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection