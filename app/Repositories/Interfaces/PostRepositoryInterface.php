<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function getFeed(int $perPage = 10): LengthAwarePaginator;
    public function findBySlug(string $slug);
    public function getByTag(string $tagSlug, int $perPage = 10);
}
