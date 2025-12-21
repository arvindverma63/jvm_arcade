<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    /**
     * Get the user who liked the content.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent likeable model (snippet, post, or comment).
     */
    public function likeable()
    {
        return $this->morphTo();
    }
}
