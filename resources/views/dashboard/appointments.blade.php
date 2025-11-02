@extends('layouts.app')

@section('title', 'Appointments')

@section('page-style')
  @vite(['resources/css/admin/appointments.css'])
@endsection

@section('content')
<!-- Appointment Page Content -->
<section id="appointments" class="content">
  <div class="main-content">
    <!-- Table -->
    <section class="card">
      <div class="content-header">
        <h3>Appointments</h3>
        <div class="search-box">
          <input id="search" placeholder="Search..." />
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Patient</th>
            <th>Service</th>
            <th>Dentist</th>
            <th>Branch</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="appointmentBody">
          <tr>
            <td colspan="5" class="empty">No appointments yet.</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Details Panel -->
    <aside class="details" id="detailsPanel">
      <h3>Appointment Details</h3>

      <h4>Patient Information</h4>
      <div class="info" id="patientInfo">
        <p class="placeholder">No patient details yet.</p>
      </div>

      <h4>Appointment Information</h4>
      <div class="info" id="appointmentInfo">
        <p class="placeholder">No appointment scheduled.</p>
      </div>

      <div class="actions">
        <button id="confirmBtn" disabled>✓ Confirm</button>
        <button id="cancelBtn" disabled>✕ Cancel</button>
        <button id="reminderBtn" disabled>🔔 Reminder</button>
        <button id="editBtn" disabled>✎ Edit</button>
      </div>
    </aside>
  </div>

  <!-- Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <h3>Edit Appointment</h3>
      <form id="editForm">
        <label>Full Name</label>
        <input type="text" id="editName" required>

        <label>Contact</label>
        <input type="text" id="editContact">

        <label>Email</label>
        <input type="email" id="editEmail">

        <label>Gender</label>
        <select id="editGender">
          <option>Male</option>
          <option>Female</option>
        </select>

        <div class="actions">
          <button type="submit">💾 Save</button>
          <button type="button" id="closeModal">✕ Cancel</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@section('page-script')
  @vite(['resources/js/admin/appointments.js'])
@endsection 