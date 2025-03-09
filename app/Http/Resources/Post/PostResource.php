<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'categories' => CategoryResource::collection($this->categories),
            'category_id' => $this->category_id,
            'image' => $this->imageUrl,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at,
        ];
    }
}
