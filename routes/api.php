<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::controller(AuthController::class)->name('auth.')->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'list'])->name('list');
        Route::get('{postPublished}', [PostController::class, 'item'])->name('item');
        Route::get('{postPublished}/comments', [PostController::class, 'comments'])->name('comments');
    });

    // TODO добавить недостающие маршруты при необходимости
});
