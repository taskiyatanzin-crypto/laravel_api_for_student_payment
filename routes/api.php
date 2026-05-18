<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StafftController;

// Public routes
Route::post('/register', [StafftController::class, 'store']);
Route::post('/login', [StafftController::class, 'login']);

// Protected / data route
Route::get('/staff', [StafftController::class, 'index']);
