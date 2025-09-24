<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::view('/appointments', 'dashboard.appointments')->name('appointments');

    Route::view('/patients', 'dashboard.patients')->name('patients');

    Route::view('/audittrail', 'dashboard.audittrail')->name('audittrail');

    Route::view('/settings', 'dashboard.settings')->name('settings');
});

Route::prefix('patient')->middleware(['auth'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/notifications', [PatientDashboardController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [PatientDashboardController::class, 'settings'])->name('settings');
});


// Profile routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes handled by Breeze
require __DIR__.'/auth.php';
