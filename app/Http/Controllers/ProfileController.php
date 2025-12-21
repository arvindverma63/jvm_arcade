<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $currentUser = Auth::user();

        // Blocking Logic
        if ($currentUser) {
            if ($user->isBlocked($currentUser)) abort(404);
            if ($currentUser->isBlocked($user)) return view('pages.profile.blocked', compact('user'));
        }

        $user->loadCount(['followers', 'following', 'snippets']);

        // 1. Get Snippets
        $snippets = $user->snippets()->latest()->paginate(12);

        // 2. Get Followers (Limit to 50 for performance)
        $followers = $user->followers()->take(50)->get();

        return view('pages.profile.show', compact('user', 'snippets', 'followers'));
    }

    // Optional: Update Banner/Avatar logic would go here
}
