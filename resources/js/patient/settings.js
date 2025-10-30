import { DarkMode } from './base.js';
import { Page } from './base.js';

class SettingsPage extends Page {
  constructor(containerId = 'settingsPage', title = 'Settings', app = null) {
    super(containerId, title, app);
    
    if (this.container) {
      this._wireControls();
    }
  }

  _wireControls() {
    if (!this.container) return;

    const form = this.container.querySelector('#settingsForm');
    const togglePw = this.container.querySelector('#togglePassword');
    const pwField = this.container.querySelector('#password');
    const darkMode = this.container.querySelector('#dark_mode');
    const saveBtn = this.container.querySelector('#saveBtn');

    console.log('🔧 Wiring controls...');
    console.log('Toggle button:', togglePw);
    console.log('Password field:', pwField);
    console.log('Save button:', saveBtn);

    // Toggle password visibility
    if (togglePw && pwField) {
      togglePw.addEventListener('click', () => {
        console.log('👁️ Toggle button clicked');
        const isHidden = pwField.type === 'password';
        pwField.type = isHidden ? 'text' : 'password';
        togglePw.textContent = isHidden ? 'Hide' : 'Show';
        console.log('Password type changed to:', pwField.type);
      });
    } else {
      console.log('❌ Toggle elements not found');
    }

    // Dark mode toggle
    darkMode?.addEventListener('change', (e) => {
      const isDarkMode = e.target.checked;
      localStorage.setItem('darkMode', isDarkMode ? 'true' : 'false');
      DarkMode.apply();
    });

    // Form submission - FIXED WITH ALERT AND REDIRECT
form?.addEventListener('submit', async (e) => {
  e.preventDefault();
  
  let saveBtn = this.container.querySelector('#saveBtn');
  let data; // Declare data variable for finally block
  
  // Prevent multiple clicks only if saveBtn exists
  if (saveBtn && saveBtn.disabled) {
    console.log('🛑 Button already clicked, ignoring...');
    return;
  }
  
  // Set loading state only if saveBtn exists
  const originalText = saveBtn ? saveBtn.textContent : 'Save Changes';
  if (saveBtn) {
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';
  }
  
  const formData = new FormData(form);
  
  try {
    console.log('🔄 Sending request...');
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
      },
      body: formData
    });

    data = await response.json(); // Assign to the outer variable

    console.log('📊 Response status:', response.status);
    console.log('📦 Response data:', data);

    // Check for OTP required - SHOW ALERT AND REDIRECT
    if (data.otp_required === true) {
      console.log('🔐 OTP required, redirecting...');
      // Re-enable button briefly before redirect
      if (saveBtn) {
        saveBtn.disabled = false;
        saveBtn.textContent = originalText;
      }
      alert('📧 ' + data.message); // ✅ ADDED BACK THE ALERT
      window.location.href = '/patient/verify-otp';
      return;
    }

    // Handle success
    if (response.ok) {
      alert('✅ ' + (data.message || 'Settings saved successfully!'));
      const darkModeChecked = darkMode?.checked || false;
      localStorage.setItem('darkMode', darkModeChecked ? 'true' : 'false');
      DarkMode.apply();
    } else {
      // Handle errors
      if (data.errors) {
        const errorMessages = Object.values(data.errors).flat().join('\n');
        alert('❌ ' + errorMessages);
      } else {
        alert('❌ ' + (data.message || 'Error saving settings'));
      }
    }
  } catch (error) {
    console.error('Error:', error);
    alert('❌ Network error - please try again');
  } finally {
    // Always re-enable button (except when redirecting)
    if (saveBtn && !data?.otp_required) {
      saveBtn.disabled = false;
      saveBtn.textContent = 'Save Changes';
    }
  }
});

    // Cancel button
    this.container.querySelector('#cancelBtnSettings')?.addEventListener('click', () => {
      if (confirm('Discard all changes?')) {
        window.location.reload();
      }
    });
  }
}

export { SettingsPage };