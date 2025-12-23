<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <--- Import this

class Snippet extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'title', 'slug', 'code', 'description', 'language', 'likes_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relationship for tags
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    // In app/Models/Snippet.php

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
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
