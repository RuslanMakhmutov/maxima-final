<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\Admin\AdminPostService;
use Illuminate\Http\JsonResponse;

class AdminPostController extends Controller
{
    public function index(AdminPostService $postService)
    {
        return $postService->index();
    }

    public function add(AdminPostService $postService)
    {
        return $postService->add();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, AdminPostService $postService)
    {
        return $postService->store($request);
    }

    public function edit(Post $post, AdminPostService $postService)
    {
        return $postService->edit($post);
    }

    public function update(Post $post, UpdatePostRequest $request, AdminPostService $postService)
    {
        return $postService->update($post, $request);
    }

    public function delete(Post $post, AdminPostService $postService)
    {
        return $postService->delete($post);
    }

    public function restore(Post $post, AdminPostService $postService)
    {
        return $postService->restore($post);
    }

    public function destroy(Post $post, AdminPostService $postService)
    {
        return $postService->destroy($post);
    }
}
