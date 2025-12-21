<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'location',
        'website',
        'primary_language',
        'ide_theme',
        'banner',
        'reputation',
    ];

    // Relationship: A profile belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
