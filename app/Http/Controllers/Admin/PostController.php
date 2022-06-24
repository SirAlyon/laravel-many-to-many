<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\Post;
use App\Models\Tag;

use App\Models\Category;

use Illuminate\Http\Request;

use App\Http\Requests\PostRequest;

use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get all tags
        $tags = Tag::all();
        $categories = Category::all();
        return view ('admin.posts.create', compact('categories', 'tags'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //dd($request->all());
        $val_data = $request->validated();

        //Generate the slug

        $slug = Str::slug($request->title, '-');
        //Create the resource
        //dd($slug);
        $val_data['slug'] = $slug;
        //dd($val_data);
        //redirect to a get route
        $new_post = Post::create($val_data);

        $new_post->tags()->attach($request->tags);


        return redirect()->route('admin.posts.index')->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.show', compact('post', 'tags'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //dd($request->all());
        //validate data
        $val_data = $request->validate([
            'title' => ['required', 'max:150'],
            'cover_image' => ['nullable'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'exists:tags,id'],
            'content' => ['nullable']

        ]);

        //dd($val_data);

        $slug = Str::slug($request->title, '-');
        
        $val_data['slug'] = $slug;

        $post->update($val_data);
        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', 'Post Deleted Successfully');
    }
}
