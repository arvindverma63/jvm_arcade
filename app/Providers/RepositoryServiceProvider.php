<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\SnippetRepositoryInterface;
// Implementations
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Eloquent\SnippetRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(SnippetRepositoryInterface::class, SnippetRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
