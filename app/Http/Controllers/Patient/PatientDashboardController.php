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
        return view('patient.appointment');
    }
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patientName' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'gender' => 'required|string',
            'service' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'patient_name' => $validated['patientName'],
            'contact' => $validated['contact'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'gender' => $validated['gender'],
            'service' => $validated['service'],
            'notes' => $validated['notes'] ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment saved successfully!',
            'data' => $appointment,
        ], 201);
    }

    // Get all appointments
    public function getAppointments()
    {
        $appointments = Appointment::orderBy('date', 'asc')->get();
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
