<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\MetricsController;

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

Route::get('/calculator-widjet', [CalculatorController::class, 'calculatorWidjet']);
Route::get('/difficulty-widjet', [MetricsController::class, 'difficultyWidjet']);
Route::get('/metrics/network/{coin:name}/get-difficulty', [MetricsController::class, 'getDifficulty'])->name('metrics.network.get_difficulty');
