<?php

namespace App\Services;

use App\Contracts\PostServiceInterface;
use App\Events\PostVisitEvent;
use App\Http\Resources\Post\PostsListResource;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostService implements PostServiceInterface
{
    public function __construct(protected PostRepository $repository)
    {
    }

    public function indexList(): AnonymousResourceCollection
    {
        $posts = $this->repository->getIndexList();
        return PostsListResource::collection($posts);
    }

    public function categoryList(Category $category): AnonymousResourceCollection
    {
        $posts = $this->repository->getCategoryList($category);
        return PostsListResource::collection($posts);
    }

    public function showPost(Post $post): Post
    {
        PostVisitEvent::dispatch($post);

        $post->load([
            'categories:id,title',
            'user:id,name',
        ]);

        return $post;
    }
}
