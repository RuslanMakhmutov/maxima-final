<?php

namespace Tests\Feature\Comment;

use App\Events\CommentDeletedEvent;
use App\Events\CommentStoredEvent;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Services\CommentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CommentRepository $repository;
    protected CommentService $service;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(CommentRepository::class);
        $this->service = new CommentService($this->repository);
    }

    public function test_getListForPost(): void
    {
        $post = Post::factory()->makeOne();
        $comments = Comment::factory()->count(10)->make([
            'id' => fake()->numberBetween(1, 10),
            'parent_id' => null,
            'level' => 1,
        ]);
        $this->repository
            ->expects($this->once())
            ->method('getListForPost')
            ->willReturn($comments);

        $response = $this->service->getListForPost($post);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_buildPlainTree(): void
    {
        $comments = Comment::factory()->count(10)->make([
            'id' => fake()->numberBetween(1, 10),
            'parent_id' => null,
            'level' => 1,
        ]);

        $collection = collect();
        $response = $this->service->buildPlainTree($comments, $collection);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_Store(): void
    {
        Event::fake();

        $request = StoreCommentRequest::create(
            '',
            'post',
            [
                'content' => 'test_content',
                'parent_id' => null
            ]
        );

        $post = Post::factory()->makeOne($request->all());
        $comment = Comment::factory()->makeOne($request->all());

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->willReturn($comment);

        $response = $this->service->store($request, $post);
        $this->assertInstanceOf(JsonResponse::class, $response);

        Event::assertDispatched(CommentStoredEvent::class);
    }

    public function test_Delete(): void
    {
        Event::fake();

        $comment = Comment::factory()->makeOne();

        $this->repository
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $response = $this->service->delete($comment);
        $this->assertInstanceOf(JsonResponse::class, $response);

        Event::assertDispatched(CommentDeletedEvent::class);
    }

    public function test_getStatistics(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getStatistics')
            ->willReturn(collect());

        $response = $this->service->getStatistics(Carbon::now()->subMonth(), Carbon::now());
        $this->assertInstanceOf(Collection::class, $response);
    }
}
