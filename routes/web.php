<?php

use Illuminate\Support\Facades\Route;

// ✅ Welcome page
Route::get('/', function () {
    return view('LoginSystem.WelcomeLogin');
})->name('welcome');

// ✅ Cashier login page
Route::get('/login/cashier', function () {
    return view('LoginSystem.CashierLogin');
})->name('login.cashier');

// ✅ Admin login page
Route::get('/login/admin', function () {
    return view('LoginSystem.AdminLogin');
})->name('login.admin');
