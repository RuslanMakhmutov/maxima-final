<?php

namespace App\Contracts;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

interface AdminCategoryServiceInterface
{
    public function index(): \Inertia\Response;

    public function add(): \Inertia\Response;

    public function store(StoreCategoryRequest $request): \Illuminate\Http\RedirectResponse;

    public function edit(Category $category): \Inertia\Response;

    public function update(Category $category, UpdateCategoryRequest $request): \Illuminate\Http\RedirectResponse;

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse;
}
