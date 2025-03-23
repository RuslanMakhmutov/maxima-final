<?php

namespace Tests\Feature\Post;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected Post $model;
    protected PostRepository $repository;
    protected Category $category;
    protected LengthAwarePaginator $paginator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Post();
        $this->repository = new PostRepository($this->model);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
    }

    public function test_listQuery(): void
    {

        $result = $this->repository->listQuery();
        $this->assertInstanceOf(Builder::class, $result, 'The result should be an instance of Builder.');
    }

    public function test_getIndexList(): void
    {
        $response = $this->repository->getIndexList();
        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
    }

    public function test_getCategoryList(): void
    {
        $response = $this->repository->getCategoryList($this->category);
        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
    }
}
