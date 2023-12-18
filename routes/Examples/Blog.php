<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix'     => 'examples',
        'middleware' => [
            // 'auth:sanctum',
            // 'can:examples.blog',
        ],
    ],
    function () {
        Route::apiResource('posts', \App\Http\Controllers\Examples\PostController::class);
    }
);
