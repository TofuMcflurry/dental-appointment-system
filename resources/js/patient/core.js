// core.js — App orchestration

import { DashboardPage } from './dashboard.js';
import { AppointmentsPage } from './appointments.js';
import { NotificationPage } from './notification.js';
import { SettingsPage } from './settings.js';

class App {
  constructor() {
    console.log("✅ Core.js (App) connected!");

    this.pages = {
      dashboard: new DashboardPage('dashboard', 'Dashboard', this),
      appointments: new AppointmentsPage('appointments', 'Appointments', this),
      notifications: new NotificationPage('notifications', 'Notifications', this),
      settings: new SettingsPage('settings', 'Settings', this)
    };

    this.pages.dashboard.show();
    this.pages.dashboard.render();

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

export { App };
