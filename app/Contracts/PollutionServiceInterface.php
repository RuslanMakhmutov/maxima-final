<?php

namespace App\Contracts;

use App\DTO\airDTO;
use App\Models\Pollution;

interface PollutionServiceInterface {

    public function saveAirResponse(airDTO $air): Pollution;
}
