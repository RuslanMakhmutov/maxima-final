<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'post' => Post::class,
            'category' => Category::class,
        ]);
        Vite::prefetch(concurrency: 3);

        // для просмотра доступны только опубликованные посты
        Route::bind('postPublished', function (int $id) {
            return Post::where('id', $id)
                ->whereNotNull('published_at')
                ->firstOrFail();
        });
    }
}
