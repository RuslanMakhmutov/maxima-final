<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function listQuery(): Builder
    {
        return $this->query()
            ->select([
                'id',
                'title',
                'description',
                'image',
                'category_id',
                'user_id',
                'created_at'
            ])
            ->whereNotNull('published_at')
            ->with([
                'category:id,title',
                'user:id,name',
            ]);
    }

    public function getIndexList(): LengthAwarePaginator
    {
        return $this->listQuery()->paginate(12)->onEachSide(0);
    }

    public function getCategoryList(Category $category): LengthAwarePaginator
    {
        return $this->listQuery()
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->paginate(12)
            ->onEachSide(0);
    }
}
