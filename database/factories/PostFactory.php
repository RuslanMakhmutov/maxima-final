<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (rand(1, 100) <= 10) {
            $url = 'https://dummyjson.com/image/400x200/' . fake()->hexColor() . '?type=png';
            $filename = Str::random() . '.png';
            $contents = file_get_contents($url);
            $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
            file_put_contents($path, $contents);
            $uploaded_file = new UploadedFile($path, $filename);
            $image = Storage::put('posts', $uploaded_file);
        }
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(60),
            'content' => fake()->paragraphs(rand(3,5), true),
            'image' => $image ?? null,
            'published_at' => fake()->boolean(90) ? now() : null,
        ];
    }
}
