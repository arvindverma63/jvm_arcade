<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'body', 'type', 'views', 'votes', 'is_solved'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
