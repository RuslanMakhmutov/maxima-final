<?php

namespace App\Providers;

use App\Contracts\AdminCategoryServiceInterface;
use App\Contracts\AdminPostServiceInterface;
use App\Contracts\CommentServiceInterface;
use App\Contracts\PollutionServiceInterface;
use App\Contracts\PostServiceInterface;
use App\Contracts\StatisticsServiceInterface;
use App\Contracts\VisitServiceInterface;
use App\Models\Category;
use App\Models\Post;
use App\Services\Admin\AdminCategoryService;
use App\Services\Admin\AdminPostService;
use App\Services\Admin\StatisticsService;
use App\Services\CommentService;
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
        $this->app->bind(AdminPostServiceInterface::class, AdminPostService::class);
        $this->app->bind(AdminCategoryServiceInterface::class, AdminCategoryService::class);
        $this->app->bind(StatisticsServiceInterface::class, StatisticsService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }
}
