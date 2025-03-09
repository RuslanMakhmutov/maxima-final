<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
            Category::factory()->create([
                'created_at' => now()->subSeconds(rand(86400 * 2, 86400 * 10)),
                'updated_at' => now()->subSeconds(rand(86400 * 1, 86400 * 2)),
            ]);
        }
    }
}
