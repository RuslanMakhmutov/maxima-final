<?php

namespace App\Services;

use App\Events\PostVisitEvent;
use App\Http\Resources\Post\PostsListResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class PostService
{
    public function indexList(): AnonymousResourceCollection
    {
        $posts = $this->listQuery()->paginate(12)->onEachSide(0);
        return PostsListResource::collection($posts);
    }

    public function listQuery(): Builder
    {
        return Post::query()
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

    public function categoryList(Category $category): AnonymousResourceCollection
    {
        $posts = $this->listQuery()
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->paginate(12)
            ->onEachSide(0);
        return PostsListResource::collection($posts);
    }

    public function handleShowPost(Post $post): Post
    {
        PostVisitEvent::dispatch($post);

        $post->load([
            'categories:id,title',
            'user:id,name',
        ]);

        return $post;
    }

    public function getComments(Post $post): Collection
    {
        $list = $post->comments()
            ->with([
                'user:id,name'
            ])
            ->orderBy('id')
            ->get();

        $tree = new Collection();

        $res = $this->buildTree($list, $tree);

        return $res;
    }

    public function buildTree(Collection $plain_list, Collection &$tree, $parent_id = null): Collection
    {
        $nodes = $plain_list->where('parent_id', $parent_id);

        if ($nodes->isNotEmpty()) {
            foreach ($nodes as $node) {
                /* @var Comment $node */
                $tree->push($node);
                $this->buildTree($plain_list, $tree, $node->id);
            }
        }

        return $tree;
    }
}
