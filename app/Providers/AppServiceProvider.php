<?php

namespace App\Providers;

use App\Contracts\PollutionServiceInterface;
use App\Contracts\PostServiceInterface;
use App\Contracts\VisitServiceInterface;
use App\Models\Category;
use App\Models\Post;
use App\Services\PollutionService;
use App\Services\PostService;
use App\Services\VisitService;
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
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
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

        $this->app->bind(VisitServiceInterface::class, VisitService::class);
        $this->app->bind(PollutionServiceInterface::class, PollutionService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
    }
}
