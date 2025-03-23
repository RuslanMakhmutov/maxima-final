<?php

namespace App\Services\Admin;

use App\Contracts\AdminCategoryServiceInterface;
use App\Contracts\VisitServiceInterface;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Admin\Category\AdminCategoryResource;
use App\Models\Category;
use App\Repositories\AdminCategoryRepository;
use Inertia\Inertia;

class AdminCategoryService implements AdminCategoryServiceInterface
{
    public function __construct(protected AdminCategoryRepository $repository)
    {
    }

    public function index(): \Inertia\Response
    {
        $categories = $this->repository->getList();

        $visitService = app(VisitServiceInterface::class);

        $categories->transform(function (Category $category) use ($visitService) {
            $category->setAttribute('visits_count', $visitService->getVisitableCount((new Category())->getMorphClass(), $category->id));
            return $category;
        });
        return Inertia::render('Admin/Category/Index', [
            'categories' => AdminCategoryResource::collection($categories)
        ]);
    }

    public function add(): \Inertia\Response
    {
        return Inertia::render('Admin/Category/Add');
    }

    public function store(StoreCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request);
        return to_route('admin.categories.index');
    }

    public function edit(Category $category): \Inertia\Response
    {
        return Inertia::render('Admin/Category/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Category $category, UpdateCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($category, $request);
        return to_route('admin.categories.index');
    }

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $this->repository->delete($category);
        return redirect()->back();
    }
}
