<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\PostRequest;
use App\Mail\NewPostCreated;
use App\Mail\PostUpdatedAdminMessage;



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
        $categories = Category::all();
        return view ('admin.posts.create', compact('categories'));
        
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

        //Verifico se la richiesta contiene dei file
        if($request->hasFile('cover_image')){ //ddd($request->hasFile('cover_image'))  == ALTRA VERSIONE CON API DI LARAVEL

            //Valido il file
            $request->validate([
                'cover_imgae' => 'nullable|image|max:250'
            ]);
            //Salvo il file nel filesystem
            //ddd($request->all());
            $path = Storage::put('post_images', $request->cover_image);

            //recupero il percorso

            //passo il percorso all'array di dati valiati per il salvataggio della risorsa
            $val_data['cover_image'] = $path;
        }
        
        //ddd($val_data);
        
        //redirect to a get route
        $new_post = Post::create($val_data);

        //return (new NewPostCreated($new_post))->render();

        //Invia la mail usando l'istanza dellutente nella request
        Mail::to($request->user())->send(new NewPostCreated($new_post));


        //Invia la mail usando una mail fornita
        //Mail::to('test@example')->send(new NewPostCreated($new_post));

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
        return view('admin.posts.show', compact('post'));

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
        return view('admin.posts.edit', compact('post', 'categories'));
        
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
            'content' => ['nullable']

        ]);


        $slug = Str::slug($request->title, '-');
        
        $val_data['slug'] = $slug;

        //dd($request->all(), $val_data);

        if($request->hasFile('cover_image')){ //ddd($request->hasFile('cover_image'))  == ALTRA VERSIONE CON API DI LARAVEL

            //Valido il file
            $request->validate([
                'cover_imgae' => 'nullable|image|max:250'
            ]);
            //Salvo il file nel filesystem
            Storage::delete($post->cover_image);
            //ddd($request->all());
            $path = Storage::put('post_images', $request->cover_image);

            //recupero il percorso

            //passo il percorso all'array di dati valiati per il salvataggio della risorsa
            $val_data['cover_image'] = $path;
        }

        //dd($val_data);

        $post->update($val_data);

        //return (new PostUpdatedAdminMessage($post))->render();

        Mail::to($request->user())->send(new PostUpdatedAdminMessage($post));

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
        Storage::delete($post->cover_image);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', 'Post Deleted Successfully');
    }
}
