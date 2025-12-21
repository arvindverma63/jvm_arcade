<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function overview()
    {
        $user = Auth::user();

        // Load counts
        $user->loadCount(['snippets', 'followers', 'comments', 'likes']);

        // Calculate Reputation (Example logic: 10 pts per snippet, 2 per like, 5 per follower)
        $reputation = ($user->snippets_count * 10) + ($user->likes_count * 2) + ($user->followers_count * 5);

        // Fetch Recent Activity (Merge Snippets and Comments)
        // This is a simple way to combine activity streams
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

    // In ProfileController.php

    public function updateImage(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|max:2048', // Max 2MB
            'banner' => 'nullable|image|max:4096', // Max 4MB
        ]);

        $user = $request->user();

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists and isn't a default URL
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar));
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        }

        // Handle Banner Upload
        if ($request->hasFile('banner')) {
            if ($user->banner && !str_starts_with($user->banner, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->banner));
            }

            $path = $request->file('banner')->store('banners', 'public');
            $user->banner = '/storage/' . $path;
        }

        $user->save();

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

        $user->update($validated);

        return back()->with('success', 'Profile settings updated successfully.');
    }
}
