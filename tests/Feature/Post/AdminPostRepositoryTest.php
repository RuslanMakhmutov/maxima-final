<?php

namespace Tests\Feature\Post;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\AdminPostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AdminPostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected Post $model;
    protected AdminPostRepository $repository;
    protected Category $category;
    protected LengthAwarePaginator $paginator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock(Post::class);
        $this->repository = new AdminPostRepository($this->model);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
    }

    public function test_getList(): void
    {
        $result = (new AdminPostRepository(new Post()))->getList();
        $this->assertInstanceOf(LengthAwarePaginator::class, $result, 'The result should be an instance of Builder.');
    }
}
