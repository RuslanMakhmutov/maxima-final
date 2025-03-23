<?php

namespace App\Repositories;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class AdminCategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getList(): Collection
    {
        return $this->query()->get();
    }

    public function store(StoreCategoryRequest $request): Category
    {
        $data = $request->validated();
        $category = new $this->model($data);
        $category->save();

        return $category;
    }

    public function update(Category $category, UpdateCategoryRequest $request): Category
    {
        $data = $request->validated();
        $category->fill($data);
        $category->save();

        return $category;
    }

    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}
