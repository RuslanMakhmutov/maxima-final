<?php

namespace App\Services;

use App\Contracts\PollutionServiceInterface;
use App\DTO\airDTO;
use App\Models\Pollution;
use App\Repositories\PollutionRepository;

class PollutionService implements PollutionServiceInterface
{
    public function __construct(protected PollutionRepository $repository)
    {
    }

    public function saveAirResponse(airDTO $air): Pollution
    {
        $pollution = $this->repository->getItemByAir($air);

        if (empty($pollution)) {
            $pollution = $this->repository->createItemFromAir($air);
        }

        return $pollution;
    }
}
