@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div id="appointmentsPage" class="page-transition">

  <h3 id="apptTitle">Book an Appointment</h3>

  <form action="{{ route('patient.appointments.store') }}" method="POST">
    @csrf

    <div style="display:flex; gap:20px; flex-wrap:wrap;">

      {{-- Left Column --}}
      <div style="flex:1; min-width:300px;">

        {{-- Patient Info --}}
        <div class="form-group">
          <label for="patientName">Patient Name</label>
          <input type="text" id="patientName" name="patient_name" placeholder="Full name" required>
        </div>

        <div class="form-group">
          <label for="patientContact">Contact Number</label>
          <input type="tel" id="patientContact" name="contact_number" placeholder="09xx..." required>
        </div>

        <div style="display:flex; gap:12px;">
          <div class="form-group" style="flex:1;">
            <label for="apptDate">Date</label>
            <input type="date" id="apptDate" name="appointment_date" 
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                   max="{{ date('Y-m-d', strtotime('+30 days')) }}" 
                   required>
            <small style="color: #666; font-size: 12px;">Appointments can be booked from tomorrow to 30 days ahead</small>
          </div>
          <div class="form-group" style="width:160px;">
            <label for="apptTime">Time</label>
            <input type="time" id="apptTime" name="appointment_time" 
                   min="07:00" 
                   max="17:00" 
                   required>
            <small style="color: #666; font-size: 12px;">Clinic hours: 7:00 AM - 5:00 PM</small>
          </div>
        </div>

        <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
            <option value="">-- Select --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>

        {{-- Appointment Summary --}}
        <div class="appt-summary" id="apptSummary">
          <strong>Selected:</strong>
          <div id="summaryDate">Date: —</div>
          <div id="summaryTime">Time: —</div>
          <div id="summaryService">Service: —</div>
        </div>

      </div>

      {{-- Right Column --}}
      <div style="flex:1; min-width:300px;">

        {{-- Dental Services --}}
        <h4>Dental Services</h4>
        <div class="services-list" id="servicesList">
          @foreach([
            "Check-up & Consultation", "Teeth Cleaning", "Dental Fillings", "Tooth Extraction",
            "Wisdom Tooth Removal", "Root Canal Therapy", "Dental Crowns", "Dental Bridges",
            "Dentures", "Braces / Orthodontics", "Dental Implants", "Teeth Whitening",
            "Gum Treatment / Periodontics", "Fluoride Treatment", "Oral Surgery",
            "Emergency / Pain Relief"
          ] as $service)
            <label>
              <input type="radio" name="dental_service" value="{{ $service }}" required>
              {{ $service }}
            </label>
          @endforeach
        </div>

        {{-- Notes --}}
        <div style="margin-top:12px;">
          <label for="notes" style="font-weight:500;color:var(--accent);display:block;margin-bottom:6px">
            Appointment Details / Notes
          </label>
          <textarea id="notes" name="notes" rows="6" style="width:100%; max-height:200px;" placeholder="Write any notes, concerns, or medical history here..."></textarea>
        </div>

      </div>

    </div>

    {{-- Form Buttons --}}
    <div class="form-actions" style="margin-top:12px;">
      <button type="submit" id="bookApptBtn" class="btn save">Book</button>
      <button type="reset" id="cancelApptBtn" class="btn cancel">Cancel</button>
    </div>
  </form>
</div>
{{-- This closes the main appointmentsPage div --}}

<!-- Include the confirmation modal -->
@include('components.appointment-confirmation')

@endsection

@push('scripts')
  @vite('resources/js/patient/core.js')
@endpush