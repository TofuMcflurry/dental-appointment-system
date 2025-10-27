<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BracesReminder extends Model
{
    use HasFactory;

    protected $table = 'braces_reminders';
    protected $primaryKey = 'reminder_id';
    public $timestamps = true;

    protected $fillable = [
        'schedule_id',
        'patient_id',
        'type',
        'scheduled_at',
        'sent',
        'sent_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'sent' => 'boolean'
    ];

    // Relationship with schedule
    public function schedule()
    {
        return $this->belongsTo(BracesSchedule::class, 'schedule_id', 'schedule_id');
    }

    // Relationship with patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    // Scope for unsent reminders
    public function scopeUnsent($query)
    {
        return $query->where('sent', 0);
    }

    // Scope for due reminders
    public function scopeDue($query, $days = 7)
    {
        return $query->where('scheduled_at', '<=', now()->addDays($days));
    }

    // ✅ ADDED: Scope to get reminders ready to send (due and unsent)
    public function scopeReadyToSend($query)
    {
        return $query->unsent()->due();
    }

    // ✅ ADDED: Check if reminder is overdue
    public function isOverdue()
    {
        return $this->scheduled_at->isPast() && !$this->sent;
    }

    // ✅ ADDED: Get days until scheduled date
    public function getDaysUntilAttribute()
    {
        return now()->diffInDays($this->scheduled_at, false);
    }
}