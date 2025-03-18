<?php

namespace App\Contracts;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;

interface AdminPostServiceInterface
{
    public function index(): \Inertia\Response;

    public function add(): \Inertia\Response;

    public function store(StorePostRequest $request): \Illuminate\Http\RedirectResponse;

    public function edit(Post $post): \Inertia\Response;

    public function update(Post $post, UpdatePostRequest $request): \Illuminate\Http\RedirectResponse;

    public function delete(Post $post): \Illuminate\Http\RedirectResponse;

    public function restore(Post $post): \Illuminate\Http\RedirectResponse;

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse;
}
