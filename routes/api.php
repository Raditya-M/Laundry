<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::post('/login', [
    AuthController::class,
    'login'
]);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [
        AuthController::class,
        'profile'
    ]);

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    'role:admin'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SERVICES
    |--------------------------------------------------------------------------
    */

    Route::apiResource('services', ServiceController::class);

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */

    Route::apiResource('customers', CustomerController::class);

    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    // list transaksi
    Route::get('/transactions', [
        TransactionController::class,
        'index'
    ]);

    // buat transaksi
    Route::post('/transactions', [
        TransactionController::class,
        'store'
    ]);

    Route::delete('/transactions/{id}', [
        TransactionController::class,
        'destroy'
    ]);

    // update status laundry
    Route::put('/transactions/{id}/status', [
        TransactionController::class,
        'updateStatus'
    ]);

    /*
    |--------------------------------------------------------------------------
    | REPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/report-income', [
        TransactionController::class,
        'incomeReport'
    ]);

    Route::get('/statistics', [
        TransactionController::class,
        'statistics'
    ]);
});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    'role:customer'
])->group(function () {

    // status laundry customer
    Route::get('/status-laundry', [
        TransactionController::class,
        'statusLaundry'
    ]);

    // history transaksi
    Route::get('/history', [
        TransactionController::class,
        'history'
    ]);

    // detail transaksi
    Route::get('/transactions/{id}', [
        TransactionController::class,
        'show'
    ]);
});
