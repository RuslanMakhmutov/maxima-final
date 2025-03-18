<?php

namespace App\Services\Admin;

use App\Contracts\AdminPostServiceInterface;
use App\Contracts\VisitServiceInterface;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Admin\Post\AdminPostResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\AdminPostRepository;
use Inertia\Inertia;

class AdminPostService implements AdminPostServiceInterface
{
    public function __construct(protected AdminPostRepository $repository)
    {
    }

    public function index(): \Inertia\Response
    {
        $posts = $this->repository->getList();

        $visitService = app(VisitServiceInterface::class);

        $posts->transform(function (Post $post) use ($visitService) {
            $post->setAttribute('visits_count', $visitService->getVisitableCount((new Post())->getMorphClass(), $post->id));
            return $post;
        });
        return Inertia::render('Admin/Post/Index', [
            'posts' => AdminPostResource::collection($posts),
            'only_trashed' => (bool)request()->query('only_trashed'),
        ]);
    }

    public function add(): \Inertia\Response
    {
        return Inertia::render('Admin/Post/Add', [
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }

    public function store(StorePostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request);
        return to_route('admin.posts.index');
    }

    public function edit(Post $post): \Inertia\Response
    {
        $post->load('categories');
        return Inertia::render('Admin/Post/Edit', [
            'post' => $post,
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }

    public function update(Post $post, UpdatePostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($post, $request);
        return to_route('admin.posts.index');
    }

    public function delete(Post $post): \Illuminate\Http\RedirectResponse
    {
        $this->repository->delete($post);
        return redirect()->back();
    }

    public function restore(Post $post): \Illuminate\Http\RedirectResponse
    {
        $this->repository->restore($post);
        return redirect()->back();
    }

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $this->repository->destroy($post);
        return redirect()->back();
    }
}
