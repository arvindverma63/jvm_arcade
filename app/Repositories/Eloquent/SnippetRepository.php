<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\SnippetRepositoryInterface;
use App\Models\Snippet;

class SnippetRepository extends BaseRepository implements SnippetRepositoryInterface
{
    public function __construct(Snippet $model)
    {
        parent::__construct($model);
    }

    public function getLatest(int $limit = 6)
    {
        return $this->model->with('user')->latest()->take($limit)->get();
    }

    public function getByUser(string $userId)
    {
        return $this->model->where('user_id', $userId)->latest()->get();
    }
}
