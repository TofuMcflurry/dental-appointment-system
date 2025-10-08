@extends('layouts.patient')

@section('title', 'Settings')

@section('content')
<div id="settingsPage" class="settings-page">
    <div class="loading-state" style="text-align:center; margin-top:40px; color:#777;">
        Loading your settings...
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/patient/core.js')
@endpush
