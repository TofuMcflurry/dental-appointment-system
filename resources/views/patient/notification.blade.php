@extends('layouts.patient')

@section('title', 'Patient Notifications')

@section('content')
<div id="notificationsPage" class="notifications-page">
    <div class="loading-state" style="text-align:center; margin-top:40px; color:#777;">
        Loading your notifications...
    </div>
</div>
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/patient/core.js') }}"></script>
@endpush
