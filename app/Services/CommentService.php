<?php

namespace App\Services;

use App\Events\CommentDeletedEvent;
use App\Events\CommentStoredEvent;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function getListForPost(Post $post): Collection
    {
        $list = $post->comments()
            ->withTrashed()
            ->with([
                'user:id,name'
            ])
            ->orderBy('id')
            ->get();

        $tree = new Collection();

        return $this->buildPlainTree($list, $tree);
    }

    public function buildPlainTree(Collection $plain_list, Collection &$tree, $parent_id = null): Collection
    {
        $nodes = $plain_list->where('parent_id', $parent_id);

        if ($nodes->isNotEmpty()) {
            foreach ($nodes as $node) {
                /* @var Comment $node */
                $tree->push($node);
                $this->buildPlainTree($plain_list, $tree, $node->id);
            }
        }

        return $tree;
    }

    public function store(StoreCommentRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();

        $comment = new Comment($data);
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;

        if ($request->filled('parent_id')) {
            $parent = Comment::withTrashed()
                ->select(['level', 'root_id', 'content'])
                ->where('id', $data['parent_id'])
                ->firstOrFail();

            $comment->level = min($parent->level + 1, Comment::MAX_LEVEL);
            $comment->parent_id = $data['parent_id'];
            $comment->root_id = $parent->root_id;
        } else {
            $comment->level = 1;
        }

        $comment->save();

        if (empty($comment->root_id)) {
            $comment->root_id = $comment->id;
            $comment->save();
        }

        $comment->setRelation('user', Auth::user());

        CommentStoredEvent::broadcast($comment)->toOthers();

        return response()->json([
            'comment' => new CommentResource($comment)
        ]);
    }

    public function delete(Comment $comment): JsonResponse
    {
        $comment->delete();

        CommentDeletedEvent::broadcast($comment)->toOthers();

        return response()->json([
            'message' => 'ok',
        ]);
    }
}
