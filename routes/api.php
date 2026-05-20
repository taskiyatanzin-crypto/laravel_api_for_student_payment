<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StafftController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;

Route::post('/register', [StafftController::class, 'store']);
Route::post('/login', [StafftController::class, 'login']);
Route::get('/students', [StudentController::class, 'index']);
Route::post('/student_create', [StudentController::class, 'store']);

Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/staff', [StafftController::class, 'index']);
    Route::post('/logout', [StafftController::class, 'logout']);
});
