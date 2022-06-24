<?php

use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\post\PostController;
use App\Http\Controllers\website\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // 1. Client routes
    Route::group([
        'prefix' => 'clients',
        'as'     => 'client.'
    ], function () {
        Route::controller(ClientController::class)->group(function () {
            Route::post('/register', 'store')
                ->name('register');

            Route::post('/login', 'authenticate')
                ->name('login');

            Route::post('/logout', 'logout')
                ->name('logout')
                ->middleware('auth:sanctum');

            Route::post('/subscribe', 'subscribe')
                ->name('subscribe')
                ->middleware('auth:sanctum');
        });
    });

    // 2. Website routes
    Route::group([
        'prefix' => 'websites',
        'as'     => 'website.'
    ], function () {
        Route::controller(WebsiteController::class)->group(function () {
            Route::post('/', 'store')->name('store');
        });
    });

    // 3. Posts routes
    Route::group([
        'prefix' => 'posts',
        'as'     => 'post.'
    ], function () {
        Route::controller(PostController::class)->group(function () {
            Route::post('/', 'store')->name('store');
        });
    });
});
