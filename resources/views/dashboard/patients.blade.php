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

@push('scripts')
<script>
  // Sample patient data (empty by default)
  let patients = [];

  function renderPatients(filter = "") {
    const body = document.getElementById("patientBody");
    body.innerHTML = "";
    const filtered = patients.filter(p => 
      p.name.toLowerCase().includes(filter.toLowerCase())
    );

    if(filtered.length === 0){
      body.innerHTML = `<tr><td colspan="5" class="empty">No patients yet.</td></tr>`;
      return;
    }

    filtered.forEach(pt => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${pt.name}</td>
        <td>${pt.gender}</td>
        <td>${pt.age}</td>
        <td>${pt.contact}</td>
        <td>${pt.lastAppt}</td>
      `;
      body.appendChild(row);
    });
  }

  // Search functionality
  const searchInput = document.getElementById("search");
  searchInput.addEventListener("input", () => renderPatients(searchInput.value));

  // Initial render
  renderPatients();
</script>
@endpush
