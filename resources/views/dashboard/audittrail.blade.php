@extends('layouts.app')

@section('title', 'Audit Trail')

@section('page-style')
  @vite(['resources/css/admin/audittrail.css'])
@endsection

@section('content')
<section class="content">
  <div class="content-header">
    <h3>Audit Trail</h3>
    
    <!-- Search and Filter Form -->
    <div class="audit-filters">
      <form action="{{ route('admin.audittrail') }}" method="GET" class="filter-form">
        <div class="filter-group">
          <input type="text" name="search" placeholder="Search by patient name..." 
                 value="{{ request('search') }}" class="search-input">
          
          <select name="status" class="status-select">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          </select>
          
          <button type="submit" class="filter-btn">Filter</button>
          <a href="{{ route('admin.audittrail') }}" class="clear-btn">Clear</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Show search results info -->
  @if(request()->has('search') || request()->has('status'))
    <div class="search-info">
      <p>
        Showing filtered results. 
        <a href="{{ route('admin.audittrail') }}" class="clear-link">Show all appointments</a>
      </p>
    </div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <th>Date & Time</th>
        <th>Patient Name</th>
        <th>Contact</th>
        <th>Service</th>
        <th>Status</th>
        <th>Reference No.</th>
      </tr>
    </thead>
    <tbody>
      @forelse($appointments as $appointment)
      <tr>
        <td data-label="Date & Time">
          @if($appointment->appointment_date)
            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}
          @else
            N/A
          @endif
        </td>
        <td data-label="Patient Name">{{ $appointment->patient_name }}</td>
        <td data-label="Contact">{{ $appointment->contact_number }}</td>
        <td data-label="Service">{{ $appointment->dental_service }}</td>
        <td data-label="Status">
          <span class="status-badge status-{{ strtolower($appointment->status) }}">
            {{ $appointment->status }}
          </span>
        </td>
        <td data-label="Reference No.">{{ $appointment->refNumber }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="no-data">No appointments found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</section>
@endsection

@section('page-script')
  @vite(['resources/js/admin/audittrail.js'])
@endsection