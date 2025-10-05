import { DataStore, fmtDate, escapeHtml, Page } from './base.js';
import { DashboardPage } from './dashboard.js';
import { AppointmentsPage } from './appointments.js';
import { NotificationPage } from './notification.js';

class SettingsPage extends Page {
  render() {
    if (!this.container) {
      console.warn(`SettingsPage: container not found for id "${this.id}"`);
      return;
    }

    const data = DataStore.load() || {};
    const name = localStorage.getItem('patientName') || '';
    const dm = localStorage.getItem('darkMode') === 'true';

    this.container.innerHTML = `
      <h3 id="settingsTitle">Profile Settings</h3>
      <div class="form-group"><label id="lblName">Name</label><input type="text" id="name" placeholder="Enter your name" value="${escapeHtml(name)}"></div>
      <div class="form-group"><label id="lblEmail">Email</label><input type="email" id="email" placeholder="Enter your email" value="${escapeHtml(data.email || '')}"></div>
      <div class="form-group"><label id="lblPhone">Phone</label><input type="tel" id="phone" placeholder="Enter your phone" value="${escapeHtml(data.phone || '')}"></div>

      <h3 id="securityTitle">Security</h3>
      <div class="form-group">
        <label id="lblPassword">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" placeholder="Enter new password">
          <button type="button" class="show-pass" id="togglePassword">Show</button>
        </div>
      </div>

      <h3 id="prefTitle">Preferences</h3>
      <div class="checkbox-group"><input type="checkbox" id="emailNotif" ${data.emailNotif ? 'checked' : ''}><label for="emailNotif" id="lblEmailNotif">Enable Email Notification</label></div>
      <div class="checkbox-group"><input type="checkbox" id="darkMode" ${dm ? 'checked' : ''}><label for="darkMode" id="lblDarkMode">Dark Mode</label></div>

      <h3 id="langTitle">Language</h3>
      <div class="form-group">
        <select id="language">
          <option value="en">English</option>
          <option value="fil">Filipino</option>
        </select>
      </div>

      <div class="actions">
        <button class="btn save" id="saveBtn">Save Changes</button>
        <button class="btn cancel" id="cancelBtnSettings">Cancel</button>
      </div>
    `;

    this._wireControls();
  }

  _wireControls() {
    if (!this.container) return;

    const langSelect = this.container.querySelector('#language');
    if (langSelect) langSelect.value = localStorage.getItem('language') || 'en';

    this.container.querySelector('#togglePassword')?.addEventListener('click', () => {
      const pw = this.container.querySelector('#password');
      const btn = this.container.querySelector('#togglePassword');
      if (pw && btn) {
        const t = pw.type === 'password' ? 'text' : 'password';
        pw.type = t;
        btn.textContent = t === 'password' ? 'Show' : 'Hide';
      }
    });

    this.container.querySelector('#darkMode')?.addEventListener('change', (e) => {
      const v = e.target.checked;
      localStorage.setItem('darkMode', v ? 'true' : 'false');
      document.body.classList.toggle('dark', v);
    });

    this.container.querySelector('#saveBtn')?.addEventListener('click', () => {
      const d = DataStore.load() || {};
      d.email = this.container.querySelector('#email')?.value || '';
      d.phone = this.container.querySelector('#phone')?.value || '';
      d.emailNotif = this.container.querySelector('#emailNotif')?.checked || false;
      DataStore.save(d);

      const nameField = this.container.querySelector('#name')?.value.trim();
      if (nameField) localStorage.setItem('patientName', nameField);

      const lang = this.container.querySelector('#language')?.value || 'en';
      localStorage.setItem('language', lang);

      const dmVal = this.container.querySelector('#darkMode')?.checked || false;
      localStorage.setItem('darkMode', dmVal ? 'true' : 'false');
      document.body.classList.toggle('dark', dmVal);

      this.app.checkLoginUI?.();
      alert('✅ Settings saved (demo)');
    });

    this.container.querySelector('#cancelBtnSettings')?.addEventListener('click', () => this.render());
  }
}

export { SettingsPage };
