<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Root Route
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard') // generic redirect
        : view('welcome');
});

// GENERIC DASHBOARD ROUTE
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('patient.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [DashboardController::class, 'appointments'])->name('appointments');
    Route::get('/patients', [DashboardController::class, 'patients'])->name('patients');
    Route::get('/audittrail', [DashboardController::class, 'audittrail'])->name('audittrail');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
});

// Patient Routes
Route::prefix('patient')->middleware(['auth', 'verified'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/notifications', [PatientDashboardController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [PatientDashboardController::class, 'settings'])->name('settings');
});

// Profile Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes handled by Breeze
require __DIR__ . '/auth.php';
