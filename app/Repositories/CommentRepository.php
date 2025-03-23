<?php

namespace App\Repositories;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getListForPost(Post $post): Collection
    {
        return $post->comments()
            ->withTrashed()
            ->with([
                'user:id,name'
            ])
            ->orderBy('id')
            ->get();
    }

    public function store(StoreCommentRequest $request, Post $post): Comment
    {
        $data = $request->validated();

        $comment = new Comment($data);
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;

        if ($request->filled('parent_id')) {
            $parent = Comment::withTrashed()
                ->select(['level', 'root_id', 'content'])
                ->where('id', $data['parent_id'])
                ->firstOrFail();

            $comment->level = min($parent->level + 1, Comment::MAX_LEVEL);
            $comment->parent_id = $data['parent_id'];
            $comment->root_id = $parent->root_id;
        } else {
            $comment->level = 1;
        }

        $comment->save();

        if (empty($comment->root_id)) {
            $comment->root_id = $comment->id;
            $comment->save();
        }

        $comment->setRelation('user', Auth::user());

        return $comment;
    }

    public function delete(Comment $comment): ?bool
    {
        return $comment->delete();
    }

    public function getStatistics(Carbon $from, Carbon $to): Collection
    {
        $query = $this->query()
            ->select(DB::raw("DATE(created_at) as date"), DB::raw("count(*) as count"))
            ->whereBetween('created_at', [$from, $to]);

        return $query
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
