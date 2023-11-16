<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('elevator/call', [\App\Http\Controllers\ElevatorsController::class, 'call']);
    Route::post('elevator/use', [\App\Http\Controllers\ElevatorsController::class, 'use']);
});
