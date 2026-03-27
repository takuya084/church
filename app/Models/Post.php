<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pastor(){
        return $this->belongsTo(Pastor::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    protected $fillable = [
        'title',
        'pastor_id',
        'pastor_name',
        'bible_passage',
        'body',
        'user_id',
        'image',
    ];

    public function youtubeUrls(){
        return $this->hasMany(PostYoutubeUrl::class);
    }
}
