<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});
Route::post('/register', AuthController::class.'@register')->name('register');
Route::post('/login', AuthController::class.'@login')->name('login');
Route::post('/logout', AuthController::class.'@logout')->name('logout');