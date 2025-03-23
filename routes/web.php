<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('index');
        Route::get('add', [AdminPostController::class, 'add'])->name('add');
        Route::post('store', [AdminPostController::class, 'store'])->name('store');
        Route::get('{post}/edit', [AdminPostController::class, 'edit'])->name('edit');
        Route::put('{post}/update', [AdminPostController::class, 'update'])->name('update');
        Route::delete('{post}/delete', [AdminPostController::class, 'delete'])->name('delete');
        Route::put('{post}/restore', [AdminPostController::class, 'restore'])->name('restore')->withTrashed();
        Route::delete('{post}/destroy', [AdminPostController::class, 'destroy'])->name('destroy')->withTrashed();
    });
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('/', [StatisticsController::class, 'index'])->name('index');
    });
});

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('category/{category}', [PostController::class, 'category'])->name('category');
    Route::get('{postPublished}', [PostController::class, 'show'])->name('show');

    Route::middleware(['auth'])->prefix('{postPublished}/comments')->name('comments.')->group(function () {
        Route::post('', [CommentController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('comments')->name('comments.')->group(function () {
    Route::delete('{comment}', [CommentController::class, 'delete'])->name('delete');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
