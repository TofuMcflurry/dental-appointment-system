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
  const contact = this.container.querySelector('#patientContact')?.value || ''; // FIX: Added this line
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

  const formData = new FormData();
  formData.append('patient_name', patientName);
  formData.append('contact_number', contact); // Now 'contact' is defined
  formData.append('gender', gender);
  formData.append('dental_service', service);
  formData.append('appointment_date', date);
  formData.append('appointment_time', time);
  formData.append('notes', notes);
  const tokenEl = document.querySelector('input[name="_token"]');
  if (tokenEl) formData.append('_token', tokenEl.value);

  try {
    const response = await fetch('/patient/appointments', {
      method: 'POST',
      body: formData,
      headers: {
        'Accept': 'application/json',
      },
    });

    if (response.ok) {
      window.location.href = '/patient/appointments';
    } else {
      const contentType = response.headers.get('content-type');
      if (contentType && contentType.includes('application/json')) {
        const errorData = await response.json();
        alert('Error: ' + (errorData.message || 'Unknown error'));
      } else {
        const errorText = await response.text();
        console.error('Server returned HTML:', errorText);
        alert('Server error. Check console for details.');
      }
    }
  } catch (err) {
    console.error('Fetch error:', err);
    alert('Network error. Please try again.');
  }
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

  _showConfirmationModal(name, service, date, time) {
    // Remove existing modal if any
    const existing = document.querySelector('.confirm-modal');
    if (existing) existing.remove();

    const modal = document.createElement('div');
    modal.className = 'confirm-modal';
    modal.innerHTML = `
      <div class="confirm-card">
        <h3>Appointment Confirmed</h3>
        <p><strong>${name}</strong>, your appointment for <strong>${service}</strong> has been successfully booked.</p>
        <p><small>${date} at ${time}</small></p>
        <button class="close-confirm">OK</button>
      </div>
    `;
    document.body.appendChild(modal);

    // Add event listener for closing
    modal.querySelector('.close-confirm').addEventListener('click', () => {
      modal.classList.add('hide');
      setTimeout(() => modal.remove(), 300);
    });
  }
}

export { AppointmentsPage };