<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\Tag;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\SnippetRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    protected $postRepository;
    protected $snippetRepository; // Add property

    // Inject both repositories
    public function __construct(
        PostRepositoryInterface $postRepository,
        SnippetRepositoryInterface $snippetRepository
    ) {
        $this->postRepository = $postRepository;
        $this->snippetRepository = $snippetRepository;
    }

    public function home()
    {
        // 1. Fetch Posts (Paginator)
        $posts = $this->postRepository->getFeed(10);

        // 2. Fetch Latest Snippets (Collection)
        $snippets = $this->snippetRepository->getLatest(10);

        $feed = collect($posts->items())
            ->merge($snippets)
            ->sortByDesc('created_at');

        return view('welcome', [
            'feed' => $feed,
            'posts' => $posts
        ]);
    }

    public function latest(Request $request)
    {
        $query = Snippet::with(['user', 'tags'])
            ->withCount(['comments', 'likes'])
            ->latest();
        if ($request->has('filter')) {
            if ($request->filter === 'questions') {
                $query->whereHas('tags', function ($q) {
                    $q->whereIn('name', ['question', 'help', 'issue']);
                });
            }
        }
        $activities = $query->paginate(10);
        return view('pages.latest', compact('activities'));
    }
    public function tags(Request $request)
    {
        $search = $request->input('q');
        $query = Tag::withCount('snippets');
        $trendingTags = (clone $query)
            ->orderByDesc('snippets_count')
            ->take(2)
            ->get();
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        $tags = $query
            ->orderByDesc('snippets_count')
            ->orderBy('name')
            ->paginate(15); // Show 15 per page

        return view('pages.tags', compact('tags', 'trendingTags', 'search'));
    }
    public function createSnippet()
    {
        return view('pages.create-snippet');
    }
    public function profile()
    {
        return view('pages.profile');
    }
    public function frameworks()
    {
        return view('pages.frameworks');
    }
    public function showPost($id)
    {
        // In a real app, you would fetch the post: Post::findOrFail($id);
        return view('pages.post', ['id' => $id]);
    }

    public function profileOverview()
    {
        return view('pages.profile-pages.overview');
    }

    public function profileNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(15);
        return view('pages.profile-pages.notifications', compact('user', 'notifications'));
    }
    public function profileSnippets()
    {
        $user = Auth::user();
        $snippets = $user->snippets()
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('pages.profile-pages.my-snippets', compact('user', 'snippets'));
    }
    public function profileSettings()
    {
        return view('pages.profile'); // Your existing settings page
    }
}
