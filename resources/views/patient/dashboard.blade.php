@extends('layouts.app')

@section('title', 'Patient Dashboard')

{{-- @push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush --}}

@section('content')
<div id="dashboardPage" class="page">
    <h3 id="dashTitle">Welcome to LCAD Dental Care</h3>
    <p id="dashText" class="muted">
        This is your patient dashboard. Use the sidebar to manage appointments, view notifications, and update your settings.
    </p>

    <div class="overview" style="margin-top:16px">
        @if($nextBracesAdjustment)
        <div class="card">
            <h4>Next Braces Adjustment</h4>
            <p style="font-size: 1.3em; color: #1a4db3; font-weight: 700;">
                {{ \Carbon\Carbon::parse($nextBracesAdjustment->next_adjustment_date)->format('F j, Y') }}
            </p>
            <small style="color: #5f6b7a;" class="muted">
                Automatic reminders will be sent to your email
            </small>
        </div>
        @endif
        <div class="card">
            <h4>Status</h4>
            @if($nextAppointment)
                @php
                    // Map status to colors and friendly names
                    $statusConfig = [
                        'Pending' => ['class' => 'text-warning', 'text' => 'Pending Confirmation'],
                        'Confirmed' => ['class' => 'text-success', 'text' => 'Confirmed'],
                        'Upcoming' => ['class' => 'text-primary', 'text' => 'Upcoming'],
                        'Completed' => ['class' => 'text-secondary', 'text' => 'Completed'],
                        'Cancelled' => ['class' => 'text-danger', 'text' => 'Cancelled']
                    ];
                    
                    $statusInfo = $statusConfig[$nextAppointment->status] ?? ['class' => 'text-primary', 'text' => $nextAppointment->status];
                @endphp
                
                <p style="margin-bottom: 5px;">{{ $nextAppointment->dental_service }}</p>
                <p class="muted" style="margin-bottom: 8px; font-size: 0.9em;">
                    {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M d, g:i A') }}
                </p>
                <p style="display: inline-block; background: #fff3cd; color: #856404; 
                padding: 3px 10px; border-radius: 15px; font-weight: 600;">
                    {{ $statusInfo['text'] }}
                </p>
            @else
                <p class="muted">No upcoming appointments</p>
            @endif
        </div>
        <div class="card">
            <h4>Reminders Received Today</h4>
            @if($todaysReminders->count() > 0)
                <div style="font-size: 0.95em;">
                    @foreach($todaysReminders as $reminder)
                        <div style="margin-bottom: 8px; padding: 8px 12px; background: #ecfdf5; border-left: 4px solid #0d9488; border-radius: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>
                                    @if($reminder->type == '7days_before')
                                        <i class="fa-solid fa-envelope-circle-check text-success"></i> 7 days before adjustment
                                    @elseif($reminder->type == '3days_before')
                                        <i class="fa-solid fa-clock text-warning"></i> 3 days before adjustment
                                    @elseif($reminder->type == 'day_of')
                                        <i class="fa-solid fa-calendar-check text-primary"></i> Day of adjustment
                                    @else
                                        <i class="fa-solid fa-envelope text-muted"></i> {{ $reminder->type }}
                                    @endif
                                </span>
                                <small class="muted">{{ \Carbon\Carbon::parse($reminder->sent_at)->format('g:i A') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="muted">No reminders received today</p>
            @endif
        </div>
    </div>

    <div class="appointments-section">
        <div class="card appointments-list">
            <h4>Appointments</h4>
            @if($appointments && $appointments->count() > 0)
                @foreach($appointments as $appt)
                    @php
                        $status = 'Upcoming';
                        if($appt->cancelled) $status = 'Cancelled';
                        elseif(!$appt->attended && \Carbon\Carbon::parse($appt->appointment_date) < now()) $status = 'Missed';
                        elseif($appt->confirmed && !$appt->cancelled) $status = 'Upcoming (Confirmed)';
                    @endphp

                    <div class="appt">
                        <div class="meta">
                            <strong>{{ $appt->dental_service }}</strong>
                            <span class="time">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, h:i A') }}</span>
                        </div>
                        <div class="status-container">
                            <span class="status-pill status-{{ strtolower(str_replace(' ', '-', $status)) }}">{{ $status }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="muted">No appointments</div>
            @endif
        </div>

        <div class="card braces-section">
            <h4>Braces Color</h4>
            <div class="muted" style="font-size:13px">Click to choose preferred color</div>
            <div class="braces-grid" id="bracesGrid"></div>
            <div style="margin-top:12px;font-size:13px" class="muted">
                Selected: <span id="selectedColorText">—</span>
            </div>
        </div>
    </div>

    <div class="card notifications-list">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <h4 style="margin:0">Notifications</h4>
            <div class="top-controls">
                <button id="simulateReminder" class="simulate-admin" title="Simulate admin sending a reminder">Admin: Send Reminder</button>
                <button id="clearRead" class="btn cancel" style="padding:6px 10px">Clear Read</button>
            </div>
        </div>
        <div id="notifsContainer" class="notifsContainer">Loading…</div>
    </div>
</div>
@endsection
@push('scripts')
  @vite('resources/js/patient/core.js')
@endpush
