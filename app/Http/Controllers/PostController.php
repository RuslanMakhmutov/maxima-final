<?php

namespace App\Http\Controllers;

use App\Events\CategoryVisitEvent;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(PostService $postService): \Inertia\Response
    {
        return Inertia::render('Post/Index', [
            'posts' => $postService->indexList(),
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }

    public function category(Category $category, PostService $postService): \Inertia\Response
    {
        CategoryVisitEvent::dispatch($category);

        return Inertia::render('Post/Category', [
            'category' => $category,
            'posts' => $postService->categoryList($category),
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }

    public function show(Post $post, PostService $postService, CommentService $commentService)
    {
        $post = $postService->showPost($post);
        $comments = $commentService->getListForPost($post);

        return Inertia::render('Post/Show', [
            'post' => PostResource::make($post),
            'comments' => CommentResource::collection($comments),
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }
}
