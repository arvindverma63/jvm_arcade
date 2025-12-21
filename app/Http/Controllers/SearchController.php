<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Return empty view if no query
        if (!$query) {
            return view('pages.search', [
                'users' => collect(),
                'snippets' => collect(),
                'query' => null
            ]);
        }

        // 1. Search Users (Limit to 6 for the top section)
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('bio', 'LIKE', "%{$query}%")
            ->withCount('followers')
            ->take(6)
            ->get();

        // 2. Search Snippets (Search title, description, code, language, and tags)
        $snippets = Snippet::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%") // Optional: search inside code
            ->orWhere('language', 'LIKE', "%{$query}%")
            ->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'tags'])
            ->withCount('likes', 'comments')
            ->latest()
            ->paginate(20); // Paginate results

        return view('pages.search', compact('users', 'snippets', 'query'));
    }

    // app/Http/Controllers/SearchController.php

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json(['users' => [], 'snippets' => []]);
        }

        // 1. Fetch Users (Limit 3)
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'avatar') // Select only what we need
            ->take(3)
            ->get();

        // 2. Fetch Snippets (Limit 5)
        $snippets = Snippet::where('title', 'LIKE', "%{$query}%")
            ->orWhere('language', 'LIKE', "%{$query}%")
            ->select('id', 'title', 'language') // Select only what we need
            ->take(5)
            ->get();

        return response()->json([
            'users' => $users,
            'snippets' => $snippets
        ]);
    }
}
