<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\OpenLibraryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('/register', AuthController::class.'@register')->name('register');
        Route::post('/login', AuthController::class.'@login')->name('login');
        Route::post('/logout', AuthController::class.'@logout')->name('logout');
});

Route::group([
        'middleware' => 'auth',
    ], function () {
        Route::resource('library', LibraryController::class);
        Route::get('openlibrary/search', OpenLibraryController::class.'@search')->name('openlibrary.search');

});