<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'picture',
        'likes',
        'dislikes',
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
