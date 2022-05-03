<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route to get information of an specific zip code
Route::prefix('zip-codes')->name('api.zip-codes.')->group( function () {
    Route::get('/{zip_code}',[ \App\Http\Controllers\ZipCodesController::class, 'show' ])->name('show');
});
