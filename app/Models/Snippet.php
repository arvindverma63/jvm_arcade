<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'code', 'description', 'language', 'likes_count'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relationship for tags
    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
