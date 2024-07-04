<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});


Route::post('/register', AuthController::class.'@register')->name('register');
Route::post('/login', AuthController::class.'@login')->name('login');
Route::post('/logout', AuthController::class.'@logout')->name('logout');