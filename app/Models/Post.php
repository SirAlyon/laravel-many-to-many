<?php

namespace App\Models;

use App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'cover_image', 'category_id'];

    public function category()
    {
        return $this->belongsto(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
