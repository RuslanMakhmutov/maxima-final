<?php

namespace Post;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected PostRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new PostRepository(new Post());
    }

    public function test_listQuery(): void
    {
        $result = $this->repository->listQuery();
        $this->assertInstanceOf(Builder::class, $result, 'The result should be an instance of Builder.');
    }
}
