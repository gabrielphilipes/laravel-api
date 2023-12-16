<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'examples',
        //        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::apiResource('posts', \App\Http\Controllers\Examples\PostController::class);
    }
);
