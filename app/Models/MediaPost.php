<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPost extends Model
{
    protected $table = 'media_posts';
    protected $fillable = ['category', 'title', 'slug', 'thumbnail', 'content', 'published_date'];
}
