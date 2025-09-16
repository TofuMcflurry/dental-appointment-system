<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';
    protected $primaryKey = 'reminder_id';
    public $timestamps = false;

    protected $fillable = [
        'appointment_id',
        'message',
        'reminder_date',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appointment_id');
    }
}
