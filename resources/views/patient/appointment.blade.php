@extends('layouts.patient')

@section('title', 'Patient Appointment')

@section('content')
<div id="appointmentsPage" class="appointments-page">
    <div class="loading-state" style="text-align:center; margin-top:40px; color:#777;">
        Loading your appointments...
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/patient/core.js')
@endpush
