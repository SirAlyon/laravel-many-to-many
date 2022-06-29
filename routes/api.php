<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Tutti i posts con response json customizzabile
/* Route::get('posts', function(){
    $posts = Post::all();

    return response()->json([
        'status_code' => 200,
        'posts' => $posts,
    ]);
}); */


//Risultati NON customizzabili
/* Route::get('posts', function(){
    $posts = Post::all();

    return $posts;
}); */


//Scorciatoia con paginazione
/* Route::get('posts', function(){
    $posts = Post::paginate(10);

    return $posts;
}); */


Route::get('posts', 'API\PostController@index');
Route::get('categories', 'API\CategoryController@index');
