<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StafftController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/register', [StafftController::class, 'store']);
Route::post('/login', [StafftController::class, 'login']);

/*
|--------------------------------------------------------------------------
| STUDENTS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/students', [StudentController::class, 'index']);
Route::post('/student_create', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);

/*
|--------------------------------------------------------------------------
| PAYMENTS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
Route::get('/student-payments/{id}', [PaymentController::class, 'studentPayments']);
Route::get('/payments/{id}/whatsapp', [PaymentController::class, 'whatsappMessage']);

/*
|--------------------------------------------------------------------------
| PDF RECEIPT (PUBLIC OR OPTIONAL PROTECTED)
|--------------------------------------------------------------------------
*/
Route::get('/payments/{id}/receipt', [PdfController::class, 'downloadReceipt']);

/*
|--------------------------------------------------------------------------
| AUTH PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------
    | STAFF
    |--------------------------
    */
    Route::get('/staff', [StafftController::class, 'index']);
    Route::get('/staff/{staff}/edit', [StafftController::class, 'edit']);
    Route::put('/staff/{staff}', [StafftController::class, 'update']);
    Route::delete('/staff/{staff}', [StafftController::class, 'destroy']);

    /*
    |--------------------------
    | AUTH
    |--------------------------
    */
    Route::post('/logout', [StafftController::class, 'logout']);
});
