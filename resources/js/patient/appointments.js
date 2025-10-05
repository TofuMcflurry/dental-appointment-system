import { Page, DataStore, fmtDate, isSameDay, escapeHtml } from './base.js';

class AppointmentsPage extends Page {
  render() {
    if (!this.container) {
      console.warn(`AppointmentsPage: container not found for id "${this.id}"`);
      return;
    }

    const data = DataStore.load() || { appointments: [] };

    this.container.innerHTML = `
      <h3 id="apptTitle">Book an Appointment</h3>
      <div class="appt-form">
        <!-- [form and layout unchanged] -->
        <!-- ... your full HTML structure here ... -->
      </div>
    `;

    this._wireControls();
    this._renderApptList();
    this._updateApptSummary();
  }

  _wireControls() {
    if (!this.container) return;

    const apptDate = this.container.querySelector('#apptDate');
    const apptTime = this.container.querySelector('#apptTime');
    const servicesList = this.container.querySelector('#servicesList');

    [apptDate, apptTime].forEach(el => el?.addEventListener('input', () => this._updateApptSummary()));
    servicesList?.addEventListener('change', () => this._updateApptSummary());

    this.container.querySelector('#cancelApptBtn')?.addEventListener('click', () => this._clearApptForm());
    this.container.querySelector('#bookApptBtn')?.addEventListener('click', () => this._bookAppt());
  }

  _updateApptSummary() {
    if (!this.container) return;

    const d = this.container.querySelector('#apptDate')?.value || "—";
    const t = this.container.querySelector('#apptTime')?.value || "—";
    const s = this.container.querySelector('input[name="service"]:checked')?.value || "—";

    this.container.querySelector('#summaryDate').textContent = `Date: ${d}`;
    this.container.querySelector('#summaryTime').textContent = `Time: ${t}`;
    this.container.querySelector('#summaryService').textContent = `Service: ${s}`;
  }

  _clearApptForm() {
    if (!this.container) return;

    const f = this.container;
    f.querySelector('#patientName').value = '';
    f.querySelector('#patientContact').value = '';
    f.querySelector('#apptDate').value = '';
    f.querySelector('#apptTime').value = '';
    f.querySelector('#gender').value = '';
    const sel = f.querySelector('input[name="service"]:checked');
    if (sel) sel.checked = false;
    f.querySelector('#notes').value = '';
    this._updateApptSummary();
  }

  _bookAppt() {
    if (!this.container) return;

    const f = this.container;
    const patientName = f.querySelector('#patientName').value.trim();
    const contact = f.querySelector('#patientContact').value.trim();
    const date = f.querySelector('#apptDate').value;
    const time = f.querySelector('#apptTime').value;
    const gender = f.querySelector('#gender').value;
    const service = f.querySelector('input[name="service"]:checked')?.value;
    const notes = f.querySelector('#notes').value.trim();

    if (!patientName) { alert('Please enter patient name.'); return; }
    if (!contact) { alert('Please enter contact number.'); return; }
    if (!date || !time) { alert('Please select date and time.'); return; }
    if (!service) { alert('Please select a dental service.'); return; }

    const datetimeISO = new Date(`${date}T${time}`).toISOString();
    const data = DataStore.load() || { appointments: [], notifications: [], bracesColor: 'BLACK' };
    const appt = {
      id: Date.now(),
      title: service,
      datetime: datetimeISO,
      confirmed: false,
      cancelled: false,
      attended: false,
      patientName,
      contact,
      gender,
      notes
    };

    data.appointments.push(appt);
    DataStore.save(data);

    if (!localStorage.getItem('patientName')) {
      localStorage.setItem('patientName', patientName);
    }

    alert('✅ Appointment booked (saved to local demo data).');
    this._clearApptForm();
    this._renderApptList();
    this.app.pages.dashboard?.render();
  }

  _renderApptList() {
    if (!this.container) return;

    const data = DataStore.load() || { appointments: [] };
    const listEl = this.container.querySelector('#apptList');
    if (!listEl) return;

    listEl.innerHTML = '';
    if (!data.appointments.length) {
      listEl.innerHTML = '<li class="muted">No appointments yet.</li>';
      return;
    }

    data.appointments
      .slice()
      .sort((a, b) => new Date(a.datetime) - new Date(b.datetime))
      .forEach(a => {
        const li = document.createElement('li');
        const localName = a.patientName ? ` — ${a.patientName}` : '';
        li.textContent = `${fmtDate(a.datetime)} — ${a.title}${a.cancelled ? ' (Cancelled)' : ''}${localName}`;
        listEl.appendChild(li);
      });
  }
}

export { AppointmentsPage };
