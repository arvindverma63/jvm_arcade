<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'body', 'commentable_id', 'commentable_type', 'is_solution', 'votes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
    // In App\Models\Snippet.php (and Post.php, Comment.php)
    public function likes()
    {
        return $this->morphMany(\App\Models\Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    // Helper to check if current user liked it
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
