<?php

namespace App\Services;

use App\Contracts\VisitServiceInterface;
use App\Repositories\VisitRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VisitService implements VisitServiceInterface
{
    public function __construct(protected VisitRepository $repository)
    {
    }

    public function getVisitableCount(string $visitableType, int $visitableId): int
    {
        return $this->repository->getVisitableCount($visitableType, $visitableId);
    }

    public function getStatistics(string $visitableType, Carbon $from, Carbon $to): Collection
    {
        return $this->repository->getVisitStatistics($visitableType, $from, $to)->keyBy('date');
    }
}
