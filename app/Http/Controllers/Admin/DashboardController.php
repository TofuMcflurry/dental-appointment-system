<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon; // ADD THIS IMPORT
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

    // Get appointments for calendar
    public function getCalendarAppointments(Request $request): JsonResponse
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2023|max:2030'
        ]);

        $month = $request->month;
        $year = $request->year;

        // Get first and last day of the month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get appointments for this month
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->orderBy('appointment_date')
            ->get(['appointment_id', 'patient_name', 'dental_service', 'appointment_date', 'status'])
            ->groupBy(function($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            });

        return response()->json([
            'appointments' => $appointments,
            'month' => $startDate->format('F Y'),
            'days_in_month' => $startDate->daysInMonth,
            'first_day_of_month' => $startDate->dayOfWeek // 0 = Sunday, 1 = Monday, etc.
        ]);
    }

    // Get appointments for specific date
    public function getAppointmentsByDate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');
        
        $appointments = Appointment::whereDate('appointment_date', $date)
            ->orderBy('appointment_date')
            ->get();

        return response()->json([
            'appointments' => $appointments,
            'date' => $date,
            'formatted_date' => Carbon::parse($date)->format('F d, Y')
        ]);
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
