<?php

namespace App\Services;

use App\Models\Pollution;

class PollutionService
{
    public function saveAirResponse(object $air): Pollution
    {
        $id = "{$air->coord->lat}_{$air->coord->lon}_{$air->list[0]->dt}";

        $pollution = Pollution::find($id);

        if (empty($pollution)) {
            $pollution = Pollution::make([
                'coord' => $air->coord,
                'dt' => $air->list[0]->dt,
                'main' => $air->list[0]->main,
                'components' => $air->list[0]->components,
            ]);
            $pollution->id = $id;
            $pollution->save();
        }

        return $pollution;
    }
}
