<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenLibraryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'openlibrary',
], function () {
    Route::get('/search', OpenLibraryController::class.'@search')->name('openlibrary.search');
});