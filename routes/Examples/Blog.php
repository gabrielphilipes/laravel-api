<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'examples'], function () {
    Route::resource('posts', \App\Http\Controllers\Examples\PostController::class);
});
