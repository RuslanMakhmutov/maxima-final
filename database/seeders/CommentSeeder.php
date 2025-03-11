<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::select('id')->get();
        $posts = Post::select(['id', 'created_at'])->whereNotNull('published_at')->get();

        // создание комментариев первого уровня
        for ($i = 0; $i < 100; $i++) {
            $post = $posts->random();
            $time = $post->created_at->addSeconds(rand(3600 * 1, 3600 * 2));
            Comment::factory()
                ->for($users->random())
                ->create([
                    'post_id' => $post->id,
                    'level' => 1,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
        }

        // создание комментариев второго, третьего, четвертого уровней
        for ($level = 1; $level <= 3; $level++) {
            $comments_of_level = Comment::select(['id', 'post_id', 'root_id', 'level', 'created_at'])->where('level', $level)->get();

            $count_to_add = rand(100, 200);
            for ($i = 0; $i < $count_to_add; $i++) {
                $parent_comment = $comments_of_level->random();
                $time = $parent_comment->created_at->addSeconds(rand(3600 * 1, 3600 * 2));
                Comment::factory()
                    ->for($users->random())
                    ->create([
                        'post_id' => $parent_comment->post_id,
                        'parent_id' => $parent_comment->id,
                        'root_id' => $parent_comment->root_id,
                        'level' => $level + 1,
                        'created_at' => $time,
                        'updated_at' => $time,
                    ]);
            }
        }
    }
}
