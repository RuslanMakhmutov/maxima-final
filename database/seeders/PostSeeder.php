<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $images = collect();
        for ($i = 0; $i < 10; $i++) {
            $color1 = trim(fake()->hexColor(), '#');
            $color2 = trim(fake()->hexColor(), '#');
            $word = fake()->word();

            $url = "https://dummyjson.com/image/400x200/{$color1}/{$color2}?text={$word}";
            $filename = Str::random() . '.png';
            $contents = file_get_contents($url);
            $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
            file_put_contents($path, $contents);
            $uploaded_file = new UploadedFile($path, $filename);
            $image = Storage::put('posts', $uploaded_file);
            $images->push($image);
        }

        for ($i = 0; $i < 20; $i++) {
            $posts = [];
            for ($n = 0; $n < 50; $n++) {
                $post_categories = $categories->random(rand(1, 3));
                $post = Post::factory()
                    ->for($users->random())
                    ->hasAttached($post_categories)
                    ->make([
                        'created_at' => now()->subSeconds(rand(86400 * 0, 86400 * 31)),
                        'updated_at' => now()->subSeconds(rand(86400 * 0, 86400 * 10)),
                        'category_id' => $post_categories->first()->id,
                        'published_at' => fake()->boolean(90) ? now() : null,
                        'image' => $images->random() ?? null,
                    ]);
                $posts[] = $post->makeHidden(['image_url'])->toArray();

                if (empty($logged)) {
                    $logged = true;
                    Log::debug('post', $post->makeHidden(['image_url'])->toArray());
                }
            }
            Post::insert($posts);
        }

        $posts = Post::query()
            ->select(['id', 'created_at', 'category_id'])
            ->get();

        foreach ($posts->chunk(500) as $chunk) {
            DB::table('category_post')
                ->insert(
                    $chunk
                        ->map(function ($post) {
                            return [
                                'category_id' => $post->category_id,
                                'post_id' => $post->id,
                                'created_at' => $post->created_at->toDateTimeString(),
                                'updated_at' => $post->created_at->toDateTimeString(),
                            ];
                        })
                        ->toArray()
                );
        }
    }
}
