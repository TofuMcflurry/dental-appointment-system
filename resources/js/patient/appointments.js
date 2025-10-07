import { Page, DataStore, fmtDate, isSameDay, escapeHtml } from './base.js';

class AppointmentsPage extends Page {
  render() {
    const data = DataStore.load() || {appointments:[]};

    this.container.innerHTML = `
      <h3 id="apptTitle">Book an Appointment</h3>
      <div class="appt-form">
        <div>
          <div class="form-group">
            <label for="patientName">Patient Name</label>
            <input type="text" id="patientName" placeholder="Full name">
          </div>
          <div class="form-group">
            <label for="patientContact">Contact Number</label>
            <input type="tel" id="patientContact" placeholder="09xx...">
          </div>
          <div style="display:flex;gap:12px">
            <div class="form-group" style="flex:1">
              <label for="apptDate">Date</label>
              <input type="date" id="apptDate">
            </div>
            <div class="form-group" style="width:160px">
              <label for="apptTime">Time</label>
              <input type="time" id="apptTime">
            </div>
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender">
              <option value="">-- Select --</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="appt-summary" id="apptSummary">
            <strong>Selected:</strong>
            <div id="summaryDate">Date: —</div>
            <div id="summaryTime">Time: —</div>
            <div id="summaryService">Service: —</div>
          </div>

          <div class="form-actions">
            <button id="bookApptBtn" class="btn save">Book</button>
            <button id="cancelApptBtn" class="btn cancel">Cancel</button>
          </div>

          <hr style="margin:18px 0">

          <h4 style="margin:0 0 8px 0">Your Appointments</h4>
          <ul id="apptList" class="muted" style="padding-left:18px"></ul>
        </div>

        <div>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <h4 style="margin:0">Dental Services</h4>
            <div class="muted" style="font-size:12px">Click one to choose</div>
          </div>

          <div class="services-list" id="servicesList">
            ${[
              "Check-up & Consultation","Teeth Cleaning","Dental Fillings","Tooth Extraction","Wisdom Tooth Removal",
              "Root Canal Therapy","Dental Crowns","Dental Bridges","Dentures","Braces / Orthodontics",
              "Dental Implants","Teeth Whitening","Gum Treatment / Periodontics","Fluoride Treatment","Oral Surgery",
              "Emergency / Pain Relief"
            ].map(s => `<label><input type="radio" name="service" value="${escapeHtml(s)}"> ${escapeHtml(s)}</label>`).join('')}
          </div>

          <div style="margin-top:12px">
            <label for="notes" style="font-weight:500;color:var(--accent);display:block;margin-bottom:6px">Appointment Schedule Details — Notes</label>
            <textarea id="notes" rows="8" placeholder="Write any notes, concerns, or medical history here..." style="width:100%;"></textarea>
          </div>
        </div>
      </div>
    `;

    // wire up controls
    this._wireControls();
    this._renderApptList();
    this._updateApptSummary();
  }

  _wireControls() {
    const apptDate = this.container.querySelector('#apptDate');
    const apptTime = this.container.querySelector('#apptTime');
    const servicesList = this.container.querySelector('#servicesList');
    const nameInput = this.container.querySelector('#patientName');
    const contactInput = this.container.querySelector('#patientContact');
    const genderSelect = this.container.querySelector('#gender');

    [apptDate, apptTime, nameInput, contactInput, genderSelect].forEach(el => {
      if (el) el.addEventListener('input', () => this._updateApptSummary());
    });
    if (servicesList)
      servicesList.addEventListener('change', () => this._updateApptSummary());

    const cancelBtn = this.container.querySelector('#cancelApptBtn');
    if (cancelBtn) cancelBtn.addEventListener('click', () => this._clearApptForm());

    const bookBtn = this.container.querySelector('#bookApptBtn');
    if (bookBtn) bookBtn.addEventListener('click', () => this._bookAppt());
  }

  _updateApptSummary() {
    const d = this.container.querySelector('#apptDate').value || "—";
    const t = this.container.querySelector('#apptTime').value || "—";
    const s = (this.container.querySelector('input[name="service"]:checked') || {value:'—'}).value;
    this.container.querySelector('#summaryDate').textContent = `Date: ${d}`;
    this.container.querySelector('#summaryTime').textContent = `Time: ${t}`;
    this.container.querySelector('#summaryService').textContent = `Service: ${s}`;
  }

  _clearApptForm() {
    const f = this.container;
    f.querySelector('#patientName').value='';
    f.querySelector('#patientContact').value='';
    f.querySelector('#apptDate').value='';
    f.querySelector('#apptTime').value='';
    f.querySelector('#gender').value='';
    const sel = f.querySelector('input[name="service"]:checked');
    if(sel) sel.checked = false;
    f.querySelector('#notes').value='';
    this._updateApptSummary();
  }

  _bookAppt() {
    const f = this.container;
    const patientName = f.querySelector('#patientName').value.trim();
    const contact = f.querySelector('#patientContact').value.trim();
    const date = f.querySelector('#apptDate').value;
    const time = f.querySelector('#apptTime').value;
    const gender = f.querySelector('#gender').value;
    const service = (f.querySelector('input[name="service"]:checked') || {}).value;
    const notes = f.querySelector('#notes').value.trim();

    if(!patientName){ alert('Please enter patient name.'); return; }
    if(!contact){ alert('Please enter contact number.'); return; }
    if(!date || !time){ alert('Please select date and time.'); return; }
    if(!service){ alert('Please select a dental service.'); return; }

    const datetimeISO = new Date(date + 'T' + time).toISOString();
    const data = DataStore.load() || {appointments:[],notifications:[],bracesColor:'BLACK'};
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
    data.appointments = data.appointments || [];
    data.appointments.push(appt);
    DataStore.save(data);

    // set patientName if not logged-in
    if(!localStorage.getItem('patientName')){
      localStorage.setItem('patientName', patientName);
    }
    alert('✅ Appointment booked (saved to local demo data).');

    this._clearApptForm();
    this._renderApptList();
    // update dashboard too
    this.app.pages.dashboard.render();
  }

  _renderApptList() {
    const data = DataStore.load() || {appointments:[]};
    const listEl = this.container.querySelector('#apptList');
    listEl.innerHTML = '';
    if(!data.appointments || data.appointments.length===0){
      listEl.innerHTML = '<li class="muted">No appointments yet.</li>';
      return;
    }
    data.appointments.slice().sort((a,b)=> new Date(a.datetime)-new Date(b.datetime)).forEach(a=>{
      const li = document.createElement('li');
      const localName = a.patientName ? ` — ${a.patientName}` : '';
      li.textContent = `${fmtDate(a.datetime)} — ${a.title}${a.cancelled ? ' (Cancelled)' : ''}${localName}`;
      listEl.appendChild(li);
    });
  }
}

export { AppointmentsPage };
