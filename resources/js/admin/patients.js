// Patients-only JS
(function() {
    // Check if we're on the patients page
    const patientsPage = document.getElementById('patients');
    if (!patientsPage) {
        console.log('Not on patients page - skipping patients.js');
        return;
    }

    console.log('Patients page loaded - initializing patients.js');

    // Sample patient data (empty by default)
    let patients = [];

    function renderPatients(filter = "") {
        const body = document.getElementById("patientBody");
        
        // Safety check
        if (!body) {
            console.error('patientBody element not found');
            return;
        }
        
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
    if (searchInput) {
        searchInput.addEventListener("input", () => renderPatients(searchInput.value));
    } else {
        console.warn('Search input not found');
    }

    // Demo data - add some sample patients for testing
    patients = [
        { name: "Juan Dela Cruz", gender: "Male", age: 45, contact: "09123456789", lastAppt: "2024-01-15" },
        { name: "Maria Santos", gender: "Female", age: 32, contact: "09987654321", lastAppt: "2024-01-14" },
        { name: "Miguel Reyes", gender: "Male", age: 28, contact: "09112233445", lastAppt: "2024-01-10" },
        { name: "Sofia Garcia", gender: "Female", age: 61, contact: "09335577991", lastAppt: "2024-01-08" }
    ];

    // Initial render
    renderPatients();

})();