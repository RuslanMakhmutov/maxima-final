<?php

namespace App\Contracts;

use App\Events\PostVisitEvent;
use App\Http\Resources\Post\PostsListResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

interface PostServiceInterface
{
    public function indexList(): AnonymousResourceCollection;

    public function categoryList(Category $category): AnonymousResourceCollection;

    public function showPost(Post $post): Post;
}
