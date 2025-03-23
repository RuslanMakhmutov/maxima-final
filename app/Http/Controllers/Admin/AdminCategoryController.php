<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\AdminCategoryService;

class AdminCategoryController extends Controller
{
    public function index(AdminCategoryService $service)
    {
        return $service->index();
    }

    public function create(AdminCategoryService $service)
    {
        return $service->add();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, AdminCategoryService $service)
    {
        return $service->store($request);
    }

    public function edit(Category $category, AdminCategoryService $service)
    {
        return $service->edit($category);
    }

    public function update(Category $category, UpdateCategoryRequest $request, AdminCategoryService $service)
    {
        return $service->update($category, $request);
    }

    public function destroy(Category $category, AdminCategoryService $service)
    {
        return $service->destroy($category);
    }
}
