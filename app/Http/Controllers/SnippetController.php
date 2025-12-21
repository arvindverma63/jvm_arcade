<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Repositories\Interfaces\SnippetRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SnippetController extends Controller
{
    protected $snippetRepository;

    // Inject the Repository
    public function __construct(SnippetRepositoryInterface $snippetRepository)
    {
        $this->snippetRepository = $snippetRepository;
    }

    public function index()
    {
        $snippets = Auth::user()
            ->snippets()
            ->latest()
            ->paginate(10); // Show 10 per page

        return view('pages.profile-pages.my-snippets', compact('snippets'));
    }

    // 1. Show the Create Form
    public function create()
    {
        return view('pages.create-snippet');
    }

    // 2. Store the Snippet in DB
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string',
            'code' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);

        // Generate a unique slug (e.g., "My Snippet" -> "my-snippet-123456")
        $slug = Str::slug($request->title) . '-' . strtolower(Str::random(6));

        // Create via Repository
        $snippet = $this->snippetRepository->create([
            'user_id' => Auth::id(), // Get logged in user UUID
            'title' => $request->title,
            'slug' => $slug,
            'language' => $request->language,
            'code' => $request->code,
            'description' => $request->description,
            'likes_count' => 0,
        ]);

        // Redirect to profile or the snippet detail page
        return redirect()->route('profile.snippets')->with('success', 'Snippet published successfully!');
    }

    public function show($id)
    {
        $snippet = \App\Models\Snippet::with(['user', 'tags', 'comments.user'])
            ->findOrFail($id);

        return view('pages.snippet-detail', compact('snippet'));
    }

    // app/Http/Controllers/SnippetController.php

    public function edit($id)
    {
        $snippet = Snippet::find($id);
        // Authorization: Only allow owner
        if ($snippet->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.snippet.edit', compact('snippet'));
    }

    public function update(Request $request, Snippet $snippet)
    {
        if ($snippet->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'code' => 'required',
            'language' => 'required',
            'description' => 'nullable',
            'tags' => 'nullable|string', // Comma separated string from frontend
        ]);

        // 1. Update basic fields
        $snippet->update([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'language' => $validated['language'],
            'description' => $validated['description'],
        ]);

        // 2. Sync Tags
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }

            $snippet->tags()->sync($tagIds);
        } else {
            $snippet->tags()->detach();
        }

        return redirect()->route('snippets.show', $snippet->id)
            ->with('success', 'Snippet updated successfully.');
    }
}
