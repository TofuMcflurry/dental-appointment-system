<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.dashboard'); 
    }

    public function appointments()
    {
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        return view('dashboard.appointments', compact('appointments'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email',
            'gender' => 'required|in:Male,Female',
        ]);

        $appointment->update($request->all());

        return response()->json(['success' => 'Appointment updated successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled,Completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json(['success' => 'Status updated successfully']);
    }

    public function patients()
    {
        $patients = Patient::with(['user', 'bracesSchedule'])
            ->whereHas('user', function($query) {
                $query->where('role', '!=', 'admin'); // Exclude admin users
            })
            ->orderBy('full_name', 'asc')
            ->get();
            
        return view('dashboard.patients', compact('patients'));
    }

    public function audittrail(Request $request)
    {
        $query = Appointment::with(['patient'])
            ->orderBy('appointment_date', 'DESC')
            ->orderBy('appointment_id', 'DESC');

        // Search by patient name
        if ($request->has('search') && $request->search) {
            $query->where('patient_name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get();

        return view('dashboard.audittrail', compact('appointments'));
    }


    public function settings()
    {
        return view('dashboard.settings');
    }
}
