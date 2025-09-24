<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function dashboard() {
        return view('patient.dashboard');
    }

    public function appointments() {
        return view('patient.appointment');
    }

    public function notifications() {
        return view('patient.notification');
    }

    public function settings() {
        return view('patient.settings');
    }
}
