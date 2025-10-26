import { DataStore, fmtDate, isSameDay, escapeHtml } from './base.js';

class DashboardPage {
  constructor(containerId = 'dashboardPage') {
    this.container = document.getElementById(containerId);
    if (!this.container) {
      console.warn(`DashboardPage: container not found for id "${containerId}"`);
      return;
    }

    // Load initial data
    this.data = window.patientData || DataStore.load() || {
      appointments: [],
      notifications: [],
      bracesColor: 'BLACK'
    };

    this.render();
  }

  show() {
    if (!this.container) {
      console.warn('DashboardPage: Cannot show - container not found');
      return;
    }

    document.querySelectorAll('.page-transition').forEach(el => {
      el.classList.remove('active');
      el.style.display = 'none';
    });

    this.container.classList.add('page-transition');
    this.container.style.display = 'block';
    setTimeout(() => this.container.classList.add('active'), 10);
  }

  render() {
    if (!this.container) return;

    this._renderSummary();
    this._renderAppointments();
    this._renderBracesGrid();
    this._renderNotifications();
    this._setupEventListeners();
  }

  _renderSummary() {
    const now = new Date();
    const next = this.data.appointments
      .filter(a => !a.cancelled && new Date(a.datetime) > now)
      .sort((a, b) => new Date(a.datetime) - new Date(b.datetime))[0];

    const remindersToday = this.data.notifications
      .filter(n => n.type === 'reminder' && isSameDay(n.datetime, now.toISOString()))
      .length;

    const nextEl = this.container.querySelector('#nextAppointment');
    const statusEl = this.container.querySelector('#statusConfirmed');
    const remindersEl = this.container.querySelector('#remindersToday');

    if (nextEl) nextEl.textContent = next ? `${escapeHtml(next.title)} — ${escapeHtml(fmtDate(next.datetime))}` : 'No upcoming appointment';
    if (statusEl) statusEl.textContent = next ? (next.confirmed ? 'Confirmed' : 'Pending confirmation') : '—';
    if (remindersEl) remindersEl.textContent = remindersToday;
  }

  _renderAppointments() {
    const apptsContainer = this.container.querySelector('#apptsContainer');
    if (!apptsContainer) return;

    apptsContainer.innerHTML = '';

    if (!this.data.appointments?.length) {
      apptsContainer.innerHTML = '<div class="muted">No appointments</div>';
      return;
    }

    const now = new Date();
    const sorted = [...this.data.appointments].sort((a, b) => new Date(a.datetime) - new Date(b.datetime));

    sorted.forEach(a => {
      let statusClass = 'status-upcoming';
      let statusText = 'Upcoming';
      if (a.cancelled) {
        statusClass = 'status-cancelled';
        statusText = 'Cancelled';
      } else if (new Date(a.datetime) < now && !a.attended) {
        statusClass = 'status-missed';
        statusText = 'Missed';
      } else if (a.confirmed && !a.cancelled) {
        statusClass = 'status-upcoming-confirmed';
        statusText = 'Upcoming (Confirmed)';
      }

      const apptDiv = document.createElement('div');
      apptDiv.className = 'appt';
      apptDiv.innerHTML = `
        <div class="meta">
          <strong>${escapeHtml(a.title)}</strong>
          <span class="time">${fmtDate(a.datetime)}</span>
        </div>
        <div>
          <span class="status-pill ${statusClass}">${escapeHtml(statusText)}</span>
        </div>
      `;
      apptsContainer.appendChild(apptDiv);
    });
  }

  _renderBracesGrid() {
    const bracesGrid = this.container.querySelector('#bracesGrid');
    const selectedText = this.container.querySelector('#selectedColorText');
    if (!bracesGrid || !selectedText) return;

    const colors = ['BLACK', 'GRAY', 'ORANGE', 'RED', 'VIOLET', 'INDIGO', 'BLUE', 'CYAN', 'TEAL', 'GREEN', 'YELLOW', 'PINK', 'WHITE', 'MAROON', 'BROWN'];
    bracesGrid.innerHTML = '';

    colors.forEach(c => {
      const box = document.createElement('div');
      box.className = 'color-box';
      box.style.background = c.toLowerCase() === 'white' ? '#ffffff' : c;
      if (c.toLowerCase() === (this.data.bracesColor || '').toLowerCase()) box.classList.add('selected');
      box.title = c;
      box.addEventListener('click', () => {
        this.data.bracesColor = c;
        DataStore.save(this.data);
        this.render();
      });
      bracesGrid.appendChild(box);
    });

    selectedText.textContent = this.data.bracesColor || '—';
  }

  _renderNotifications() {
    const notifsContainer = this.container.querySelector('#notifsContainer');
    if (!notifsContainer) return;

    notifsContainer.innerHTML = '';

    if (!this.data.notifications?.length) {
      notifsContainer.innerHTML = '<div class="muted">No notifications</div>';
      return;
    }

    this.data.notifications.forEach(n => {
      const notifDiv = document.createElement('div');
      notifDiv.className = `notif ${n.read ? 'read' : 'unread'}`;
      notifDiv.innerHTML = `<strong>${escapeHtml(n.title)}</strong> — <span>${fmtDate(n.datetime)}</span>`;
      notifsContainer.appendChild(notifDiv);
    });
  }

  _setupEventListeners() {
    const simulateBtn = this.container.querySelector('#simulateReminder');
    const clearBtn = this.container.querySelector('#clearRead');

    simulateBtn?.addEventListener('click', () => this.simulateReminder());
    clearBtn?.addEventListener('click', () => this.clearReadNotifications());
  }

  simulateReminder() {
    alert('Simulate reminder clicked! (You can integrate real logic here)');
  }

  clearReadNotifications() {
    this.data.notifications = this.data.notifications.map(n => ({ ...n, read: true }));
    DataStore.save(this.data);
    this._renderNotifications();
  }
}

export { DashboardPage };

// Safe initialization - only initialize if we're on the dashboard page
document.addEventListener('DOMContentLoaded', function() {
  const dashboardContainer = document.getElementById('dashboardPage');
  if (dashboardContainer && !window.dashboardInitialized) {
    window.dashboardInitialized = true;
    const dashboardPage = new DashboardPage();
  }
});