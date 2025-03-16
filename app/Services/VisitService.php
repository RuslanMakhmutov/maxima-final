<?php

namespace App\Services;

use App\Contracts\VisitServiceInterface;
use App\Repositories\VisitRepository;

class VisitService implements VisitServiceInterface
{
    public function __construct(protected VisitRepository $repository)
    {
    }

    public function getVisitableCount(string $visitableType, int $visitableId): int
    {
        return $this->repository->getVisitableCount($visitableType, $visitableId);
    }
}
