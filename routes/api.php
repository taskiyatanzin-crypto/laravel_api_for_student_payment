<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StafftController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;



Route::post('/register', [StafftController::class, 'store']);
Route::post('/login', [StafftController::class, 'login']);
Route::get('/students', [StudentController::class, 'index']);
Route::post('/student_create', [StudentController::class, 'store']);

Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
Route::get('/payments/{id}/receipt', [PdfController::class, 'downloadReceipt']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/student-payments/{id}', [PaymentController::class, 'studentPayments']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/staff', [StafftController::class, 'index']);
    Route::post('/logout', [StafftController::class, 'logout']);
});
