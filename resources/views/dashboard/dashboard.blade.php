@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-style')
  @vite(['resources/css/admin/dashboard.css'])
@endsection

@section('content')
<div class="dashboard-page">
  <div class="card">
    <div class="cards">
      <div class="stat"><h4>Appointments Today</h4><div class="count" id="todayCount"></div></div>
      <div class="stat"><h4>Upcoming Appointments</h4><div class="count" id="upcomingCount"></div></div>
      <div class="stat"><h4>Cancelled Appointments</h4><div class="count" id="cancelledCount"></div></div>
      <div class="stat"><h4>Reminders Sent Today</h4><div class="count" id="reminderCount"></div></div>
    </div>

    {{-- Calendar + Right Column --}}
    <div style="display:flex;gap:14px;margin-top:12px;flex-wrap:wrap;">
      <div style="flex:1;min-width:300px">
        <div class="card calendar-main">
          <div class="month-header">
            <div class="month" id="calendarMonth"></div>
            <div>
                <button id="prevMonth">‹</button>
                <button id="nextMonth">›</button>
            </div>
          </div>
          <div class="calendar-grid">
            <div class="weekdays">
                <div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>
            </div>
            <div class="days" id="calendarDays"></div>
          </div>
        </div>
      </div>

      <div style="width:320px;display:flex;flex-direction:column;gap:14px">
        <div class="card"><h3>Patient Engagement</h3><div id="patientsList" class="patients-list"><div class="audit-empty">No registered patients yet.</div></div></div>
        <div class="card"><h3>Notification</h3><div id="notifList" class="notif-list"><div class="audit-empty">No notifications.</div></div></div>
      </div>
    </div>

    {{-- Audit Trail --}}
    <div style="margin-top:14px">
      <div class="card">
        <h3>Audit Trail</h3>
        <table class="audit-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="auditBody">
                <tr><td colspan="4" class="audit-empty">No audit entries yet.</td></tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Appointment Modal --}}
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="modalDate"></h3>
        <div id="appointmentList">
            <div class="empty-appointments">Loading appointments...</div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
  @vite(['resources/js/admin/dashboard.js'])
@endsection