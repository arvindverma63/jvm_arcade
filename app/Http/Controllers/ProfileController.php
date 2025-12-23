<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
// 1. Import the Notification Class
use App\Notifications\UserActionNotification;

class ProfileController extends Controller
{
    public function overview()
    {
        $user = Auth::user();

        // Load counts
        $user->loadCount(['snippets', 'followers', 'comments', 'likes']);

        // Calculate Reputation (Example logic)
        $reputation = ($user->snippets_count * 10) + ($user->likes_count * 2) + ($user->followers_count * 5);

        // Fetch Recent Activity (Merge Snippets and Comments)
        $snippets = $user->snippets()->latest()->take(5)->get()->map(function ($item) {
            $item->type = 'snippet_created';
            return $item;
        });

        $comments = $user->comments()->with('commentable')->latest()->take(5)->get()->map(function ($item) {
            $item->type = 'commented';
            return $item;
        });

        // Merge and sort by date
        $activities = $snippets->merge($comments)->sortByDesc('created_at')->take(10);

        return view('pages.profile-pages.overview', compact('user', 'reputation', 'activities'));
    }

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

    public function updateImage(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
        ]);

        $user = $request->user();
        $notified = false; // Flag to ensure we only notify once

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar));
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
            $notified = true;
        }

        // Handle Banner Upload (profile table)
        if ($request->hasFile('banner')) {
            if ($user->profile && $user->profile->banner && !str_starts_with($user->profile->banner, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->profile->banner));
            }

            $path = $request->file('banner')->store('banners', 'public');

            // Create profile if missing, then update banner
            $user->profile()->updateOrCreate(
                [],
                ['banner' => '/storage/' . $path]
            );
            $notified = true;
        }

        $user->save();

        // --- [NOTIFICATION] ---
        if ($notified) {
            $user->notify(new UserActionNotification("You updated your profile appearance."));
        }
        // ----------------------

        return back()->with('success', 'Profile image updated successfully.');
    }

    public function edit()
    {
        return view('pages.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:500'],
            'primary_language' => ['required', 'string', 'in:Java,Kotlin,Scala,Groovy'],
            'theme' => ['required', 'string', 'in:dark,light'],
        ]);

        // 1. Update User Table (Name)
        $user->update([
            'name' => $validated['name']
        ]);

        // 2. Update Profile Table (Title, Bio, Lang, Theme)
        // We use updateOrCreate in case the profile record doesn't exist yet
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => $validated['title'],
                'bio' => $validated['bio'],
                'primary_language' => $validated['primary_language'],
                'theme' => $validated['theme'],
            ]
        );

        // --- [NOTIFICATION] ---
        $user->notify(new UserActionNotification("Your profile details have been updated."));
        // ----------------------

        return back()->with('success', 'Profile settings updated successfully.');
    }
}
