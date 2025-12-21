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

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocks', 'blocker_id', 'blocked_id');
    }

    public function blockedBy()
    {
        return $this->belongsToMany(User::class, 'blocks', 'blocked_id', 'blocker_id');
    }

    // --- HELPER METHODS ---

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function isBlocked(User $user)
    {
        return $this->blockedUsers()->where('blocked_id', $user->id)->exists();
    }

    public function snippets()
    {
        return $this->hasMany(Snippet::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
