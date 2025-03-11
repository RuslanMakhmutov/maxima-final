<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::select('id')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('title', 'admin');
            })
            ->get();
        $categories = Category::select('id')->get();

        for ($i = 0; $i < 500; $i++) {
            $post_categories = $categories->random(rand(1, 3));
            Post::factory()
                ->for($users->random())
                ->hasAttached($post_categories)
                ->create([
                    'created_at' => now()->subSeconds(rand(86400 * 4, 86400 * 10)),
                    'updated_at' => now()->subSeconds(rand(86400 * 1, 86400 * 4)),
                    'category_id' => $post_categories->first()->id,
                    'published_at' => fake()->boolean(90) ? now() : null,
                ]);
        }
    }
}
