<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StafftController;

Route::post('/login', [StafftController::class, 'login']);
Route::post('/register', [StafftController::class, 'store']);


Route::middleware(['auth:sanctum', 'role:Manager,Admin'])
    ->get('/staff', [StafftController::class, 'index']);
