document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('appointmentsPage');

    // Load data
    const data = DataStore.load() || {appointments: [], notifications: [], bracesColor:'BLACK'};

    wireControls();
    renderApptList();
    updateApptSummary();

    function wireControls() {
        const apptDate = container.querySelector('#apptDate');
        const apptTime = container.querySelector('#apptTime');
        const servicesList = container.querySelector('#servicesList');

        [apptDate, apptTime].forEach(el => el && el.addEventListener('input', updateApptSummary));
        servicesList && servicesList.addEventListener('change', updateApptSummary);

        const cancelBtn = container.querySelector('#cancelApptBtn');
        cancelBtn && cancelBtn.addEventListener('click', clearApptForm);

        const bookBtn = container.querySelector('#bookApptBtn');
        bookBtn && bookBtn.addEventListener('click', bookAppt);
    }

    function updateApptSummary() {
        const d = container.querySelector('#apptDate').value || "—";
        const t = container.querySelector('#apptTime').value || "—";
        const s = (container.querySelector('input[name="service"]:checked') || {value:'—'}).value;

        container.querySelector('#summaryDate').textContent = `Date: ${d}`;
        container.querySelector('#summaryTime').textContent = `Time: ${t}`;
        container.querySelector('#summaryService').textContent = `Service: ${s}`;
    }

    function clearApptForm() {
        container.querySelector('#patientName').value='';
        container.querySelector('#patientContact').value='';
        container.querySelector('#apptDate').value='';
        container.querySelector('#apptTime').value='';
        container.querySelector('#gender').value='';
        const sel = container.querySelector('input[name="service"]:checked');
        if(sel) sel.checked = false;
        container.querySelector('#notes').value='';
        updateApptSummary();
    }

    function bookAppt() {
        const patientName = container.querySelector('#patientName').value.trim();
        const contact = container.querySelector('#patientContact').value.trim();
        const date = container.querySelector('#apptDate').value;
        const time = container.querySelector('#apptTime').value;
        const gender = container.querySelector('#gender').value;
        const service = (container.querySelector('input[name="service"]:checked') || {}).value;
        const notes = container.querySelector('#notes').value.trim();

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

        if(!localStorage.getItem('patientName')){
            localStorage.setItem('patientName', patientName);
        }

        alert('✅ Appointment booked (saved to local demo data).');

        clearApptForm();
        renderApptList();

        // Update dashboard if available
        window.app?.pages?.dashboard?.render?.();
    }

    function renderApptList() {
        const data = DataStore.load() || {appointments:[]};
        const listEl = container.querySelector('#apptList');
        listEl.innerHTML = '';
        if(!data.appointments || data.appointments.length===0){
            listEl.innerHTML = '<li class="muted">No appointments yet.</li>';
            return;
        }
        data.appointments.slice().sort((a,b)=> new Date(a.datetime)-new Date(b.datetime)).forEach(a=>{
            const li = document.createElement('li');
            const localName = a.patientName ?  ` — ${a.patientName}` : '';
            li.textContent = `${fmtDate(a.datetime)} — ${a.title}${a.cancelled ? ' (Cancelled)' : ''}${localName}`;
            listEl.appendChild(li);
        });
    }
});
