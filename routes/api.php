<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CustomerController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    // SERVICE CRUD
    Route::apiResource('services', ServiceController::class);

    // TRANSACTION
    Route::post('/transactions', [
        TransactionController::class,
        'store'
    ]);

    Route::put('/transactions/{id}/status', [
        TransactionController::class,
        'updateStatus'
    ]);

    Route::get('/status-laundry', [
        TransactionController::class,
        'statusLaundry'
    ]);

    // REPORT API
    Route::get('/report-income', [
        TransactionController::class,
        'incomeReport'
    ]);

    Route::apiResource('customers', CustomerController::class);
});

Route::middleware([
    'auth:sanctum',
    'role:admin'
])->group(function () {

    Route::apiResource('services', ServiceController::class);

    Route::apiResource('customers', CustomerController::class);

    // LIST TRANSACTION
    Route::get('/transactions', [
        TransactionController::class,
        'index'
    ]);

    // CREATE TRANSACTION
    Route::post('/transactions', [
        TransactionController::class,
        'store'
    ]);

    // UPDATE STATUS
    Route::put('/transactions/{id}/status', [
        TransactionController::class,
        'updateStatus'
    ]);

    // REPORT
    Route::get('/report-income', [
        TransactionController::class,
        'incomeReport'
    ]);

    // STATISTICS
    Route::get('/statistics', [
        TransactionController::class,
        'statistics'
    ]);
});

Route::middleware([
    'auth:sanctum',
    'role:customer'
])->group(function () {

    Route::get('/status-laundry', [
        TransactionController::class,
        'statusLaundry'
    ]);

    Route::get('/history', [
        TransactionController::class,
        'history'
    ]);
});