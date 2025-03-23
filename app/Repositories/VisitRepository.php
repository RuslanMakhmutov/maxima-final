<?php

namespace App\Repositories;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VisitRepository extends BaseRepository
{
    public function __construct(Visit $model)
    {
        parent::__construct($model);
    }

    public function getVisitableCount(string $visitableType, int $visitableId): int
    {
        return $this->query()
            ->where('visitable_type', $visitableType)
            ->where('visitable_id', $visitableId)
            ->count();
    }

    public function getVisitStatistics(string $visitableType, Carbon $from, Carbon $to): Collection
    {
        $query = $this->query()
            ->where('visitable_type', $visitableType)
            ->whereBetween('created_at', [$from, $to]);

        $res = $query
            ->raw(function ($collection) {
                return $collection->aggregate([
                    [
                        '$group' => [
                            '_id' => [
                                '$dateToString' => [
                                    'format' => "%Y-%m-%d",
                                    'date' => '$created_at'
                                ]
                            ],
                            'count' => ['$sum' => 1],
                        ]
                    ],
                    ['$sort' => ['_id' => 1]]
                ]);
            });

        return collect($res)
            ->map(function (Visit $item) {
                return (object) [
                    'date' => $item->id,
                    'count' => $item->count,
                ];
            });
    }
}
