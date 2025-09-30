@extends('layouts.patient')

@section('title', 'Patient Dashboard')

@section('content')
<div id="dashboardPage" class="dashboard-page">

    <h3 id="dashTitle">Welcome to LCAD Dental Care</h3>
    <p id="dashText" class="muted">
        This is your patient dashboard. Use the sidebar to manage appointments, view notifications, and update your settings.
    </p>

    <div class="overview" style="margin-top:16px">
        <div class="card">
            <h4>Next Appointment</h4>
            <p id="nextAppointment" class="muted">Loading...</p>
        </div>
        <div class="card">
            <h4>Status</h4>
            <p id="statusConfirmed" class="muted">—</p>
        </div>
        <div class="card">
            <h4>Reminders Received Today</h4>
            <p id="remindersToday" class="muted">0</p>
        </div>
    </div>

    <div class="appointments-section">
        <div class="card appointments-list">
            <h4>Appointments</h4>
            <div id="apptsContainer" style="margin-top:10px">Loading...</div>
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
        <div id="notifsContainer" class="notifsContainer">Loading...</div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/core.js') }}"></script>
@endsection