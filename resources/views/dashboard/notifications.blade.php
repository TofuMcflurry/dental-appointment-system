@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<section class="content">
  <h3>Recent Notifications</h3>
  <div id="notificationsList"></div>
</section>

<style>
  /* Notifications List Styling */
  #notificationsList .notification {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    cursor: pointer;
    transition: background 0.15s;
  }
  #notificationsList .notification:hover {
    background: #f9fbfc;
  }
  #notificationsList .notification:last-child {
    border-bottom: none;
  }
  #notificationsList .notification-icon {
    font-size: 18px;
    color: var(--accent);
  }
  #notificationsList .notification-text {
    display: flex;
    flex-direction: column;
  }
  #notificationsList .notification-text strong {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 2px;
  }
  #notificationsList .notification-text small {
    font-size: 13px;
    color: var(--muted);
  }
  #notificationsList .notification.unread strong {
    font-weight: 700;
  }
  #notificationsList .notification.unread::after {
    content: "";
    width: 8px;
    height: 8px;
    background: #007bff;
    border-radius: 50%;
    margin-left: auto;
    margin-top: 6px;
  }
</style>

<script>
  const notifications = [
    { icon: "🔔", title: "Upcoming appointment", info: "Sept 20, 9:00 AM — Patient: Juan Dela Cruz", unread: true },
    { icon: "❌", title: "Appointment cancelled", info: "Sept 18, 2:00 PM — Patient: Maria Santos", unread: true },
    { icon: "📝", title: "New patient registered", info: "Sept 17, 10:15 AM — Patient: Mark Reyes", unread: false },
    { icon: "📩", title: "Reminder sent", info: "Sept 16, 5:30 PM — Sent to all patients with upcoming appointments", unread: false },
  ];

  const list = document.getElementById("notificationsList");

  function renderNotifications() {
    list.innerHTML = "";
    if (notifications.length === 0) {
      list.innerHTML = `<div class="notification"><div class="notification-text">No notifications</div></div>`;
      return;
    }
    notifications.forEach(n => {
      const div = document.createElement("div");
      div.className = `notification ${n.unread ? "unread" : ""}`;
      div.innerHTML = `
        <div class="notification-icon">${n.icon}</div>
        <div class="notification-text">
          <strong>${n.title}</strong>
          <small>${n.info}</small>
        </div>`;
      div.addEventListener("click", () => div.classList.toggle("unread"));
      list.appendChild(div);
    });
  }

  renderNotifications();
</script>
@endsection
