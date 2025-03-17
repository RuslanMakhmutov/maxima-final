<?php

namespace App\Http\Controllers\API;

use App\Events\PostVisitEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function list(PostService $postService): AnonymousResourceCollection
    {
        return $postService->indexList();
    }

    public function item(Post $post, PostService $postService): \Illuminate\Http\JsonResponse
    {
        $post = $postService->showPost($post);

        return response()->json([
            'post' => PostResource::make($post),
        ]);
    }

    public function comments(Post $post, CommentService $commentService): \Illuminate\Http\JsonResponse
    {
        $comments = $commentService->getListForPost($post);
        return response()->json([
            'comments' => CommentResource::collection($comments),
        ]);
    }
}
