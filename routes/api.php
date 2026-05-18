<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StafftController;

Route::post('/register', [StafftController::class, 'store']);
Route::post('/login', [StafftController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/staff', [StafftController::class, 'index']);
    Route::post('/logout', [StafftController::class, 'logout']);
});
