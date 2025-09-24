@extends('layouts.patient')

@section('title', 'Patient Notifications')

@section('content')
<div id="notificationsPage" class="notifications-page">

    <h3 id="notifTitle">Recent Notifications</h3>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <div class="muted">Manage and review notifications from the clinic.</div>
        <div style="display:flex;gap:8px;align-items:center">
            <button id="markAllReadBtn" class="btn" style="padding:8px 10px">Mark all read</button>
            <button id="filterUnreadBtn" class="btn cancel" style="padding:8px 10px" data-active="0">Show Unread</button>
            <button id="deleteAllBtn" class="btn cancel" style="padding:8px 10px">Delete all</button>
        </div>
    </div>

    <div id="notifsPageContainer" class="notifsContainer">Loading...</div>

</div>
@endsection
