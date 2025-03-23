<?php

namespace Tests\Feature\Post;

use App\Events\PostVisitEvent;
use App\Http\Resources\Post\PostsListResource;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PostRepository $repository;
    protected PostService $postService;
    protected LengthAwarePaginator $paginator;
    protected Category $category;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PostRepository::class);
        $this->postService = new PostService($this->repository);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
        $posts = Post::factory(12)->make([
            'user_id' => 11,
            'category_id' => 22,
        ]);
        $this->paginator = new LengthAwarePaginator($posts, 20, 12, 1);
    }

    /**
     * @throws Exception
     */
    public function test_IndexList(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getIndexList')
            ->willReturn($this->paginator);

        $response = $this->postService->indexList();
        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertEquals(12, $response->count());
    }

    public function test_CategoryList(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getCategoryList')
            ->willReturn($this->paginator);

        $response = $this->postService->categoryList($this->category);
        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertEquals(12, $response->count());

        $this->assertInstanceOf(PostsListResource::class, $response->random());
        $this->assertEquals(11, $response->first()->user_id);
        $this->assertEquals(22, $response->first()->category_id);
    }

    public function test_ShowPost(): void
    {
        Event::fake();

        $post = Post::factory()->makeOne();

        $response = $this->postService->showPost($post);
        $this->assertInstanceOf(Post::class, $response);

        Event::assertDispatched(PostVisitEvent::class);
    }
}
