<?php

namespace App\Repositories;

use App\Models\Post;
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
}
