<?php

namespace App\Repositories;

use App\Models\Visit;

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
}
