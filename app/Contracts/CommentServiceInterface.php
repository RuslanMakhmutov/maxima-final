<?php

namespace App\Contracts;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface CommentServiceInterface
{
    public function getListForPost(Post $post): Collection;

    public function buildPlainTree(Collection $plain_list, Collection &$tree, $parent_id = null): Collection;

    public function store(StoreCommentRequest $request, Post $post): JsonResponse;

    public function delete(Comment $comment): JsonResponse;
    public function getStatistics(Carbon $from, Carbon $to): Collection;
}
