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

    // ✅ FIXED FORM SUBMISSION WITH BUTTON STATE MANAGEMENT
    form?.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      console.log('🔄 Form submission started...');
      
      let saveBtn = this.container.querySelector('#saveBtn');
      let data;
      
      // ✅ ADDED: Prevent multiple clicks
      if (saveBtn && saveBtn.disabled) {
        console.log('🛑 Button already clicked, ignoring...');
        return;
      }
      
      // ✅ ADDED: Set loading state
      const originalText = saveBtn ? saveBtn.textContent : 'Save Changes';
      if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
      }
      
      const formData = new FormData(form);
      
      try {
        console.log('📤 Sending request to:', form.action);
        
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          body: formData
        });

        console.log('📥 Response status:', response.status);
        console.log('📥 Response ok:', response.ok);

        data = await response.json();
        console.log('📦 Response data:', data);

        // Check for OTP required
        if (data.otp_required === true) {
          console.log('🔐 OTP required, redirecting...');
          // ✅ ADDED: Re-enable button before redirect
          if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
          }
          window.showToast({
            title: 'Verification Required!',
            message: data.message,
            type: 'info',
            duration: 3000
          });
          setTimeout(() => {
            window.location.href = '/patient/verify-otp';
          }, 1500);
          return;
        }

        // Handle success
        if (response.ok) {
          window.showToast({
            title: 'Success!',
            message: data.message || 'Settings updated successfully!',
            type: 'success'
          });
          const darkModeChecked = darkMode?.checked || false;
          localStorage.setItem('darkMode', darkModeChecked ? 'true' : 'false');
          DarkMode.apply();
        } else {
          // Handle errors
          if (data.errors) {
            const errorMessages = Object.values(data.errors).flat().join('\n');
            window.showToast({
              title: 'Error',
              message: errorMessages,
              type: 'error'
            });
          } else {
            window.showToast({
              title: 'Error',
              message: data.message || 'Error saving settings',
              type: 'error'
            });
          }
        }
      } catch (error) {
        console.error('❌ Fetch error details:', error);
        console.error('❌ Error name:', error.name);
        console.error('❌ Error message:', error.message);
        
        window.showToast({
          title: 'Network Error',
          message: 'Please check your connection and try again',
          type: 'error'
        });
      } finally {
        // ✅ ADDED: Always re-enable button (except when redirecting)
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