@extends('layouts.patient')

@section('title', 'Patient Appointment')

@section('content')
<div id="appointmentsPage" class="appointments-page">

    <h3 id="apptTitle">Book an Appointment</h3>

    <div class="appt-form">
        <div>
            <div class="form-group">
                <label for="patientName">Patient Name</label>
                <input type="text" id="patientName" placeholder="Full name">
            </div>

            <div class="form-group">
                <label for="patientContact">Contact Number</label>
                <input type="tel" id="patientContact" placeholder="09xx...">
            </div>

            <div style="display:flex;gap:12px">
                <div class="form-group" style="flex:1">
                    <label for="apptDate">Date</label>
                    <input type="date" id="apptDate">
                </div>
                <div class="form-group" style="width:160px">
                    <label for="apptTime">Time</label>
                    <input type="time" id="apptTime">
                </div>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="appt-summary" id="apptSummary">
                <strong>Selected:</strong>
                <div id="summaryDate">Date: —</div>
                <div id="summaryTime">Time: —</div>
                <div id="summaryService">Service: —</div>
            </div>

            <div class="form-actions">
                <button id="bookApptBtn" class="btn save">Book</button>
                <button id="cancelApptBtn" class="btn cancel">Cancel</button>
            </div>

            <hr style="margin:18px 0">

            <h4 style="margin:0 0 8px 0">Your Appointments</h4>
            <ul id="apptList" class="muted" style="padding-left:18px">Loading...</ul>
        </div>

        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <h4 style="margin:0">Dental Services</h4>
                <div class="muted" style="font-size:12px">Click one to choose</div>
            </div>

            <div class="services-list" id="servicesList">
                @php
                    $services = [
                        "Check-up & Consultation","Teeth Cleaning","Dental Fillings","Tooth Extraction","Wisdom Tooth Removal",
                        "Root Canal Therapy","Dental Crowns","Dental Bridges","Dentures","Braces / Orthodontics",
                        "Dental Implants","Teeth Whitening","Gum Treatment / Periodontics","Fluoride Treatment","Oral Surgery",
                        "Emergency / Pain Relief"
                    ];
                @endphp
                @foreach($services as $service)
                    <label>
                        <input type="radio" name="service" value="{{ $service }}"> {{ $service }}
                    </label>
                @endforeach
            </div>

            <div style="margin-top:12px">
                <label for="notes" style="font-weight:500;color:var(--accent);display:block;margin-bottom:6px">
                    Appointment Schedule Details — Notes
                </label>
                <textarea id="notes" rows="8" placeholder="Write any notes, concerns, or medical history here..." style="width:100%;"></textarea>
            </div>
        </div>
    </div>

</div>
@endsection