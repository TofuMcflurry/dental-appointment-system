/* App class */
class App {
  constructor() {
    console.log("✅ Core.js connected!");

    // Register all pages here
    this.pages = {
      dashboard: new DashboardPage("dashboard", "Dashboard", this),
      appointments: new AppointmentsPage("appointments", "Appointments", this),
      notifications: new NotificationsPage("notifications", "Notifications", this),
      settings: new SettingsPage("settings", "Settings", this)
    };

    // Show default page
    this.currentPage = this.pages.dashboard;
    this.currentPage.show();

    // Enable navigation clicks
    this.initNavigation();
  }

  initNavigation() {
    document.querySelectorAll(".nav a").forEach(link => {
      link.addEventListener("click", (e) => {
        const page = e.target.dataset.page;
        this.navigate(page);
      });
    });
  }

  navigate(page) {
    if (this.pages[page]) {
      this.currentPage = this.pages[page];
      this.currentPage.show();
    } else {
      console.error(`Page not found: ${page}`);
    }
  }
}

// Boot the app once DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  new App();
});
