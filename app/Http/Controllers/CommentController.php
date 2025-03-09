<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post, CommentService $commentService)
    {
        return $commentService->store($request, $post);
    }

    public function delete(Comment $comment, CommentService $commentService)
    {
        return $commentService->delete($comment);
    }
}
