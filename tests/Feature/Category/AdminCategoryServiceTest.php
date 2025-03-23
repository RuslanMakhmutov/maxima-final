<?php

namespace Tests\Feature\Category;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\AdminCategoryRepository;
use App\Services\Admin\AdminCategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AdminCategoryRepository $repository;
    protected AdminCategoryService $service;
    protected Category $category;
    protected Collection $categories;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(AdminCategoryRepository::class);
        $this->service = new AdminCategoryService($this->repository);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
        $this->categories = Category::factory(10)->make([
            'id' => fake()->numberBetween(1, 10),
            'user_id' => 11,
            'category_id' => 22,
        ]);
    }

    public function test_Index(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getList')
            ->willReturn($this->categories);

        $response = $this->service->index();
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Add(): void
    {
        $response = $this->service->add();
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Edit(): void
    {
        $response = $this->service->edit($this->categories->random());
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Store(): void
    {
        $request = StoreCategoryRequest::create(
            '',
            'post',
            [
                'title' => 'test_title',
            ]
        );

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->willReturn($this->category);

        $response = $this->service->store($request);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Update(): void
    {
        $request = UpdateCategoryRequest::create(
            '',
            'post',
            [
                'title' => 'test_title',
            ]
        );

        $this->repository
            ->expects($this->once())
            ->method('update')
            ->willReturn($this->category);

        $response = $this->service->update($this->category, $request);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Delete(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $response = $this->service->destroy($this->category);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }
}
