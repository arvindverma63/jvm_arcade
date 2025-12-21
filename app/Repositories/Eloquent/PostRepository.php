<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getFeed(int $perPage = 10): LengthAwarePaginator
    {
        // Eager load User and Profile to avoid N+1 queries
        return $this->model->with(['user.profile', 'tags'])
                           ->latest()
                           ->paginate($perPage);

    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)
                           ->with(['user', 'comments.user', 'tags'])
                           ->firstOrFail();
    }

    public function getByTag(string $tagSlug, int $perPage = 10)
    {
        return $this->model->whereHas('tags', function($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        })->with(['user', 'tags'])->latest()->paginate($perPage);
    }
}
