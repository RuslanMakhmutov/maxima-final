<?php

namespace App\Contracts;

interface VisitServiceInterface {

    public function getVisitableCount(string $visitableType, int $visitableId): int;
}
