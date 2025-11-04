<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\NotificationsController;
use App\Http\Controllers\patient\PatientSettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Root Route
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

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
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

    Route::get('/patients', [DashboardController::class, 'patients'])->name('patients');
    Route::get('/audittrail', [DashboardController::class, 'audittrail'])->name('audittrail');

    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    // OTP Routes - INSIDE ADMIN GROUP
    Route::get('/verify-otp', function() {
        return view('auth.verify-otp');
    })->name('verify.otp.page');
    Route::post('/verify-otp', [AdminSettingsController::class, 'verifyOTP'])->name('verify.otp.submit');
    Route::post('/resend-otp', [AdminSettingsController::class, 'resendOTP'])->name('resend.otp');
});

// Patient Routes
Route::prefix('patient')->middleware(['auth', 'verified'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
    Route::post('/appointments', [PatientDashboardController::class, 'storeAppointment'])->name('appointments.store');

    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/delete-all', [NotificationsController::class, 'deleteAll'])->name('notifications.delete-all');
    Route::post('/notifications/{id}/toggle-read', [NotificationsController::class, 'toggleRead'])->name('notifications.toggle-read');
    Route::delete('/notifications/{id}', [NotificationsController::class, 'delete'])->name('notifications.delete');
    
    Route::get('/settings', [PatientSettingsController::class, 'edit'])->name('settings');
    Route::put('/settings', [PatientSettingsController::class, 'update'])->name('settings.update');
    
    // OTP Routes - INSIDE PATIENT GROUP
    Route::get('/verify-otp', function() {
        return view('auth.verify-otp');
    })->name('verify.otp.page'); // ✅ GET route for the page
    Route::post('/verify-otp', [PatientSettingsController::class, 'verifyOTP'])->name('verify.otp.submit'); // ✅ POST route for form submission
    Route::post('/resend-otp', [PatientSettingsController::class, 'resendOTP'])->name('resend.otp');
});
// Profile Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes handled by Breeze
require __DIR__ . '/auth.php';
