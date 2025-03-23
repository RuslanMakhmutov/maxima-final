<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
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
        $posts = Post::select(['id', 'created_at'])->whereNotNull('published_at')->get();
        $categories = Category::select(['id', 'created_at'])->get();

        // создание просмотров постов и категорий
        for ($i = 0; $i < 2000; $i++) {
            $visitable = fake()->boolean(90) ? $posts->random() : $categories->random();
            $time = $visitable->created_at->addSeconds(rand(86400 * 1, 86400 * 6));
            Visit::factory()
                ->for($visitable, 'visitable')
                ->count(rand(2, 3))
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['user_id' => fake()->boolean() ? $users->random()->id : null],
                ))
                ->create([
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
        }
    }
}
