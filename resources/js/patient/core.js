// core.js - FIXED VERSION
import { DashboardPage } from './dashboard.js';
import { AppointmentsPage } from './appointments.js';
import { SettingsPage } from './settings.js';

class App {
  constructor() {
    console.log("✅ Core.js (App) connected!");

    // Initialize pages ONLY if their containers exist
    this.pages = {};
    
    // Dashboard
    if (document.getElementById('dashboardPage')) {
      this.pages.dashboard = new DashboardPage('dashboardPage', 'Dashboard', this);
    }
    
    // Appointments
    if (document.getElementById('appointmentsPage')) {
      this.pages.appointments = new AppointmentsPage('appointmentsPage', 'Appointments', this);
    }
    
    // Settings
    if (document.getElementById('settingsPage')) {
      this.pages.settings = new SettingsPage('settingsPage', 'Settings', this);
    }

    console.log(`📄 Pages initialized:`, Object.keys(this.pages));

    // --- Show the current page ---
    const currentPageId = document.getElementById('dashboardPage') ? 'dashboard' :
                          document.getElementById('appointmentsPage') ? 'appointments' :
                          document.getElementById('notificationsPage') ? 'notifications' :
                          document.getElementById('settingsPage') ? 'settings' : null;

    console.log(`📍 Current page: ${currentPageId}`);

    // Special handling for notifications page (PHP/Blade)
    if (currentPageId === 'notifications') {
      console.log('🔔 Notifications page - using PHP/Blade rendering');
      const notificationsContainer = document.getElementById('notificationsPage');
      if (notificationsContainer) {
        notificationsContainer.style.display = 'block';
        notificationsContainer.classList.add('active');
      }
      this._setupNotificationsFilters();
      
    } else if (currentPageId && this.pages[currentPageId]) {
      // For JavaScript pages
      console.log(`🔄 Showing ${currentPageId} page`);
      this.pages[currentPageId].show();
      this.pages[currentPageId].render();
    }

    // --- Page navigation ---
    this._setupNavigation();
  }

  _setupNavigation() {
    document.querySelectorAll('[data-page]').forEach(el => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        const target = el.dataset.page;
        
        if (target === 'notifications') {
          // Handle notifications page navigation
          window.location.href = '/patient/notifications';
        } else if (this.pages[target]) {
          // Handle JavaScript pages
          this.pages[target].show();
          this.pages[target].render();
        }
      });
    });
  }

  _setupNotificationsFilters() {
    const filterUnreadBtn = document.getElementById('filterUnreadBtn');
    
    if (filterUnreadBtn) {
      filterUnreadBtn.addEventListener('click', function() {
        const active = this.dataset.active === '1';
        this.dataset.active = active ? '0' : '1';
        this.textContent = active ? 'Show Unread' : 'Show All';
        
        const notifications = document.querySelectorAll('.notif');
        notifications.forEach(notif => {
          if (active) {
            notif.style.display = 'flex';
          } else {
            if (notif.classList.contains('unread')) {
              notif.style.display = 'flex';
            } else {
              notif.style.display = 'none';
            }
          }
        });
      });
    }
  }
}

export { App };

// Initialize app only on relevant pages
window.addEventListener('DOMContentLoaded', () => {
  const hasAnyPageContainer = 
    document.getElementById('dashboardPage') ||
    document.getElementById('appointmentsPage') ||
    document.getElementById('notificationsPage') || 
    document.getElementById('settingsPage');

  if (hasAnyPageContainer) {
    console.log('🚀 Initializing App');
    new App();
  }
});