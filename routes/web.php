<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — LaundryPOS Admin
|--------------------------------------------------------------------------
*/

// Login
Route::get('/', function () {
    return view('pages.login');
})->name('login');

// Dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// Services
Route::get('/services', function () {
    return view('pages.services');
})->name('services');

// Customers
Route::get('/customers', function () {
    return view('pages.customers');
})->name('customers');

// Transactions
Route::get('/transactions', function () {
    return view('pages.transactions');
})->name('transactions');

// Reports
Route::get('/reports', function () {
    return view('pages.reports');
})->name('reports');

// Redirect any unknown page to login
Route::fallback(function () {
    return redirect('/');
});
