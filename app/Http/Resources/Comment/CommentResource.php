<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\UserResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    // public bool $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Comment $this */
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'root_id' => $this->root_id,
            'level' => $this->level,
            'post_id' => $this->post_id,
            $this->mergeWhen(!$this->deleted_at, [
                'content' => $this->content,
                'user' => UserResource::make($this->user),
            ]),
            'created_at' => $this->created_at,
            'is_deleted' => (bool)$this->deleted_at,
        ];
    }
}
