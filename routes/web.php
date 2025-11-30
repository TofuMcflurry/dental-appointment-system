<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\NotificationsController;
use App\Http\Controllers\patient\PatientSettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//ROOT ROUTE - WELCOME PAGE ONLY
Route::get('/', function () {
    return view('welcome');
});

Route::get('/developer-modal', function () {
    return view('developer-modal')->render();
});

// AUTH ROUTES
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

//DASHBOARD ROUTE - AFTER LOGIN REDIRECT
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->role === 'orthopedic') {
        // ✅ REDIRECT TO REACT APP ON PORT 8080
        return redirect('http://localhost:8080/');
    }

    if ($user->role === 'patient') {
        return redirect()->route('patient.dashboard');
    }
    
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

//ORTHOPEDIC API ROUTES (for React app to call Laravel)
Route::prefix('orthopedic')->middleware(['auth'])->group(function () {
    Route::get('/patients', function() {
        if (auth()->user()->role !== 'orthopedic') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json(['message' => 'Orthopedic patients data']);
    });
    
    Route::post('/appointments', function() {
        if (auth()->user()->role !== 'orthopedic') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json(['message' => 'Appointment created']);
    });
});

//ADMIN ROUTES
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
        return app(DashboardController::class)->dashboard();
    })->name('dashboard');
    
    Route::get('/appointments', function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
        return app(DashboardController::class)->appointments();
    })->name('appointments');
    
    Route::get('/patients', function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
        return app(DashboardController::class)->patients();
    })->name('patients');
    
    Route::get('/audittrail', function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
        return app(DashboardController::class)->audittrail();
    })->name('audittrail');
    
    Route::get('/settings', function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
        return app(DashboardController::class)->settings();
    })->name('settings');
});

//PATIENT ROUTES
Route::prefix('patient')->middleware(['auth', 'verified'])->name('patient.')->group(function () {
    Route::get('/dashboard', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(PatientDashboardController::class)->dashboard();
    })->name('dashboard');
    
    Route::get('/appointments', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(PatientDashboardController::class)->appointments();
    })->name('appointments');
    
    Route::post('/appointments', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(PatientDashboardController::class)->storeAppointment();
    })->name('appointments.store');
    
    Route::get('/notifications', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(NotificationsController::class)->index();
    })->name('notifications');
    
    Route::get('/settings', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(PatientSettingsController::class)->edit();
    })->name('settings');
    
    Route::put('/settings', function() {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Patient access only.');
        }
        return app(PatientSettingsController::class)->update();
    })->name('settings.update');
});

//PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';