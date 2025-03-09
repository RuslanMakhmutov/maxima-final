<?php

namespace App\Services;

use App\Events\PostVisitEvent;
use App\Http\Resources\Post\PostsListResource;
use App\Models\CartesianPoint;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class CartesianPointService
{
    public function closestTo(float $x, float $y, float $max_distance = 0.01)
    {
        return CartesianPoint::query()
            ->select([
                'id',
                'pos',
            ])
            ->selectRaw("pos <-> point '({$x},{$y})' as distance")
            ->whereRaw("pos <-> point '({$x},{$y})' <= {$max_distance}")
            ->orderByRaw("pos <-> point '({$x},{$y})'")
            ->limit(10)
            ->get();
    }
}
