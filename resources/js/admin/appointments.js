// Appointments-only JS
(function(){
  const page = document.querySelector("#appointments");
  if(!page) return;

  // Get appointments data from HTML data attribute
  const appointmentsData = page.getAttribute('data-appointments');
  let appointments = appointmentsData ? JSON.parse(appointmentsData) : [];
  let selectedAppointment = null;

  const appointmentBody = page.querySelector("#appointmentBody");
  const detailsPanel = page.querySelector("#detailsPanel");
  const patientInfo = page.querySelector("#patientInfo");
  const appointmentInfo = page.querySelector("#appointmentInfo");

  const confirmBtn = page.querySelector("#confirmBtn");
  const cancelBtn = page.querySelector("#cancelBtn");
  const reminderBtn = page.querySelector("#reminderBtn");
  const editBtn = page.querySelector("#editBtn");

  const modal = page.querySelector("#editModal");
  const closeModalBtn = page.querySelector("#closeModal");
  const editForm = page.querySelector("#editForm");

  // Initially hide details panel
  detailsPanel.style.display = "none";

  // Render appointments table
  function renderTable(filter = ""){
    appointmentBody.innerHTML = "";
    
    // Filter appointments based on search input
    const filtered = appointments.filter(a => 
      a.patient_name.toLowerCase().includes(filter.toLowerCase()) ||
      a.dental_service.toLowerCase().includes(filter.toLowerCase()) ||
      (a.refNumber && a.refNumber.toLowerCase().includes(filter.toLowerCase()))
    );

    if(filtered.length === 0){
      appointmentBody.innerHTML = '<tr><td colspan="5" class="empty">No appointments found.</td></tr>';
      return;
    }

    filtered.forEach((a, i) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${a.patient_name}</td>
        <td>${a.dental_service}</td>
        <td>Dr. Aisly Miles</td>
        <td>Main Branch</td>
        <td><span class="status ${a.status ? a.status.toLowerCase() : 'pending'}">${a.status || 'Pending'}</span></td>
      `;
      tr.addEventListener("click", () => showDetails(a));
      appointmentBody.appendChild(tr);
    });
  }

  // Show details only when patient clicked
  function showDetails(appointment){
    selectedAppointment = appointment;
    
    // Update patient info with actual database fields
    patientInfo.innerHTML = `
      <p><strong>Name:</strong> ${appointment.patient_name}</p>
      <p><strong>Contact:</strong> ${appointment.contact_number || 'Not provided'}</p>
      <p><strong>Gender:</strong> ${appointment.gender || 'Not specified'}</p>
      ${appointment.patient && appointment.patient.email ? `<p><strong>Email:</strong> ${appointment.patient.email}</p>` : '<p><strong>Email:</strong> Not available</p>'}
    `;
    
    // Update appointment info with actual database fields
    appointmentInfo.innerHTML = `
      <p><strong>Reference #:</strong> ${appointment.refNumber || 'N/A'}</p>
      <p><strong>Service:</strong> ${appointment.dental_service}</p>
      <p><strong>Dentist:</strong> Dr. Aisly Miles</p>
      <p><strong>Date:</strong> ${appointment.appointment_date ? formatDate(appointment.appointment_date) : 'Not scheduled'}</p>
      <p><strong>Status:</strong> <span class="status ${appointment.status ? appointment.status.toLowerCase() : 'pending'}">${appointment.status || 'Pending'}</span></p>
      ${appointment.notes ? `<p><strong>Notes:</strong> ${appointment.notes}</p>` : ''}
    `;

    // Enable buttons
    confirmBtn.disabled = cancelBtn.disabled = reminderBtn.disabled = editBtn.disabled = false;

    // Update button states based on current status
    updateButtonStates(appointment.status);

    // Show the details panel
    detailsPanel.style.display = "block";
  }

  function updateButtonStates(status) {
    const currentStatus = status || 'Pending';
    // Disable confirm button if already confirmed/completed
    confirmBtn.disabled = (currentStatus === 'Confirmed' || currentStatus === 'Completed');
    // Disable cancel button if already cancelled/completed
    cancelBtn.disabled = (currentStatus === 'Cancelled' || currentStatus === 'Completed');
  }

  function formatDate(dateString) {
    try {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    } catch (e) {
      return 'Invalid date';
    }
  }

  // Search
  const searchInput = page.querySelector("#search");
  searchInput.addEventListener("input", () => renderTable(searchInput.value));

  // Button event handlers
  confirmBtn.addEventListener("click", () => updateStatus('Confirmed'));
  cancelBtn.addEventListener("click", () => updateStatus('Cancelled'));
  reminderBtn.addEventListener("click", sendReminder);
  editBtn.addEventListener("click", openEditModal);
  closeModalBtn.addEventListener("click", () => modal.style.display = "none");

  editForm.addEventListener("submit", function(e){
    e.preventDefault();
    saveAppointmentChanges();
  });

  function updateStatus(newStatus) {
    if (!selectedAppointment) return;

    fetch(`/appointments/${selectedAppointment.appointment_id}/status`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
      alert(data.success);
      // Update local data
      selectedAppointment.status = newStatus;
      updateButtonStates(newStatus);
      renderTable(searchInput.value);
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error updating status');
    });
  }

  function sendReminder() {
    if (!selectedAppointment) return;
    
    alert(`Reminder sent to ${selectedAppointment.patient_name} for appointment on ${selectedAppointment.appointment_date ? formatDate(selectedAppointment.appointment_date) : 'unscheduled date'}`);
  }

  function openEditModal() {
    if (!selectedAppointment) return;

    // Populate form with current data
    document.querySelector("#editName").value = selectedAppointment.patient_name || '';
    document.querySelector("#editContact").value = selectedAppointment.contact_number || '';
    
    // Get email from patient relationship if available
    const email = selectedAppointment.patient ? selectedAppointment.patient.email : '';
    document.querySelector("#editEmail").value = email;
    
    document.querySelector("#editGender").value = selectedAppointment.gender || 'Male';

    modal.style.display = "flex";
  }

  function saveAppointmentChanges() {
    if (!selectedAppointment) return;

    const formData = {
      patient_name: document.querySelector("#editName").value,
      contact_number: document.querySelector("#editContact").value,
      email: document.querySelector("#editEmail").value,
      gender: document.querySelector("#editGender").value
    };

    fetch(`/appointments/${selectedAppointment.appointment_id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
      alert(data.success);
      // Update local data
      Object.assign(selectedAppointment, formData);
      modal.style.display = "none";
      renderTable(searchInput.value);
      showDetails(selectedAppointment); // Refresh details
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error updating appointment');
    });
  }

  // Initial render
  renderTable();

})();