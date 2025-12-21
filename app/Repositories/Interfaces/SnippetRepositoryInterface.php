<?php

namespace App\Repositories\Interfaces;

interface SnippetRepositoryInterface extends BaseRepositoryInterface
{
    public function getLatest(int $limit = 6);
    public function getByUser(string $userId);
}
