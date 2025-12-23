<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Models\Tag;
use App\Repositories\Interfaces\SnippetRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\UserActionNotification;

class SnippetController extends Controller
{
    protected $snippetRepository;

    public function __construct(SnippetRepositoryInterface $snippetRepository)
    {
        $this->snippetRepository = $snippetRepository;
    }

    public function index()
    {
        $snippets = Auth::user()
            ->snippets()
            ->latest()
            ->paginate(10);

        return view('pages.profile-pages.my-snippets', compact('snippets'));
    }

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
            'tags' => 'nullable|string',
        ]);

        // Generate a unique slug for the snippet
        $slug = Str::slug($request->title) . '-' . strtolower(Str::random(6));

        // Create via Repository
        $snippet = $this->snippetRepository->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'language' => $request->language,
            'code' => $request->code,
            'description' => $request->description,
            'likes_count' => 0,
        ]);

        // --- Handle Tags (With Slugs) ---
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $name = trim($tagName);

                // Search by Name, if not found, create with Name AND Slug
                $tag = Tag::firstOrCreate(
                    ['name' => $name],               // Search condition
                    ['slug' => Str::slug($name)]     // Values to set if creating new
                );

                $tagIds[] = $tag->id;
            }

            $snippet->tags()->sync($tagIds);
        }

        // Notification
        Auth::user()->notify(new UserActionNotification(
            "You published a new snippet: " . Str::limit($snippet->title, 20)
        ));

        return redirect()->route('profile.snippets')->with('success', 'Snippet published successfully!');
    }

    public function show($id)
    {
        $snippet = Snippet::with(['user', 'tags', 'comments.user'])
            ->findOrFail($id);

        return view('pages.snippet-detail', compact('snippet'));
    }

    public function edit($id)
    {
        $snippet = Snippet::find($id);

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
            'tags' => 'nullable|string',
        ]);

        $snippet->update([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'language' => $validated['language'],
            'description' => $validated['description'],
        ]);

        // --- Handle Tags (With Slugs) ---
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $name = trim($tagName);

                // Search by Name, if not found, create with Name AND Slug
                $tag = Tag::firstOrCreate(
                    ['name' => $name],               // Search condition
                    ['slug' => Str::slug($name)]     // Values to set if creating new
                );

                $tagIds[] = $tag->id;
            }

            $snippet->tags()->sync($tagIds);
        } else {
            $snippet->tags()->detach();
        }

        // Notification
        Auth::user()->notify(new UserActionNotification(
            "You updated your snippet: " . Str::limit($snippet->title, 20)
        ));

        return redirect()->route('snippets.show', $snippet->id)
            ->with('success', 'Snippet updated successfully.');
    }

    public function destroy($id)
    {
        $snippet = Snippet::findOrFail($id);

        // 1. Authorization: Only the owner can delete
        if ($snippet->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $snippet->delete();

        return back()->with('success', 'Snippet moved to trash.');
    }
}
