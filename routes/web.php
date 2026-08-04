<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\VehicleDetailController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\VehicleAvailabilityController;
use Illuminate\Support\Facades\Auth;

// 1. PUBLIC LANDING PAGE & DETAIL VEHICLE
Route::get('/', function () {
    $vehicles = \App\Models\Vehicle::with(['brand', 'category'])->where('status', 'available')->latest()->get();
    $setting = \App\Models\Setting::first();
    return view('welcome', compact('vehicles', 'setting'));
});

Route::get('/vehicles/{id}', [VehicleDetailController::class, 'show'])->name('vehicles.show');

// API CEK KETERSEDIAAN
Route::get('/api/vehicles/{id}/check-availability', [VehicleAvailabilityController::class, 'check']);

// 2. ROUTE JEMBATAN /dashboard
Route::middleware(['auth'])->get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->name('dashboard');

// 3. ROUTE KHUSUS ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('brands', BrandController::class);
    Route::resource('vehicle-categories', VehicleCategoryController::class);
    Route::resource('vehicle-types', VehicleTypeController::class); 

    Route::get('vehicles/trash', [VehicleController::class, 'trash'])->name('vehicles.trash');
    Route::post('vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
    Route::delete('vehicles/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('vehicles.forceDelete');
    Route::resource('vehicles', VehicleController::class);

    Route::get('vehicles/{vehicle}/images', [\App\Http\Controllers\Admin\VehicleImageController::class, 'index'])->name('vehicles.images.index');
    Route::post('vehicles/{vehicle}/images', [\App\Http\Controllers\Admin\VehicleImageController::class, 'store'])->name('vehicles.images.store');
    Route::delete('vehicle-images/{image}', [\App\Http\Controllers\Admin\VehicleImageController::class, 'destroy'])->name('vehicle-images.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// 4. ROUTE KHUSUS CUSTOMER
Route::middleware(['auth', 'role:customer'])->prefix('customer')->as('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    
    // Transaksi & Invoice PDF
    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/history', [CustomerBookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/create/{vehicle_id}', [CustomerBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [CustomerBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/download-pdf', [CustomerBookingController::class, 'downloadPdf'])->name('bookings.download-pdf');

    // Profil & Change Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';