// Appointments-only JS
(function(){
  const page = document.querySelector("#appointments");
  if(!page) return;

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

  let appointments = [];

  // Initially hide details panel
  detailsPanel.style.display = "none";

  // Render appointments table
  function renderTable(filter=""){
    appointmentBody.innerHTML = "";
    const filtered = appointments.filter(a => 
      a.patient.toLowerCase().includes(filter.toLowerCase())
    );

    if(filtered.length === 0){
      appointmentBody.innerHTML = '<tr><td colspan="5" class="empty">No appointments yet.</td></tr>';
      return;
    }

    filtered.forEach((a, i)=>{
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${a.patient}</td>
        <td>${a.service}</td>
        <td>${a.dentist}</td>
        <td>${a.branch}</td>
        <td>${a.status}</td>
      `;
      tr.addEventListener("click", ()=> showDetails(a));
      appointmentBody.appendChild(tr);
    });
  }

  // Show details only when patient clicked
  function showDetails(a){
    patientInfo.innerHTML = `
      <p><strong>Name:</strong> ${a.patient}</p>
      <p><strong>Contact:</strong> ${a.contact}</p>
      <p><strong>Email:</strong> ${a.email}</p>
    `;
    appointmentInfo.innerHTML = `
      <p><strong>Service:</strong> ${a.service}</p>
      <p><strong>Dentist:</strong> ${a.dentist}</p>
      <p><strong>Branch:</strong> ${a.branch}</p>
      <p><strong>Status:</strong> ${a.status}</p>
    `;

    // Enable buttons
    confirmBtn.disabled = cancelBtn.disabled = reminderBtn.disabled = editBtn.disabled = false;

    // Show the details panel
    detailsPanel.style.display = "block";
  }

  // Search
  const searchInput = page.querySelector("#search");
  searchInput.addEventListener("input", ()=> renderTable(searchInput.value));

  // Buttons
  confirmBtn.addEventListener("click", ()=> alert("Appointment confirmed"));
  cancelBtn.addEventListener("click", ()=> alert("Appointment canceled"));
  reminderBtn.addEventListener("click", ()=> alert("Reminder sent"));
  editBtn.addEventListener("click", ()=> modal.style.display = "flex");
  closeModalBtn.addEventListener("click", ()=> modal.style.display = "none");

  editForm.addEventListener("submit", e=>{
    e.preventDefault();
    alert("Appointment saved (demo)");
    modal.style.display = "none";
  });

  // Demo data
  appointments = [
    {patient:"John Doe", service:"Cleaning", dentist:"Dr. Smith", branch:"Main", status:"Pending", contact:"09123456789", email:"john@example.com"},
    {patient:"Jane Doe", service:"Filling", dentist:"Dr. Adams", branch:"West", status:"Confirmed", contact:"09987654321", email:"jane@example.com"}
  ];

  renderTable();

})();
