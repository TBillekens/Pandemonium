<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
});

Route::group(
    [
        'prefix' => 'auth',
    ], function () {
        Route::post('/register', AuthController::class.'@register')->name('register');
        Route::post('/login', AuthController::class.'@login')->name('login');
        Route::post('/logout', AuthController::class.'@logout')->name('logout');
});

Route::group(
    [
        'prefix' => 'library',
    ], function () {
    Route::get('/', LibraryController::class.'@index')->name('library-index');
    Route::get('/{id}', LibraryController::class.'@show')->name('library-show');
    Route::post('/', LibraryController::class.'@create')->name('library-create');
    Route::put('/{id}', LibraryController::class.'@edit')->name('library-edit');
    Route::delete('/{id}', LibraryController::class.'@delete')->name('library-delete');
});