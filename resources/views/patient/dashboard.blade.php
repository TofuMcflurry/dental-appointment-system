@extends('layouts.patient')

@section('title', 'Patient Dashboard')

@section('content')
<div id="dashboardPage" class="dashboard-page">
    <!-- Content will be dynamically rendered by dashboard.js -->
    <div class="loading-state" style="text-align:center; margin-top:40px; color:#777;">
        Loading your dashboard...
    </div>
</div>
@endsection

@section('scripts')
    <script>
        window.patientData = @json($patientData ?? []);
    </script>
    @vite('resources/js/patient/core.js')
@endsection
