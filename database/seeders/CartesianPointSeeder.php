<?php

namespace Database\Seeders;

use App\Models\CartesianPoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartesianPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 1000; $i++) {
            $points = [];
            for ($j = 0; $j < 1000; $j++) {
                $x = fake()->randomFloat(6, 0, 1);
                $y = fake()->randomFloat(6, 0, 1);
                $points[] = [
                    'pos' => DB::raw("point '({$x},{$y})'")
                ];
            }
            CartesianPoint::insert($points);
        }
    }
}
