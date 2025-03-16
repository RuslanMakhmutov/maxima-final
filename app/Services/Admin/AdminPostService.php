<?php

namespace App\Services\Admin;

use App\Contracts\VisitServiceInterface;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Admin\Post\AdminPostResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminPostService
{
    public function index(): \Inertia\Response
    {
        $query = Post::with('categories')
            ->withCount([
                'comments' => fn ($q) => $q->withTrashed(),
                // 'visits', // не поддерживается MongoDB
            ])
            ->orderByDesc('id');

        if (request()->query('only_trashed')) {
            $query->onlyTrashed();
        }
        $posts = $query->paginate(10);

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
        $data = $request->validated();

        $post = new Post($data);
        $post->user_id = Auth::id();
        if ($data['published']) {
            $post->published_at = now();
        }
        if ($request->hasFile('image')) {
            $post->image = Storage::put('posts', $request->file('image'));
        }
        $post->save();

        if (empty($data['categories']) || !in_array($data['category_id'], $data['categories'])) {
            $data['categories'][] = $data['category_id'];
        }

        $post->categories()->sync($data['categories']);

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
        $data = $request->validated();

        $post->fill($data);
        if ($data['published']) {
            if (!$post->published_at) {
                $post->published_at = now();
            }
        } else {
            $post->published_at = null;
        }

        // удаление старого файла, если передали новый файл просто попросили удалить файл
        if ($request->hasFile('image') || $request->has('delete_image')) {
            $post->deleteImage();
        }
        if ($request->hasFile('image')) {
            $post->image = Storage::put('posts', $request->file('image'));
        }
        $post->save();

        if (empty($data['categories']) || !in_array($data['category_id'], $data['categories'])) {
            $data['categories'][] = $data['category_id'];
        }

        $post->categories()->sync($data['categories']);

        return to_route('admin.posts.index');
    }

    public function delete(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->delete();
        return redirect()->back();
    }

    public function restore(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->restore();
        return redirect()->back();
    }

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->deleteImage();
        $post->forceDelete();
        return redirect()->back();
    }
}
