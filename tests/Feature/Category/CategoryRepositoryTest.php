<?php

namespace Tests\Feature\Category;
use App\Models\Category;
use App\Repositories\AdminCategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected Category $model;
    protected AdminCategoryRepository $repository;
    protected Category $category;
    protected LengthAwarePaginator $paginator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Category();
        $this->repository = new AdminCategoryRepository($this->model);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
    }

    public function test_getList(): void
    {
        $response = $this->repository->getList();
        $this->assertInstanceOf(Collection::class, $response);
    }
}
