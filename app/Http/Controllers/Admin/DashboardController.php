<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.dashboard'); 
    }

    public function appointments()
    {
        return view('dashboard.appointments');
    }

    public function patients()
    {
        return view('dashboard.patients');
    }

    public function audittrail()
    {
        return view('dashboard.audittrail');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
}
