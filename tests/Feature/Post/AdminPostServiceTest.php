<?php

namespace Tests\Feature\Post;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\AdminPostRepository;
use App\Services\Admin\AdminPostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AdminPostServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AdminPostRepository $repository;
    protected AdminPostService $postService;
    protected LengthAwarePaginator $paginator;
    protected Category $category;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(AdminPostRepository::class);
        $this->postService = new AdminPostService($this->repository);

        $this->category = Category::factory()->makeOne();
        $this->category->id = 22;
        $posts = Post::factory(10)->make([
            'id' => fake()->numberBetween(1, 10),
            'user_id' => 11,
            'category_id' => 22,
        ]);
        $this->paginator = new LengthAwarePaginator($posts, 20, 12, 1);
    }

    public function test_Index(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getList')
            ->willReturn($this->paginator);

        $response = $this->postService->index();
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Add(): void
    {
        $response = $this->postService->add();
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Edit(): void
    {
        $response = $this->postService->edit($this->paginator->random());
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Store(): void
    {
        $request = StorePostRequest::create(
            '',
            'post',
            [
                'title' => 'test_title',
                'content' => 'test_content',
                'category_id' => fake()->numberBetween(1, 10),
                'published' => 'true',
            ]
        );

        $post = Post::factory()->makeOne($request->all());

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->willReturn($post);

        $response = $this->postService->store($request);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Update(): void
    {
        $request = UpdatePostRequest::create(
            '',
            'post',
            [
                'title' => 'test_title',
                'content' => 'test_content',
                'category_id' => fake()->numberBetween(1, 10),
                'published' => 'true',
            ]
        );

        $post = Post::factory()->makeOne($request->all());

        $this->repository
            ->expects($this->once())
            ->method('update')
            ->willReturn($post);

        $response = $this->postService->update($post, $request);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Delete(): void
    {
        $post = Post::factory()->makeOne();

        $this->repository
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $response = $this->postService->delete($post);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Restore(): void
    {
        $post = Post::factory()->makeOne();

        $this->repository
            ->expects($this->once())
            ->method('restore');

        $response = $this->postService->restore($post);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_Destroy(): void
    {
        $post = Post::factory()->makeOne();

        $this->repository
            ->expects($this->once())
            ->method('destroy');

        $response = $this->postService->destroy($post);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }
}
