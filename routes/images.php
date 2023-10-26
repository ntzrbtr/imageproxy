<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Image Routes
|--------------------------------------------------------------------------
|
| Loaded in the RouteServiceProvider and assigned to the "images" middleware
| group (with less middleware to speed things up)
|
*/

Route::get('/image/{filename}', \App\Http\Controllers\ImageController::class)
    ->where('filename', '.*')
    ->name('image');
