<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BracesReminder;
use App\Models\BracesSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BraceAdjustmentReminder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendBracesRemindersFixed extends Command
{
    protected $signature = 'braces:send-reminders';
    protected $description = 'Send all braces reminders (FIXED VERSION)';

    public function handle()
    {
        $this->info('🎯 STARTING BRACES REMINDERS...');

        // 1. Get due reminders using Eloquent
        $dueReminders = BracesReminder::unsent()
            ->due(7)
            ->get();

        $this->info("📧 Found {$dueReminders->count()} reminders to send");

        // 2. Send each reminder
        foreach ($dueReminders as $reminder) {
            $this->sendReminder($reminder);
        }

        $this->info('✅ BRACES REMINDERS COMPLETED!');
        return 0;
    }

    protected function sendReminder(BracesReminder $reminder)
    {
        $this->info("Sending {$reminder->type} reminder to patient {$reminder->patient_id}...");
        
        // ✅ FIX: Use ceil() to round UP to nearest whole day
        $daysUntil = ceil(now()->diffInHours($reminder->scheduled_at) / 24);
        
        // Get patient using Eloquent
        $patient = User::find($reminder->patient_id);
        $patientEmail = $patient->email ?? 'test@example.com';
        
        if ($patientEmail === 'test@example.com') {
            $this->warn("⚠️ Using test email - configure real patient emails in users table");
        }
        
        // Send actual email
        try {
            // ✅ PASS PATIENT DATA TO EMAIL
            Mail::to($patientEmail)->send(new BraceAdjustmentReminder($reminder, $daysUntil, $patient));
            $this->info("✅ Email sent to {$patientEmail} - {$daysUntil} days until adjustment");
            
            // Mark as sent using Eloquent
            $reminder->update([
                'sent' => 1,
                'sent_at' => now(),
            ]);
            
            $this->info("✅ Sent {$reminder->type} reminder");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email to {$patientEmail}: " . $e->getMessage());
        }
    }
}