<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    public $timestamps = false;

    protected $fillable = [
        'patient_name',
        'contact_number',
        'gender',
        'dental_service',
        'patient_id',
        'appointment_date',
        'status',
        'notes',
        'refNumber'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->refNumber)) {
                $appointment->refNumber = 'APPT' . date('YmdHis') . Str::random(4);
            }
        });
    }

    // Updated relationship - use the correct foreign key and local key
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }

    // Add accessor for formatted appointment date
    public function getFormattedAppointmentDateAttribute()
    {
        return $this->appointment_date 
            ? \Carbon\Carbon::parse($this->appointment_date)->format('M d, Y h:i A')
            : 'N/A';
    }
}