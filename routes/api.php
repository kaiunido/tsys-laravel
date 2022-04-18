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

Route::middleware('auth:sanctum')->get('/usuario', function (Request $request) {
    return $request->user()->only(['name', 'email']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('paises', App\Http\Controllers\CountryController::class)
        ->parameters(['paises' => 'country'])
        ->names('country');

    Route::apiResource('idiomas', App\Http\Controllers\LanguageController::class)
        ->parameters(['idiomas' => 'language'])
        ->names('language');

    Route::apiResource('situacao-estoque', App\Http\Controllers\StockStatusController::class)
        ->parameters(['situacao-estoque' => 'stockStatus'])
        ->names('stockStatus');

    Route::apiResource('unidade-medida', App\Http\Controllers\LengthController::class)
        ->parameters(['unidade-medida' => 'length'])
        ->names('length');

    Route::apiResource('produtos', App\Http\Controllers\ProductController::class)
        ->parameters(['produtos' => 'product'])
        ->names('product');
});
