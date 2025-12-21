<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; // Import Str for UUID generation

class User extends Authenticatable
{
    use HasUuids, Notifiable;

    // 1. Disable Auto-Increment
    public $incrementing = false;

    // 2. Set Key Type to String
    protected $keyType = 'string';

    protected $fillable = [
        'id', // <--- Make sure 'id' is fillable so we can set it manually
        'name',
        'email',
        'password',
        'github_id',
        'google_id',
        'avatar',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Add this method to your User.php class

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
