import { Page, DataStore, fmtDate } from './base.js';

class AppointmentsPage extends Page {
  render() {
    const data = DataStore.load() || { appointments: [] };
    this._wireControls();
    this._renderApptList();
    this._updateApptSummary();
  }

  show() {
    document.querySelectorAll('.page-transition').forEach(el => {
      el.classList.remove('active');
      el.style.display = 'none';
    });

    if (this.container) {
      this.container.classList.add('page-transition');
      this.container.style.display = 'block';
      setTimeout(() => this.container.classList.add('active'), 10);
    }

    const titleEl = document.getElementById('page-title');
    if (titleEl) titleEl.textContent = this.title || 'Appointments';
  }

  _wireControls() {
    const apptDate = this.container.querySelector('#apptDate');
    const apptTime = this.container.querySelector('#apptTime');
    const servicesList = this.container.querySelector('#servicesList');
    const nameInput = this.container.querySelector('#patientName');
    const contactInput = this.container.querySelector('#patientContact');
    const genderSelect = this.container.querySelector('#gender');
    const cancelBtn = this.container.querySelector('#cancelApptBtn');
    const bookBtn = this.container.querySelector('#bookApptBtn');
    const form = this.container.querySelector('form'); // Get the form

    [apptDate, apptTime, nameInput, contactInput, genderSelect].forEach(el => {
      if (el) el.addEventListener('input', () => this._updateApptSummary());
    });
    if (servicesList)
      servicesList.addEventListener('change', () => this._updateApptSummary());

    if (cancelBtn) cancelBtn.addEventListener('click', () => this._clearApptForm());
    
    if (bookBtn) bookBtn.addEventListener('click', (e) => {
      e.preventDefault();  // Prevent default form submit
      this._bookAppt();
    });

    // Also prevent form submission
    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent the form from submitting normally
        this._bookAppt();
      });
    }
  }

  _updateApptSummary() {
    const d = this.container.querySelector('#apptDate')?.value || '—';
    const t = this.container.querySelector('#apptTime')?.value || '—';
    const s =
      (this.container.querySelector('input[name="dental_service"]:checked')?.value) ||  // Fixed selector
      '—';

    const dateEl = this.container.querySelector('#summaryDate');
    const timeEl = this.container.querySelector('#summaryTime');
    const serviceEl = this.container.querySelector('#summaryService');

    if (dateEl) dateEl.textContent = `Date: ${d}`;
    if (timeEl) timeEl.textContent = `Time: ${t}`;
    if (serviceEl) serviceEl.textContent = `Service: ${s}`;
  }

  _clearApptForm() {
    const f = this.container;
    f.querySelector('#patientName').value = '';
    f.querySelector('#patientContact').value = '';
    f.querySelector('#apptDate').value = '';
    f.querySelector('#apptTime').value = '';
    f.querySelector('#gender').value = '';
    const sel = f.querySelector('input[name="dental_service"]:checked');  // Fixed selector
    if (sel) sel.checked = false;
    f.querySelector('#notes').value = '';
    this._updateApptSummary();
  }

  async _bookAppt() {
    // Get form values
    const patientName = this.container.querySelector('#patientName')?.value || '';
    const contact = this.container.querySelector('#patientContact')?.value || '';
    const gender = this.container.querySelector('#gender')?.value || '';
    const service = this.container.querySelector('input[name="dental_service"]:checked')?.value || '';
    const date = this.container.querySelector('#apptDate')?.value || '';
    const time = this.container.querySelector('#apptTime')?.value || '';
    const notes = this.container.querySelector('#notes')?.value || '';

    // Basic validation
    if (!patientName || !contact || !gender || !service || !date || !time) {
      alert('Please fill in all required fields');
      return;
    }

    // Show confirmation modal instead of immediately submitting
    this._showConfirmationModal({
      patientName,
      contact,
      gender,
      service,
      date,
      time,
      notes,
      endTime: this._calculateEndTime(time),
      refNumber: this._generateRefNumber()
    });
  }

  _showConfirmationModal(appointmentData) {
    const modal = document.getElementById('confirmationModal');
    if (!modal) {
      console.error('Confirmation modal not found in DOM');
      // Fallback: submit directly
      this._submitAppointment(appointmentData);
      return;
    }

    // Populate modal with data
    const durationDisplay = modal.querySelector('#durationDisplay');
    const refNumber = modal.querySelector('#refNumber');
    
    if (durationDisplay) durationDisplay.textContent = `1hr / ${appointmentData.endTime}`;
    if (refNumber) refNumber.textContent = appointmentData.refNumber;

    // Show modal
    modal.style.display = 'flex';

    // Setup event listeners
    this._setupModalEvents(modal, appointmentData);
  }

  _setupModalEvents(modal, appointmentData) {
    // Remove existing listeners to prevent duplicates
    const confirmBtn = modal.querySelector('#confirmBookingBtn');
    const cancelBtn = modal.querySelector('#cancelBookingBtn');
    
    // Clone and replace to remove old listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = cancelBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

    // Add new listeners
    newConfirmBtn.addEventListener('click', () => {
      const termsChecked = modal.querySelector('#termsCheckbox')?.checked;
      
      if (!termsChecked) {
        alert('Please accept the Terms & Conditions');
        return;
      }

      const paymentMethod = modal.querySelector('input[name="payment"]:checked')?.value || 'cash';
      this._onConfirmBooking(appointmentData, paymentMethod, modal);
    });

    newCancelBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Close when clicking outside
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }

  _onConfirmBooking(appointmentData, paymentMethod, modal) {
    console.log('Final confirmation with payment:', paymentMethod);
    
    // Hide confirmation modal
    modal.style.display = 'none';
    
    // Show loading spinner
    this._showLoadingSpinner();
    
    // Submit the actual appointment after 4 seconds
    setTimeout(() => {
        this._submitAppointment(appointmentData, paymentMethod);
    }, 4000);
  }
  _showLoadingSpinner() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
        
        // Add fade-in animation
        setTimeout(() => {
            loadingOverlay.style.opacity = '1';
        }, 10);
    }
  }
  _hideLoadingSpinner() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.opacity = '0';
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
        }, 300);
    }
  }

  async _submitAppointment(appointmentData, paymentMethod = 'cash') {
    try {
        const formData = new FormData();
        formData.append('patient_name', appointmentData.patientName);
        formData.append('contact_number', appointmentData.contact);
        formData.append('gender', appointmentData.gender);
        formData.append('dental_service', appointmentData.service);
        formData.append('appointment_date', appointmentData.date);
        formData.append('appointment_time', appointmentData.time);
        formData.append('notes', appointmentData.notes);
        formData.append('payment_method', paymentMethod);
        
        const tokenEl = document.querySelector('input[name="_token"]');
        if (tokenEl) formData.append('_token', tokenEl.value);

        const response = await fetch('/patient/appointments', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        });

        if (response.ok) {
            const result = await response.json();
            // Show success with actual reference number from server
            this._showSuccessMessage({
                ...appointmentData,
                refNumber: result.refNumber || appointmentData.refNumber
            });
        } else {
            this._hideLoadingSpinner();
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const errorData = await response.json();
                alert('Error: ' + (errorData.message || 'Unknown error'));
            } else {
                alert('Appointment booked successfully! Please check your appointments list.');
                this._clearApptForm();
                window.location.href = '/patient/appointments';
            }
        }
    } catch (err) {
        this._hideLoadingSpinner();
        console.error('Fetch error:', err);
        alert('Network error. Please try again.');
    }
  }

  _showSuccessMessage(appointmentData) {
    // Hide loading spinner first
    this._hideLoadingSpinner();
    
    // Show beautiful success message
    this._showSuccessModal(appointmentData);
}

    _showSuccessModal(appointmentData) {
        // Remove existing success modal if any
        const existing = document.querySelector('.success-modal');
        if (existing) existing.remove();

        const successModal = document.createElement('div');
        successModal.className = 'success-modal';
        successModal.innerHTML = `
            <div class="success-card">
                <div class="success-icon">
                    <img src="/images/success-checkmark.svg.png" alt="Success" class="success-svg">
                </div>
                <h3>Appointment Booked Successfully!</h3>
                <div class="success-details">
                    <div class="detail-item">
                        <span class="label">Reference Number:</span>
                        <span class="value">${appointmentData.refNumber}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Service:</span>
                        <span class="value">${appointmentData.service}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Date & Time:</span>
                        <span class="value">${appointmentData.date} at ${appointmentData.time}</span>
                    </div>
                </div>
                <p class="success-note">Please save your reference number for future reference.</p>
                <button class="btn btn-primary" id="closeSuccessBtn">Continue</button>
            </div>
        `;
        
        document.body.appendChild(successModal);

        // Add styles
        this._addSuccessModalStyles();
        
        // Add event listener for closing
        successModal.querySelector('#closeSuccessBtn').addEventListener('click', () => {
            successModal.classList.add('fade-out');
            setTimeout(() => {
                successModal.remove();
                // Clear form and redirect
                this._clearApptForm();
                window.location.href = '/patient/appointments';
            }, 300);
        });
    }

  _addSuccessModalStyles() {
    if (document.getElementById('successModalStyles')) return;
    
    const styles = document.createElement('style');
    styles.id = 'successModalStyles';
    styles.textContent = `
        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        
        .success-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        
        .success-icon {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        
        .success-svg {
            width: 60px;
            height: 60px;
            display: block;
            margin: 0 auto;
        }
        
        .success-card h3 {
            color: #27ae60;
            margin-bottom: 20px;
            font-size: 22px;
            text-align: center;
        }
        
        .success-details {
            text-align: left;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
        }
        
        .label {
            font-weight: 500;
            color: #555;
        }
        
        .value {
            font-weight: 600;
            color: #333;
        }
        
        .success-note {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .btn-primary {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            display: block;
            margin: 0 auto;
        }
        
        .btn-primary:hover {
            background-color: #219653;
        }
        
        .fade-out {
            animation: fadeOut 0.3s ease forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    
    document.head.appendChild(styles);
}

  _calculateEndTime(startTime) {
    // Simple calculation - add 1 hour to start time
    const [hours, minutes] = startTime.split(':').map(Number);
    let endHours = hours + 1;
    const period = hours >= 12 ? 'PM' : 'AM';
    if (endHours > 12) endHours -= 12;
    return `${endHours}:${minutes.toString().padStart(2, '0')} ${period}`;
  }

  _generateRefNumber() {
    // Generate a simple reference number
    const timestamp = new Date().getTime().toString().slice(-6);
    return `APPT${timestamp}`;
  }

  _renderApptList() {
    const data = DataStore.load() || { appointments: [] };
    const listEl = this.container.querySelector('#apptList');
    if (!listEl) return;

    listEl.innerHTML = '';

    if (!data.appointments || data.appointments.length === 0) {
      listEl.innerHTML = '<li class="muted">No appointments yet.</li>';
      return;
    }

    data.appointments
      .slice()
      .sort((a, b) => new Date(a.datetime) - new Date(b.datetime))
      .forEach(a => {
        const li = document.createElement('li');
        const localName = a.patientName ? ` — ${a.patientName}` : '';
        li.textContent = `${fmtDate(a.datetime)} — ${a.title}${
          a.cancelled ? ' (Cancelled)' : ''
        }${localName}`;
        listEl.appendChild(li);
      });
  }
}

export { AppointmentsPage };