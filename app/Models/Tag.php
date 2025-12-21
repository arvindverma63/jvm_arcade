<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function posts() {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function snippets() {
        return $this->morphedByMany(Snippet::class, 'taggable');
    }
}
