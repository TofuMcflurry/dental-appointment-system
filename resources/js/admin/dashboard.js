document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on dashboard page
    const dashboard = document.querySelector(".dashboard-page");
    if(!dashboard) return;

    // Calendar functionality
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    // Calendar elements
    const calendarMonth = document.getElementById('calendarMonth');
    const calendarDays = document.getElementById('calendarDays');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    
    // Modal elements
    const modal = document.getElementById('appointmentModal');
    const modalDate = document.getElementById('modalDate');
    const appointmentList = document.getElementById('appointmentList');
    const closeBtn = document.querySelector('.close');
    
    // Load calendar on page load
    loadCalendar(currentMonth + 1, currentYear);
    
    // Event listeners for month navigation
    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            loadCalendar(currentMonth + 1, currentYear);
        });
    }
    
    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            loadCalendar(currentMonth + 1, currentYear);
        });
    }
    
    // Close modal
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    if (modal) {
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    // Function to load calendar
    async function loadCalendar(month, year) {
        try {
            const response = await fetch(`/admin/calendar/appointments?month=${month}&year=${year}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            // Update month display
            if (calendarMonth) {
                calendarMonth.textContent = data.month;
            }
            
            // Clear previous days
            if (calendarDays) {
                calendarDays.innerHTML = '';
            }
            
            // Create blank days for days before the first of the month
            const firstDay = data.first_day_of_month || 0;
            for (let i = 0; i < firstDay; i++) {
                const blankDay = document.createElement('div');
                blankDay.className = 'day blank';
                if (calendarDays) {
                    calendarDays.appendChild(blankDay);
                }
            }
            
            // Create days for the month
            for (let day = 1; day <= data.days_in_month; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'day';
                dayElement.textContent = day;
                
                // Format date string
                const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                dayElement.dataset.date = dateStr;
                
                // Check if this date has appointments
                if (data.appointments && data.appointments[dateStr]) {
                    const appointments = data.appointments[dateStr];
                    dayElement.classList.add('has-appointment');
                    
                    // Add appointment count badge
                    const badge = document.createElement('span');
                    badge.className = 'appointment-badge';
                    badge.textContent = appointments.length;
                    dayElement.appendChild(badge);
                    
                    // Add status indicators
                    const hasConfirmed = appointments.some(app => app.status === 'Confirmed');
                    const hasPending = appointments.some(app => app.status === 'Pending');
                    const hasCompleted = appointments.some(app => app.status === 'Completed');
                    const hasCancelled = appointments.some(app => app.status === 'Cancelled');
                    
                    if (hasConfirmed) dayElement.classList.add('has-confirmed');
                    if (hasPending) dayElement.classList.add('has-pending');
                    if (hasCompleted) dayElement.classList.add('has-completed');
                    if (hasCancelled) dayElement.classList.add('has-cancelled');
                }
                
                // Add click event
                dayElement.addEventListener('click', () => {
                    showAppointments(dateStr);
                });
                
                if (calendarDays) {
                    calendarDays.appendChild(dayElement);
                }
            }
        } catch (error) {
            console.error('Error loading calendar:', error);
            if (calendarMonth) {
                calendarMonth.textContent = 'Error loading calendar';
            }
            if (calendarDays) {
                calendarDays.innerHTML = '<div style="grid-column: span 7; text-align: center; padding: 20px; color: #f44336;">Error loading calendar data</div>';
            }
        }
    }
    
    // Function to show appointments for a specific date
    async function showAppointments(dateStr) {
        try {
            const response = await fetch(`/admin/calendar/appointments-by-date?date=${dateStr}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            // Update modal date
            if (modalDate) {
                modalDate.textContent = data.formatted_date || dateStr;
            }
            
            // Clear appointment list
            if (appointmentList) {
                appointmentList.innerHTML = '';
                
                if (!data.appointments || data.appointments.length === 0) {
                    appointmentList.innerHTML = '<div class="empty-appointments">No appointments for this date.</div>';
                } else {
                    // Create appointment cards
                    data.appointments.forEach(appointment => {
                        const appointmentCard = document.createElement('div');
                        appointmentCard.className = `appointment-card status-${appointment.status.toLowerCase()}`;
                        
                        const time = new Date(appointment.appointment_date).toLocaleTimeString([], { 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        });
                        
                        appointmentCard.innerHTML = `
                            <div class="appointment-header">
                                <span class="appointment-time">${time}</span>
                                <span class="appointment-status">${appointment.status}</span>
                            </div>
                            <div class="appointment-patient">${appointment.patient_name}</div>
                            <div class="appointment-service">${appointment.dental_service}</div>
                            <div class="appointment-actions">
                                <button class="btn-view" onclick="viewAppointment(${appointment.appointment_id})">View Details</button>
                            </div>
                        `;
                        
                        appointmentList.appendChild(appointmentCard);
                    });
                }
            }
            
            // Show modal
            if (modal) {
                modal.style.display = 'block';
            }
        } catch (error) {
            console.error('Error loading appointments:', error);
            if (appointmentList) {
                appointmentList.innerHTML = '<div class="empty-appointments error">Error loading appointments.</div>';
            }
        }
    }
    
    // Make function globally available for button onclick
    window.viewAppointment = function(appointmentId) {
        window.location.href = `/admin/appointments#appointment-${appointmentId}`;
    };

    // Dashboard stats functionality (keep if needed)
    let appointmentsToday=[], upcomingAppointments=[], cancelledAppointments=[], remindersSent=[];
    
    function renderCounts(){
        setCount("todayCount", appointmentsToday.length);
        setCount("upcomingCount", upcomingAppointments.length);
        setCount("cancelledCount", cancelledAppointments.length);
        setCount("reminderCount", remindersSent.length);
    }

    function setCount(id, val){
        const el = document.querySelector(`#${id}`);
        if(!el) return;
        if(val>0){ 
            el.textContent=val; 
            el.classList.remove("hidden"); 
        }
        else { 
            el.textContent="0"; 
            el.classList.add("hidden"); 
        }
    }

    // Initial render of counts
    renderCounts();

    // Load initial stats if needed
    // You can add API calls here to load actual data
    // loadDashboardStats();
});