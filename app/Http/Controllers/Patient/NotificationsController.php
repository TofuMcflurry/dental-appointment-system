<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $appointments = \App\Models\Appointment::where('patient_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        $bracesSchedules = \App\Models\BracesSchedule::where('patient_id', auth()->id())
            ->where('is_active', 1)
            ->orderBy('next_adjustment_date', 'desc')
            ->get();

        $sentReminders = \App\Models\BracesReminder::where('patient_id', auth()->id())
            ->where('sent', 1)
            ->orderBy('sent_at', 'desc')
            ->get();

        return view('patient.notifications', compact('appointments', 'bracesSchedules', 'sentReminders'));
    }

    // ✅ KEEP: But make them work with session/flags instead of database
    public function markAllRead()
    {
        // Store in session that user has viewed notifications
        session(['notifications_viewed' => true]);
        session(['notifications_viewed_at' => now()]);
        
        return back()->with('success', 'All notifications marked as read');
    }

    public function deleteAll()
    {
        // For demo purposes - in real world you might archive or hide
        session(['notifications_cleared' => true]);
        
        return back()->with('success', 'All notifications cleared');
    }

    public function toggleRead($id)
    {
        // For individual items - store in session which ones are read
        $readItems = session('read_notifications', []);
        
        if (in_array($id, $readItems)) {
            $readItems = array_diff($readItems, [$id]);
        } else {
            $readItems[] = $id;
        }
        
        session(['read_notifications' => $readItems]);
        return back();
    }

    public function delete($id)
    {
        // For individual items - store in session which ones are deleted
        $deletedItems = session('deleted_notifications', []);
        $deletedItems[] = $id;
        session(['deleted_notifications' => $deletedItems]);
        
        return back()->with('success', 'Notification deleted');
    }
}