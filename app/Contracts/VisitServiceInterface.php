<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface VisitServiceInterface
{
    public function getVisitableCount(string $visitableType, int $visitableId): int;
    public function getStatistics(string $visitableType, Carbon $from, Carbon $to): Collection;
}
