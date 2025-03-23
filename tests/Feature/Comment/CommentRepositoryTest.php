<?php

namespace Tests\Feature\Comment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\AdminCategoryRepository;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected Category $model;
    protected CommentRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = new Post();
        $this->repository = new CommentRepository(new Comment());
    }

    public function test_getListForPost(): void
    {
        $response = $this->repository->getListForPost($this->post);
        $this->assertInstanceOf(Collection::class, $response);
    }
}
