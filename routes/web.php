<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\ProfileController;

// Redirect Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// ROUTE JEMBATAN /dashboard (Menangani redirect default dari Laravel Breeze)
Route::middleware(['auth'])->get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->name('dashboard');

// ROUTE KHUSUS ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Resource Route Master Brand
    Route::resource('brands', BrandController::class);

    // Resource Route Master Kategori Kendaraan
    Route::resource('vehicle-categories', VehicleCategoryController::class);
});

// ROUTE KHUSUS CUSTOMER
Route::middleware(['auth', 'role:customer'])->prefix('customer')->as('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    
    // Route Profile Customer
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';