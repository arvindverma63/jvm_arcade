<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        // Base query with counts
        $query = Tag::withCount('snippets');

        $trendingTags = (clone $query)
            ->orderByDesc('snippets_count')
            ->take(2)
            ->get();

        // 2. Handle Search
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        $tags = $query
            ->orderByDesc('snippets_count')
            ->orderBy('name')
            ->paginate(15); // Show 15 per page

        return view('pages.tags', compact('tags', 'trendingTags', 'search'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $tags = Tag::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name']); // Only select what you need

        return response()->json($tags);
    }
}
