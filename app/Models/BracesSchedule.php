<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BracesSchedule extends Model
{
    use HasFactory;

    protected $table = 'braces_schedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = true;

    protected $fillable = [
        'patient_id',
        'last_adjustment_date',
        'next_adjustment_date', 
        'adjustment_interval',
        'is_active'
    ];

    protected $casts = [
        'last_adjustment_date' => 'datetime',
        'next_adjustment_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Relationship with reminders
    public function reminders()
    {
        return $this->hasMany(BracesReminder::class, 'schedule_id', 'schedule_id');
    }

    // Relationship with patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }
}