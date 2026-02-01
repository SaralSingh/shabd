<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_id'  // ✅ Add this field to support replies
    ];

    // 🔗 Belongs to a post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 🔗 Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🌱 Has many replies (self-referencing)
    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->with('user', 'replies');
    }

    // 🔙 Belongs to a parent comment
    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function repliesRecursive()
{
    return $this->hasMany(PostComment::class, 'parent_id')
        ->with(['user', 'repliesRecursive']); // 👈 recursive chain
}
}

