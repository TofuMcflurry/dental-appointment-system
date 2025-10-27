<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BraceAdjustmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reminder;
    public $daysUntilAdjustment;
    public $patient;

    public function __construct($reminder, $daysUntilAdjustment, $patient)
    {
        $this->reminder = $reminder;
        $this->daysUntilAdjustment = $daysUntilAdjustment;
        $this->patient = $patient;
    }

    public function build()
    {
        $subject = "Brace Adjustment Reminder - {$this->daysUntilAdjustment} days left";
        
        return $this->subject($subject)
                    ->view('emails.brace-reminder');
    }
}