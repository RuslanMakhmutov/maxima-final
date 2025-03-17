<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    function __construct(protected Model $model)
    {
    }

    protected function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function getItemById(int|string $id): ?Model
    {
        return $this->query()->find($id);
    }
}
