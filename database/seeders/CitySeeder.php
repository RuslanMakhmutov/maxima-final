<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'title' => 'Москва',
                'lat' => 55.7504461,
                'lon' => 37.6174943
            ],
            [
                'title' => 'Казань',
                'lat' => 55.7823547,
                'lon' => 49.1242266
            ],
            [
                'title' => 'Калининград',
                'lat' => 54.7101287,
                'lon' => 20.5105838
            ],
            [
                'title' => 'Детройт',
                'lat' => 42.3315509,
                'lon' => -83.0466403
            ],
            [
                'title' => 'Дубай',
                'lat' => 25.2653471,
                'lon' => 55.2924914
            ],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                [
                    'title' => $city['title']
                ],
                [
                    'lat' => $city['lat'],
                    'lon' => $city['lon']
                ]
            );
        }
    }
}
