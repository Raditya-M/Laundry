<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/services', function () {
    return view('services.index');
})->name('services');

Route::get('/customers', function () {
    return view('customers.index');
})->name('customers');

Route::get('/transactions', function () {
    return view('transactions.index');
})->name('transactions');

Route::get('/reports', function () {
    return view('reports.index');
})->name('reports');

Route::view('/api-docs', 'api-docs')
    ->name('api-docs');

// Redirect any unknown page to login
Route::fallback(function () {
    return redirect('/');
});
