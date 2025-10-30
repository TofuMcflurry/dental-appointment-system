import { DataStore, DarkMode } from './base.js';
import { Page } from './base.js';

class SettingsPage extends Page {
  constructor(containerId = 'settingsPage', title = 'Settings', app = null) {
    super(containerId, title, app);
    
    if (this.container) {
      this.render();
    }
  }

  render() {
    if (!this.container) {
      console.warn(`SettingsPage: container not found for id "${this.id}"`);
      return;
    }

    // Load previously stored data and apply to form fields
    const data = DataStore.load() || {};
    const name = localStorage.getItem('patientName') || '';
    const dm = DarkMode.isEnabled();
    const lang = localStorage.getItem('language') || 'en';

    // Apply values to existing inputs from Blade
    const nameField = this.container.querySelector('#name');
    const emailField = this.container.querySelector('#email');
    const phoneField = this.container.querySelector('#phone');
    const emailNotif = this.container.querySelector('#emailNotif');
    const darkMode = this.container.querySelector('#darkMode');
    const language = this.container.querySelector('#language');

    if (nameField) nameField.value = name;
    if (emailField) emailField.value = data.email || '';
    if (phoneField) phoneField.value = data.phone || '';
    if (emailNotif) emailNotif.checked = !!data.emailNotif;
    if (darkMode) darkMode.checked = dm;
    if (language) language.value = lang;

    this._wireControls();
  }

  _wireControls() {
    if (!this.container) return;

    const togglePw = this.container.querySelector('#togglePassword');
    const pwField = this.container.querySelector('#password');

    // Toggle password visibility
    togglePw?.addEventListener('click', () => {
      if (pwField) {
        const isHidden = pwField.type === 'password';
        pwField.type = isHidden ? 'text' : 'password';
        togglePw.textContent = isHidden ? 'Hide' : 'Show';
      }
    });

    // Dark mode toggle - GLOBAL
    this.container.querySelector('#darkMode')?.addEventListener('change', (e) => {
      const isDarkMode = e.target.checked;
      localStorage.setItem('darkMode', isDarkMode ? 'true' : 'false');
      DarkMode.apply(); // This will apply globally
    });

    // Save button logic
    this.container.querySelector('#saveBtn')?.addEventListener('click', () => {
      const d = DataStore.load() || {};
      d.email = this.container.querySelector('#email')?.value || '';
      d.phone = this.container.querySelector('#phone')?.value || '';
      d.emailNotif = this.container.querySelector('#emailNotif')?.checked || false;
      DataStore.save(d);

      const nameVal = this.container.querySelector('#name')?.value.trim();
      if (nameVal) localStorage.setItem('patientName', nameVal);

      const lang = this.container.querySelector('#language')?.value || 'en';
      localStorage.setItem('language', lang);

      const isDarkMode = this.container.querySelector('#darkMode')?.checked || false;
      localStorage.setItem('darkMode', isDarkMode ? 'true' : 'false');
      DarkMode.apply(); // Apply dark mode globally

      this.app?.checkLoginUI?.();
      alert('✅ Settings saved!');
    });

    // Cancel button reloads current values
    this.container.querySelector('#cancelBtnSettings')?.addEventListener('click', () => this.render());
  }
}

export { SettingsPage };