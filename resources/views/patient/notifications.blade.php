@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div id="notificationsPage" class="page-transition">
  <h3 id="notifTitle">Recent Notifications</h3>

  <div class="notif-header">
    <div class="muted">Your appointment and reminder history.</div>
    <div class="top-controls">
      <form action="{{ route('patient.notifications.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit" class="btn primary">Mark all read</button>
      </form>

      <button id="filterUnreadBtn" class="btn secondary" data-active="0">Show Unread</button>

      <form action="{{ route('patient.notifications.delete-all') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn danger" onclick="return confirm('Clear all notifications? This cannot be undone.')">Clear all</button>
      </form>
    </div>
  </div>

  @if(session('notifications_cleared'))
    <div class="alert alert-info">All notifications have been cleared.</div>
  @endif

  <div class="notifications-list">
    {{-- Appointments --}}
    @if($appointments->count() > 0 && !session('notifications_cleared'))
      <div class="notif-category">
        <h4><i class="fa-solid fa-calendar-days"></i> Appointments</h4>
        @foreach($appointments as $appointment)
          @php
            $itemId = 'appt_' . $appointment->appointment_id;
            $isRead = in_array($itemId, session('read_notifications', [])) || session('notifications_viewed');
            $isDeleted = in_array($itemId, session('deleted_notifications', []));
          @endphp
          @if(!$isDeleted)
            <div class="notif {{ $isRead ? 'read' : 'unread' }}">
              <div class="left">
                <strong>Appointment {{ $appointment->status }}</strong>
                <small>{{ $appointment->dental_service }} — {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, g:i A') }}</small>
              </div>
              <div class="right">
                <small>{{ \Carbon\Carbon::parse($appointment->created_at)->format('M d, g:i A') }}</small>
                <div class="notif-actions">
                  <form action="{{ route('patient.notifications.toggle-read', $itemId) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn small primary-outline">
                      {{ $isRead ? 'Mark unread' : 'Mark read' }}
                    </button>
                  </form>
                  <form action="{{ route('patient.notifications.delete', $itemId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn small danger-outline" onclick="return confirm('Delete this notification?')">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endif

    {{-- Braces Adjustments --}}
    @if($bracesSchedules->count() > 0 && !session('notifications_cleared'))
      <div class="notif-category">
        <h4><i class="fa-solid fa-tooth"></i> Braces Adjustments</h4>
        @foreach($bracesSchedules as $schedule)
          @php
            $itemId = 'brace_' . $schedule->schedule_id;
            $isRead = in_array($itemId, session('read_notifications', [])) || session('notifications_viewed');
            $isDeleted = in_array($itemId, session('deleted_notifications', []));
          @endphp
          @if(!$isDeleted)
            <div class="notif {{ $isRead ? 'read' : 'unread' }}">
              <div class="left">
                <strong>Next Adjustment Scheduled</strong>
                <small>Your next braces adjustment is on {{ \Carbon\Carbon::parse($schedule->next_adjustment_date)->format('F j, Y') }}</small>
              </div>
              <div class="right">
                <small>{{ \Carbon\Carbon::parse($schedule->created_at)->format('M d, g:i A') }}</small>
                <div class="notif-actions">
                  <form action="{{ route('patient.notifications.toggle-read', $itemId) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn small primary-outline">
                      {{ $isRead ? 'Mark unread' : 'Mark read' }}
                    </button>
                  </form>
                  <form action="{{ route('patient.notifications.delete', $itemId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn small danger-outline" onclick="return confirm('Delete this notification?')">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endif

    {{-- Email Reminders --}}
    @if($sentReminders->count() > 0 && !session('notifications_cleared'))
      <div class="notif-category">
        <h4><i class="fa-solid fa-envelope-circle-check"></i> Email Reminders</h4>
        @foreach($sentReminders as $reminder)
          @php
            $itemId = 'reminder_' . $reminder->reminder_id;
            $isRead = in_array($itemId, session('read_notifications', [])) || session('notifications_viewed');
            $isDeleted = in_array($itemId, session('deleted_notifications', []));
          @endphp
          @if(!$isDeleted)
            <div class="notif {{ $isRead ? 'read' : 'unread' }}">
              <div class="left">
                <strong>
                  @if($reminder->type == '7days_before')
                    7 Days Before Reminder
                  @elseif($reminder->type == '3days_before')
                    3 Days Before Reminder
                  @else
                    Day Of Reminder
                  @endif
                </strong>
                <small>Sent on {{ \Carbon\Carbon::parse($reminder->sent_at)->format('M j, g:i A') }}</small>
              </div>
              <div class="right">
                <small>{{ \Carbon\Carbon::parse($reminder->sent_at)->format('M d') }}</small>
                <div class="notif-actions">
                  <form action="{{ route('patient.notifications.toggle-read', $itemId) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn small primary-outline">
                      {{ $isRead ? 'Mark unread' : 'Mark read' }}
                    </button>
                  </form>
                  <form action="{{ route('patient.notifications.delete', $itemId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn small danger-outline" onclick="return confirm('Delete this notification?')">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endif

    @if((!$appointments->count() || session('notifications_cleared')) && (!$bracesSchedules->count() || session('notifications_cleared')) && (!$sentReminders->count() || session('notifications_cleared')))
      <div class="muted no-data">No notifications</div>
    @endif
  </div>
</div>
@endsection
