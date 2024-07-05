<?php

use App\Http\Controllers\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenLibraryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'auth:sanctum',
], function () {
    Route::post('/register', ApiAuthController::class.'@register')->name('register');
    Route::post('/login', ApiAuthController::class.'@login')->name('login');
    Route::post('/logout', ApiAuthController::class.'@logout')->name('logout');
});