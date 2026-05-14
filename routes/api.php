<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\API\Ad\AdController;

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

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('/ads/get', [AdController::class, 'get']);
    });
});

Route::get('/calculator-widjet', [CalculatorController::class, 'calculatorWidjet']);
Route::get('/difficulty-widjet/{coin:name}', [MetricsController::class, 'difficultyWidjet']);
Route::get('/metrics/network/{coin:name}/get-difficulty', [MetricsController::class, 'getDifficulty'])->name('metrics.network.get_difficulty');
