<?php

use App\Http\Controllers\Examples\{PostCommentController, PostController};
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'examples', 'middleware' => [
        // 'auth:sanctum', 'can:examples.blog'
    ]],
    function () {
        Route::apiResource('posts', PostController::class);
        Route::apiResource('posts.comments', PostCommentController::class);
    }
);
