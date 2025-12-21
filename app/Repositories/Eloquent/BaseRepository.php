<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int|string $id, array $attributes): bool
    {
        $model = $this->model->find($id);
        return $model ? $model->update($attributes) : false;
    }

    public function delete(int|string $id): bool
    {
        $model = $this->model->find($id);
        return $model ? $model->delete() : false;
    }
}
