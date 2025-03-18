<?php

namespace App\Repositories;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getList(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->query()
            ->with('categories')
            ->withCount([
                'comments' => fn ($q) => $q->withTrashed(),
                // 'visits', // не поддерживается MongoDB
            ])
            ->with([
                'category:id,title',
                'user:id,name',
            ])
            ->orderByDesc('id');

        if (request()->query('only_trashed')) {
            $query->onlyTrashed();
        }

        return $query->paginate(10);
    }

    public function store(StorePostRequest $request): Post
    {
        $data = $request->validated();
        $post = new $this->model($data);
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

        return $post;
    }

    public function update(Post $post, UpdatePostRequest $request): Post
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

        // удаление старого файла, если передали новый файл или просто попросили удалить файл
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

        return $post;
    }

    public function delete(Post $post): ?bool
    {
        return $post->delete();
    }

    public function restore(Post $post): void
    {
        $post->restore();
    }

    public function destroy(Post $post): void
    {
        $post->deleteImage();
        $post->forceDelete();
    }
}
