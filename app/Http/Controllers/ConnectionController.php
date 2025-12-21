<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function toggleFollow(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($currentUser->isFollowing($user)) {
            $currentUser->following()->detach($user->id);
            $message = 'Unfollowed successfully.';
            $state = 'unfollowed';
        } else {
            // Check if blocked
            if ($user->isBlocked($currentUser)) {
                return back()->with('error', 'You cannot follow this user.');
            }

            $currentUser->following()->attach($user->id);
            $message = 'Followed successfully.';
            $state = 'followed';
        }

        // Return JSON for AJAX
        return response()->json([
            'status' => $state,
            'followers_count' => $user->followers()->count()
        ]);
    }

    public function toggleBlock(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot block yourself.');
        }

        if ($currentUser->isBlocked($user)) {
            $currentUser->blockedUsers()->detach($user->id);
            $message = 'User unblocked.';
            $state = 'unblocked';
        } else {
            // 1. Block the user
            $currentUser->blockedUsers()->attach($user->id);

            // 2. Force unfollow (both ways)
            $currentUser->following()->detach($user->id);
            $currentUser->followers()->detach($user->id);

            $message = 'User blocked.';
            $state = 'blocked';
        }

        return back()->with('success', $message);
    }
}
