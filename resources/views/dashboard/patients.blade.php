@extends('layouts.app')

@section('title', 'Patients')

@section('page-style')
  @vite(['resources/css/admin/patients.css'])
@endsection

@section('content')
<!-- Patients Page Content - ADD data-patients ATTRIBUTE -->
<section id="patients" class="content" data-patients="{{ json_encode($patients) }}">
  <div class="main-content">
    <!-- Table Section -->
    <section class="card table-section">
      <div class="content-header">
        <h3>Patients</h3>
        <div class="search-box">
          <input type="text" id="search" placeholder="Search patients..." />
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Next Adjustment</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="patientBody">
          @if($patients->count() > 0)
            @foreach($patients as $patient)
              <tr data-patient-id="{{ $patient->patient_id }}">
                <td>{{ $patient->full_name }}</td>
                <td>{{ $patient->gender }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->birthdate)->age ?? 'N/A' }}</td>
                <td>{{ $patient->contact_number ?? 'N/A' }}</td>
                <td>{{ $patient->email ?? 'N/A' }}</td>
                <td>
                    @if($patient->bracesSchedule && $patient->bracesSchedule->is_active)
                        {{ \Carbon\Carbon::parse($patient->bracesSchedule->next_adjustment_date)->format('M j, Y') }}
                    @else
                        <span class="no-braces">No braces</span>
                    @endif
                </td>
                <td>
                  <button class="btn-view" onclick="viewPatient({{ $patient->patient_id }})">View</button>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7" class="empty">No patients found.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </section>
  </div>

  <!-- Floating Details Panel (Hidden by default) -->
  <div class="panel-overlay" id="panelOverlay"></div>
  <aside class="details-panel" id="detailsPanel">
    <div class="panel-header">
      <h3>Patient Details</h3>
      <button type="button" id="closePanel" class="close-btn">&times;</button>
    </div>
    <div class="panel-body">
      <div class="patient-sections">
        <!-- Personal Information -->
        <div class="info-section">
          <h4>👤 Personal Information</h4>
          <div class="info-grid">
            <div class="info-item">
              <label>Full Name:</label>
              <span id="panelPatientName">-</span>
            </div>
            <div class="info-item">
              <label>Gender:</label>
              <span id="panelPatientGender">-</span>
            </div>
            <div class="info-item">
              <label>Age:</label>
              <span id="panelPatientAge">-</span>
            </div>
            <div class="info-item">
              <label>Birthdate:</label>
              <span id="panelPatientBirthdate">-</span>
            </div>
            <div class="info-item">
              <label>Contact:</label>
              <span id="panelPatientContact">-</span>
            </div>
            <div class="info-item">
              <label>Email:</label>
              <span id="panelPatientEmail">-</span>
            </div>
            <div class="info-item full-width">
              <label>Address:</label>
              <span id="panelPatientAddress">-</span>
            </div>
          </div>
        </div>

        <!-- Braces Information -->
        <div class="info-section">
          <h4>🦷 Braces Adjustment Schedule</h4>
          <div class="info-grid" id="panelBracesInfo">
            <div class="info-item">
              <label>Last Adjustment:</label>
              <span id="panelLastAdjustment">-</span>
            </div>
            <div class="info-item">
              <label>Next Adjustment:</label>
              <span id="panelNextAdjustment">-</span>
            </div>
            <div class="info-item">
              <label>Interval:</label>
              <span id="panelAdjustmentInterval">-</span>
            </div>
            <div class="info-item">
              <label>Status:</label>
              <span id="panelBracesStatus">-</span>
            </div>
          </div>
          <div class="no-braces-message" id="panelNoBracesMessage">
            No braces treatment scheduled for this patient.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-footer">
      <button type="button" class="btn-secondary" id="closePanelBtn">Close</button>
      <button type="button" class="btn-primary" id="editPanelPatientBtn">Edit Patient</button>
    </div>
  </aside>
</section>
@endsection

@section('page-script')
  @vite(['resources/js/admin/patients.js'])
@endsection