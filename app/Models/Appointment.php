<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    public $timestamps = false;  // Set to true if you add created_at/updated_at columns

    protected $fillable = [
        'patient_name',
        'contact_number',
        'gender',
        'dental_service',
        'patient_id',
        'appointment_date',
        'status',
        'notes'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');  // Ensure User model exists
    }
}