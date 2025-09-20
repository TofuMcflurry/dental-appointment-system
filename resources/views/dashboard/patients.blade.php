@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<section class="content">
  <div class="content-header">
    <h3>Patients</h3>
    <div class="search-box">
      <input type="text" id="search" placeholder="Search..." />
    </div>
  </div>

  <table class="table">
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
      <tr><td colspan="5" class="empty">No patients yet.</td></tr>
    </tbody>
  </table>
</section>

<section class="details-wrap" id="detailsWrap">
  <!-- Ready for Patient Details -->
</section>
@endsection
