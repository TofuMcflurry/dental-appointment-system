document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dashboardPage');

    // Load data from DataStore (localStorage)
    const data = DataStore.load() || {appointments: [], notifications: [], bracesColor: 'BLACK'};

    renderDashboard(data);

    function renderDashboard(data) {
        renderOverview(data);
        renderAppointmentsList(data);
        renderBracesGrid(data);
        renderNotifications(data);
        attachHandlers(data);
    }

    function renderOverview(data) {
        const next = (data.appointments || [])
            .filter(a => !a.cancelled && new Date(a.datetime) > new Date())
            .sort((a,b) => new Date(a.datetime) - new Date(b.datetime))[0];
        const remindersToday = (data.notifications || [])
            .filter(n => n.type==='reminder' && isSameDay(n.datetime, new Date().toISOString())).length;

        document.getElementById('nextAppointment').textContent = next ? `${escapeHtml(next.title)} — ${escapeHtml(fmtDate(next.datetime))}` : 'No upcoming appointment';
        document.getElementById('statusConfirmed').textContent = next ? (next.confirmed ? 'Confirmed' : 'Pending confirmation') : '—';
        document.getElementById('remindersToday').textContent = remindersToday;
    }

    function renderAppointmentsList(data) {
        const apptsContainer = document.getElementById('apptsContainer');
        apptsContainer.innerHTML = '';
        if(!data.appointments || data.appointments.length===0){
            apptsContainer.innerHTML = '<div class="muted">No appointments</div>';
            return;
        }
        const sorted = data.appointments.slice().sort((a,b)=> new Date(a.datetime)-new Date(b.datetime));
        const now = new Date();
        sorted.forEach(a=>{
            let statusClass='status-upcoming', statusText='Upcoming';
            if(a.cancelled) { statusClass='status-cancelled'; statusText='Cancelled'; }
            else if(new Date(a.datetime) < now && !a.attended) { statusClass='status-missed'; statusText='Missed'; }
            else if(new Date(a.datetime) > now) { statusClass='status-upcoming'; statusText='Upcoming'; }
            if(a.confirmed && !a.cancelled) statusText = 'Upcoming (Confirmed)';

            const apptDiv = document.createElement('div');
            apptDiv.className='appt';
            apptDiv.innerHTML = `<div class="meta"><strong>${escapeHtml(a.title)}</strong><span class="time">${fmtDate(a.datetime)}</span></div>
                                 <div><span class="status-pill ${statusClass}">${escapeHtml(statusText)}</span></div>`;
            apptsContainer.appendChild(apptDiv);
        });
    }

    function renderBracesGrid(data) {
        const bracesGrid = document.getElementById('bracesGrid');
        const colors = ['BLACK','GRAY','ORANGE','RED','VIOLET','INDIGO','BLUE','CYAN','TEAL','GREEN','YELLOW','PINK','WHITE','MAROON','BROWN'];
        bracesGrid.innerHTML = '';
        colors.forEach(c=>{
            const box = document.createElement('div');
            box.className='color-box';
            box.style.background = c.toLowerCase() === 'white' ? '#ffffff' : c;
            if(c.toLowerCase() === (data.bracesColor||'').toLowerCase()) box.classList.add('selected');
            box.title = c;
            box.addEventListener('click', ()=> {
                data.bracesColor = c;
                DataStore.save(data);
                renderDashboard(data); // re-render dashboard
            });
            bracesGrid.appendChild(box);
        });
        document.getElementById('selectedColorText').textContent = data.bracesColor || '—';
    }

    function renderNotifications(data) {
        // Your shared notification renderer here
        if(window.app && app.pages && app.pages.notifications) {
            app.pages.notifications.render();
        }
    }

    function attachHandlers(data) {
        document.getElementById('simulateReminder').addEventListener('click', ()=> window.app?.simulateReminder());
        document.getElementById('clearRead').addEventListener('click', ()=> window.app?.clearReadNotifications());
    }
});
