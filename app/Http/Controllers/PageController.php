<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $postRepository;

    // Dependency Injection
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function home()
    {
        // Use the repository method
        $posts = $this->postRepository->getFeed();

        return view('welcome', compact('posts'));
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
