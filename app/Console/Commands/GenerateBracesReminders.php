<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BracesReminder;
use App\Models\BracesSchedule;
use Carbon\Carbon;

class GenerateBracesReminders extends Command
{
    protected $signature = 'braces:generate-reminders {schedule_id} {patient_id} {adjustment_date}';
    protected $description = 'Generate automatic reminders for a braces schedule';

    public function handle()
    {
        $scheduleId = $this->argument('schedule_id');
        $patientId = $this->argument('patient_id');
        $adjustmentDate = Carbon::parse($this->argument('adjustment_date'));

        $this->generateRemindersForSchedule($scheduleId, $patientId, $adjustmentDate);
        
        $this->info("✅ Generated 3 reminders for schedule #{$scheduleId}");
        return 0;
    }

    protected function generateRemindersForSchedule($scheduleId, $patientId, $adjustmentDate)
    {
        $reminders = [
            ['type' => '7days_before', 'scheduled_at' => $adjustmentDate->copy()->subDays(7)],
            ['type' => '3days_before', 'scheduled_at' => $adjustmentDate->copy()->subDays(3)],
            ['type' => 'day_of', 'scheduled_at' => $adjustmentDate->copy()],
        ];

        foreach ($reminders as $reminder) {
            BracesReminder::create([
                'schedule_id' => $scheduleId,
                'patient_id' => $patientId,
                'type' => $reminder['type'],
                'scheduled_at' => $reminder['scheduled_at'],
                'sent' => false,
            ]);
        }
    }
}