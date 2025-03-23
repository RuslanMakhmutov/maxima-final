<?php

namespace App\Services;

use App\Contracts\CommentServiceInterface;
use App\Events\CommentDeletedEvent;
use App\Events\CommentStoredEvent;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class CommentService implements CommentServiceInterface
{
    public function __construct(protected CommentRepository $repository)
    {
    }

    public function getListForPost(Post $post): Collection
    {
        $list = $this->repository->getListForPost($post);

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
        $comment = $this->repository->store($request, $post);

        CommentStoredEvent::broadcast($comment)->toOthers();

        return response()->json([
            'comment' => new CommentResource($comment)
        ]);
    }

    public function delete(Comment $comment): JsonResponse
    {
        $this->repository->delete($comment);

        CommentDeletedEvent::broadcast($comment)->toOthers();

        return response()->json([
            'message' => 'ok',
        ]);
    }

    public function getStatistics(Carbon $from, Carbon $to): Collection
    {
        return $this->repository->getStatistics($from, $to)->keyBy('date');
    }
}
