<?php

namespace App\Repositories;

use App\DTO\airDTO;
use App\Models\Pollution;

class PollutionRepository extends BaseRepository
{
    public function __construct(Pollution $model)
    {
        parent::__construct($model);
    }

    public function getItemByAir(airDTO $air): ?Pollution
    {
        $id = $this->getIdForAir($air);

        return $this->query()
            ->find($id);
    }

    public function createItemFromAir(airDTO $air): Pollution
    {
        $id = $this->getIdForAir($air);

        $pollution = $this->query()
            ->make([
                'coord' => $air->coord,
                'dt' => $air->list[0]->dt,
                'main' => $air->list[0]->main,
                'components' => $air->list[0]->components,
            ]);

        $pollution->id = $id;
        $pollution->save();

        return $pollution;
    }

    public function getIdForAir(airDTO $air): string
    {
        return "{$air->coord->lat}_{$air->coord->lon}_{$air->list[0]->dt}";
    }
}
