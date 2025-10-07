// dashboard.js

import { Page, DataStore, fmtDate, isSameDay, escapeHtml } from './base.js';

class DashboardPage extends Page {
  render() {
    if (!this.container) {
      console.warn(`DashboardPage: container not found for id "${this.id}"`);
      return;
    }

    const data = window.patientData || DataStore.load() || {
      appointments: [],
      notifications: [],
      bracesColor: 'BLACK'
    };

    const now = new Date();
    const next = data.appointments
      .filter(a => !a.cancelled && new Date(a.datetime) > now)
      .sort((a, b) => new Date(a.datetime) - new Date(b.datetime))[0];

    const remindersToday = data.notifications
      .filter(n => n.type === 'reminder' && isSameDay(n.datetime, now.toISOString()))
      .length;

    this.container.innerHTML = `
      <h3 id="dashTitle">Welcome to LCAD Dental Care</h3>
      <p id="dashText" class="muted">This is your patient dashboard. Use the sidebar to manage appointments, view notifications, and update your settings.</p>

      <div class="overview" style="margin-top:16px">
        <div class="card">
          <h4>Next Appointment</h4>
          <p id="nextAppointment" class="muted">${next ? `${escapeHtml(next.title)} — ${escapeHtml(fmtDate(next.datetime))}` : 'No upcoming appointment'}</p>
        </div>
        <div class="card">
          <h4>Status</h4>
          <p id="statusConfirmed" class="muted">${next ? (next.confirmed ? 'Confirmed' : 'Pending confirmation') : '—'}</p>
        </div>
        <div class="card">
          <h4>Reminders Received Today</h4>
          <p id="remindersToday" class="muted">${remindersToday}</p>
        </div>
      </div>

      <div class="appointments-section">
        <div class="card appointments-list">
          <h4>Appointments</h4>
          <div id="apptsContainer" style="margin-top:10px"></div>
        </div>

        <div class="card braces-section">
          <h4>Braces Color</h4>
          <div class="muted" style="font-size:13px">Click to choose preferred color</div>
          <div class="braces-grid" id="bracesGrid"></div>
          <div style="margin-top:12px;font-size:13px" class="muted">Selected: <span id="selectedColorText">${escapeHtml(data.bracesColor || '—')}</span></div>
        </div>
      </div>

      <div class="card notifications-list">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
          <h4 style="margin:0">Notifications</h4>
          <div class="top-controls">
            <button id="simulateReminder" class="simulate-admin" title="Simulate admin sending a reminder">Admin: Send Reminder</button>
            <button id="clearRead" class="btn cancel" style="padding:6px 10px">Clear Read</button>
          </div>
        </div>
        <div id="notifsContainer" class="notifsContainer"></div>
      </div>
    `;

    this._renderAppointmentsList(data);
    this._renderBracesGrid(data);

    if (this.app?.pages?.notifications?.render) {
      this.app.pages.notifications.render();
    }

    this.container.querySelector('#simulateReminder')?.addEventListener('click', () => {
    this.app.simulateReminder();
    });
    this.container.querySelector('#clearRead')?.addEventListener('click', () => this.app.clearReadNotifications());
  }

  _renderAppointmentsList(data) {
    const apptsContainer = this.container.querySelector('#apptsContainer');
    if (!apptsContainer) return;

    apptsContainer.innerHTML = '';
    if (!data.appointments?.length) {
      apptsContainer.innerHTML = '<div class="muted">No appointments</div>';
      return;
    }

    const now = new Date();
    const sorted = [...data.appointments].sort((a, b) => new Date(a.datetime) - new Date(b.datetime));

    sorted.forEach(a => {
      let statusClass = 'status-upcoming';
      let statusText = 'Upcoming';

      if (a.cancelled) {
        statusClass = 'status-cancelled';
        statusText = 'Cancelled';
      } else if (new Date(a.datetime) < now && !a.attended) {
        statusClass = 'status-missed';
        statusText = 'Missed';
      } else if (new Date(a.datetime) > now) {
        statusClass = 'status-upcoming';
        statusText = 'Upcoming';
      }

      if (a.confirmed && !a.cancelled) {
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

  _renderBracesGrid(data) {
    const bracesGrid = this.container.querySelector('#bracesGrid');
    if (!bracesGrid) return;

    const colors = ['BLACK', 'GRAY', 'ORANGE', 'RED', 'VIOLET', 'INDIGO', 'BLUE', 'CYAN', 'TEAL', 'GREEN', 'YELLOW', 'PINK', 'WHITE', 'MAROON', 'BROWN'];
    bracesGrid.innerHTML = '';

    colors.forEach(c => {
      const box = document.createElement('div');
      box.className = 'color-box';
      box.style.background = c.toLowerCase() === 'white' ? '#ffffff' : c;
      if (c.toLowerCase() === (data.bracesColor || '').toLowerCase()) box.classList.add('selected');
      box.title = c;
      box.addEventListener('click', () => {
        data.bracesColor = c;
        DataStore.save(data);
        this.render();
      });
      bracesGrid.appendChild(box);
    });

    const selectedText = this.container.querySelector('#selectedColorText');
    if (selectedText) selectedText.textContent = data.bracesColor || '—';
  }
}

export { DashboardPage };
