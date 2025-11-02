// Only run this code if we're on the audit trail page
if (document.getElementById('notificationsList')) {
    const notifications = [
        { icon: "🔔", title: "Upcoming appointment", info: "Sept 20, 9:00 AM — Patient: Juan Dela Cruz", unread: true },
        { icon: "❌", title: "Appointment cancelled", info: "Sept 18, 2:00 PM — Patient: Maria Santos", unread: true },
        { icon: "📝", title: "New patient registered", info: "Sept 17, 10:15 AM — Patient: Mark Reyes", unread: false },
        { icon: "📩", title: "Reminder sent", info: "Sept 16, 5:30 PM — Sent to all patients with upcoming appointments", unread: false },
    ];

    const list = document.getElementById("notificationsList");

    function renderNotifications() {
        // Add null check for safety
        if (!list) return;
        
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
}