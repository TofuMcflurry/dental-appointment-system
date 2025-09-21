<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index()
    {
        $trails = AuditTrail::orderBy('date_time', 'desc')->get();
        return view('dashboard.audit-trail', compact('trails'));
    }
}
