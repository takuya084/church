<?php

// app/Models/PostYoutubeUrl.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostYoutubeUrl extends Model
{
    protected $fillable = ['post_id', 'youtube_url'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}