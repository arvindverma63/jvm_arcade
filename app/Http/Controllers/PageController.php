<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\SnippetRepositoryInterface;
use Illuminate\Http\Request;

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

    public function latest()
    {
        return view('pages.latest');
    }
    public function tags()
    {
        return view('pages.tags');
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
        return view('pages.profile-pages.notifications');
    }

    public function profileSnippets()
    {
        return view('pages.profile-pages.my-snippets');
    }

    public function profileSettings()
    {
        return view('pages.profile'); // Your existing settings page
    }
}
