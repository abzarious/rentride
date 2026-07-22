<?php

use Illuminate\Support\Facades\Route;

// Redirect Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Group Route Khusus Admin (Wajib Login & Role Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Group Route Khusus Customer (Wajib Login & Role Customer)
Route::middleware(['auth', 'role:customer'])->prefix('customer')->as('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
});

// Auth Routes dari Breeze (Login/Register/Logout)
require __DIR__.'/auth.php';