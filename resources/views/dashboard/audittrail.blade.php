@extends('layouts.app')

@section('title', 'Audit Trail')

@section('page-style')
  @vite(['resources/css/admin/audittrail.css'])
@endsection

@section('content')
<section class="content">
  <div class="content-header">
    <h3>Audit Trail</h3>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>Date & Time</th>
        <th>Patient</th>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2025-09-20 12:03</td>
        <td>Juan Dela Cruz</td>
        <td>Tooth Extraction</td>
        <td>Appointment Confirmed</td>
      </tr>
      <tr>
        <td>2025-09-20 13:15</td>
        <td>Maria Santos</td>
        <td>Dental Cleaning</td>
        <td>Appointment Created</td>
      </tr>
      <tr>
        <td>2025-09-20 14:40</td>
        <td>Carlos Reyes</td>
        <td>Braces Adjustment</td>
        <td>Appointment Cancelled</td>
      </tr>
    </tbody>
  </table>
</section>
@endsection

@section('page-script')
  @vite(['resources/js/admin/audittrail.js'])
@endsection