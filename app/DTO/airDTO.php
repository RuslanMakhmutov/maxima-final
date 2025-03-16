<?php

namespace App\DTO;

use Illuminate\Http\Client\Response;

readonly class airDTO
{
    public function __construct(public object $coord, public array $list)
    {
    }

    public static function fromOpenWeatherResponse(Response $response)
    {
        return new self(
            (object) $response->json()['coord'],
            [
                (object) $response->json()['list'][0]
            ]
        );
    }
}
