<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment; 

class PatientDashboardController extends Controller
{
    public function dashboard()
    {
        // Sample data for now — you can later fetch this from the database
        $patientData = [
            'appointments' => [
                ['title' => 'Dental Cleaning', 'datetime' => '2025-10-15T09:00:00', 'confirmed' => true],
                ['title' => 'Braces Adjustment', 'datetime' => '2025-10-25T13:30:00', 'confirmed' => false],
            ],
            'notifications' => [
                ['message' => 'Your appointment is tomorrow at 9:00 AM.', 'date' => '2025-10-14'],
                ['message' => 'New reminder from admin.', 'date' => '2025-10-06']
            ],
            'bracesColor' => 'BLUE'
        ];

        // Pass data to your Blade view
        return view('patient.dashboard', compact('patientData'));
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
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'gender' => 'required|string',
            'dental_service' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
        ]);

        // Combine date + time
        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        Appointment::create([
            'patient_name' => $request->patient_name,
            'contact_number' => $request->contact_number,
            'gender' => $request->gender,
            'dental_service' => $request->dental_service,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $datetime,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.appointments')
                        ->with('success', 'Appointment booked successfully!');
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
