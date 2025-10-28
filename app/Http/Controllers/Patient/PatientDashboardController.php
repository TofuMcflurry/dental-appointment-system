<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BracesSchedule;
use App\Models\Appointment; 

class PatientDashboardController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->orderBy('appointment_date', 'asc')
            ->get([
                'appointment_id',
                'appointment_date', 
                'notes',
                'dental_service',
                'status'  // ✅ This is the correct column
            ]);

        // Get next braces adjustment
        $nextBracesAdjustment = BracesSchedule::where('patient_id', auth()->id())
            ->where('is_active', 1)
            ->orderBy('next_adjustment_date', 'asc')
            ->first();

        // Get today's received reminders
        $todaysReminders = \App\Models\BracesReminder::where('patient_id', auth()->id())
            ->where('sent', 1)
            ->whereDate('sent_at', today())
            ->get();

        // ✅ FIXED: Use status column
        $nextAppointment = $appointments->where('status', '!=', 'Cancelled')
                                    ->where('appointment_date', '>=', now())
                                    ->sortBy('appointment_date')
                                    ->first();

        return view('patient.dashboard', compact('appointments', 'nextBracesAdjustment', 'todaysReminders', 'nextAppointment'));
    }

    public function appointments()
    {
        // Fetch logged-in user's appointments
        $appointments = Appointment::where('patient_id', auth()->id())
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('patient.appointments', compact('appointments'));
    }

    public function storeAppointment(Request $request)
    {
        $request->merge(['patient_id' => auth()->id()]);

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'dental_service' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'patient_id' => 'required|integer',
            'payment_method' => 'required|in:cash,card',
        ]);

        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        // Generate unique reference number using Option 1 format
        $refNumber = $this->generateRefNumber();

        // Check for conflicts (same patient, date/time)
        $conflict = Appointment::where('patient_id', $request->patient_id)
            ->where('appointment_date', $datetime)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['appointment_time' => 'You already have an appointment at this time.']);
        }

        $appointment = Appointment::create([
            'patient_name' => $request->patient_name,
            'contact_number' => $request->contact_number,
            'gender' => $request->gender,
            'dental_service' => $request->dental_service,
            'patient_id' => $request->patient_id,
            'appointment_date' => $datetime,
            'status' => 'Pending',
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'refNumber' => $refNumber,
        ]);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'refNumber' => $refNumber,
                'appointment' => $appointment
            ]);
        }

        return redirect()->route('patient.appointments')->with([
            'success' => 'Appointment booked successfully!',
            'refNumber' => $refNumber
        ]);
    }

    private function generateRefNumber()
    {
        do {
            // Option 1 Format: APPT + YYMMDD + 4-digit random number
            // Examples: APPT2510260001, APPT2510261234, APPT2510269999
            $refNumber = 'APPT' . date('ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Appointment::where('refNumber', $refNumber)->exists());
        
        return $refNumber;
    }

    // Get all appointments
    public function getAppointments()
    {
        $appointments = Appointment::orderBy('appointment_date', 'asc')->get();
        return response()->json($appointments);
    }

    public function notifications()
    {
        return view('patient.notification');
    }

    public function settings()
    {
        return view('patient.settings');
    }
}