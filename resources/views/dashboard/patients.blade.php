@extends('layouts.app')

@section('title', 'Patients')

@section('page-style')
  @vite(['resources/css/admin/patients.css'])
@endsection

@section('content')
<!-- Patients Page Content -->
<section id="patients" class="content">
  <div class="main-content">
    <section class="card">
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
            <th>Last Appointment</th>
          </tr>
        </thead>
        <tbody id="patientBody">
          <tr>
            <td colspan="5" class="empty">No patients yet.</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</section>
@endsection

@section('page-script')
  @vite(['resources/js/admin/patients.js'])
@endsection
