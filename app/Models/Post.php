<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'body', 'type', 'views', 'votes', 'is_solved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    // In App\Models\Snippet.php (and Post.php, Comment.php)
    public function likes()
    {
        return $this->morphMany(\App\Models\Like::class, 'likeable');
    }

    // Helper to check if current user liked it
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
