<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Loaded in the RouteServiceProvider and assigned to the "web" middleware
| group
|
*/

Route::view('/', 'welcome')
    ->name('home');
