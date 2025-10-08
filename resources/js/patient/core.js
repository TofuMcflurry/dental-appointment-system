import { DashboardPage } from './dashboard.js';
import { AppointmentsPage } from './appointments.js';
import { NotificationPage } from './notification.js';
import { SettingsPage } from './settings.js';

class App {
  constructor() {
    console.log("✅ Core.js (App) connected!");

    // Initialize all pages (pass container ID, title, and reference to this app)
    this.pages = {
      dashboard: new DashboardPage('dashboardPage', 'Dashboard', this),
      appointments: new AppointmentsPage('appointmentsPage', 'Appointments', this),
      notifications: new NotificationPage('notificationsPage', 'Notifications', this),
      settings: new SettingsPage('settingsPage', 'Settings', this)
    };

    // --- Determine which page exists in the current DOM ---
    const currentPageId = document.getElementById('dashboardPage') ? 'dashboard' :
                          document.getElementById('appointmentsPage') ? 'appointments' :
                          document.getElementById('notificationsPage') ? 'notifications' :
                          document.getElementById('settingsPage') ? 'settings' : null;

    if(currentPageId && this.pages[currentPageId]) {
        this.pages[currentPageId].show();
        this.pages[currentPageId].render();
    } else {
        console.warn('No recognized page container found in this Blade.');
    }

    // --- Page navigation ---
    document.querySelectorAll('[data-page]').forEach(el => {
      el.addEventListener('click', () => {
        const target = el.dataset.page;
        if (this.pages[target]) {
          this.pages[target].show();
          this.pages[target].render();
        }
      });
    });
  }
}

// Export App for use in Blade (if needed)
export { App };
// Initialize app after DOM is ready
window.addEventListener('DOMContentLoaded', () => {
  const dashboardEl = document.getElementById('dashboardPage');
  const appointmentsEl = document.getElementById('appointmentsPage');
  const notificationsEl = document.getElementById('notificationsPage');
  const settingsEl = document.getElementById('settingsPage');

  if (dashboardEl || appointmentsEl || notificationsEl || settingsEl) {
    new App();
  } else {
    console.warn("No page container found — App not initialized.");
  }
});
