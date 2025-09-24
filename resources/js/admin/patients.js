// Sample patient data (empty by default)
  let patients = [];

  function renderPatients(filter = "") {
    const body = document.getElementById("patientBody");
    body.innerHTML = "";
    const filtered = patients.filter(p => 
      p.name.toLowerCase().includes(filter.toLowerCase())
    );

    if(filtered.length === 0){
      body.innerHTML = `<tr><td colspan="5" class="empty">No patients yet.</td></tr>`;
      return;
    }

    filtered.forEach(pt => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${pt.name}</td>
        <td>${pt.gender}</td>
        <td>${pt.age}</td>
        <td>${pt.contact}</td>
        <td>${pt.lastAppt}</td>
      `;
      body.appendChild(row);
    });
  }

  // Search functionality
  const searchInput = document.getElementById("search");
  searchInput.addEventListener("input", () => renderPatients(searchInput.value));

  // Initial render
  renderPatients();