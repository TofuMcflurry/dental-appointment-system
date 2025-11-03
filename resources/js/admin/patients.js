// Patients-only JS
(function() {
    const patientsPage = document.getElementById('patients');
    if (!patientsPage) return;

    // Get patients data from HTML data attribute
    const patientsData = patientsPage.getAttribute('data-patients');
    let patients = patientsData ? JSON.parse(patientsData) : [];

    // Panel elements
    const detailsPanel = document.getElementById('detailsPanel');
    const panelOverlay = document.getElementById('panelOverlay');
    const closePanelBtn = document.getElementById('closePanel');
    const closePanelBtn2 = document.getElementById('closePanelBtn');
    const editPatientBtn = document.getElementById('editPanelPatientBtn');

    // Panel event listeners
    if (closePanelBtn) {
        closePanelBtn.addEventListener('click', closePanel);
    }
    if (closePanelBtn2) {
        closePanelBtn2.addEventListener('click', closePanel);
    }
    if (editPatientBtn) {
        editPatientBtn.addEventListener('click', editPatient);
    }
    
    // Close panel when clicking overlay
    if (panelOverlay) {
        panelOverlay.addEventListener('click', closePanel);
    }

    // Close panel with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePanel();
        }
    });

    function closePanel() {
        if (detailsPanel) {
            detailsPanel.classList.remove('active');
        }
        if (panelOverlay) {
            panelOverlay.classList.remove('active');
        }
        // Re-enable body scroll
        document.body.style.overflow = 'auto';
    }

    function editPatient() {
        const patientId = editPatientBtn.getAttribute('data-patient-id');
        if (patientId) {
            alert(`Edit patient with ID: ${patientId}`);
            // Implement edit functionality here
        }
    }

    // Calculate age from birthdate
    function calculateAge(birthdate) {
        if (!birthdate) return 'N/A';
        
        try {
            const birthDate = new Date(birthdate);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
        } catch (error) {
            console.error('Error calculating age:', error);
            return 'N/A';
        }
    }

    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } catch (error) {
            console.error('Error formatting date:', error);
            return 'N/A';
        }
    }

    function renderPatients(filter = "") {
        const body = document.getElementById("patientBody");
        if (!body) return;

        if (patients.length === 0) {
            body.innerHTML = `<tr><td colspan="7" class="empty">No patients found in database.</td></tr>`;
            return;
        }
        
        body.innerHTML = "";
        
        const filtered = patients.filter(patient => 
            patient.full_name.toLowerCase().includes(filter.toLowerCase()) ||
            (patient.email && patient.email.toLowerCase().includes(filter.toLowerCase())) ||
            (patient.contact_number && patient.contact_number.toLowerCase().includes(filter.toLowerCase())) ||
            (patient.gender && patient.gender.toLowerCase().includes(filter.toLowerCase()))
        );

        if (filtered.length === 0) {
            body.innerHTML = `<tr><td colspan="7" class="empty">No patients match your search.</td></tr>`;
            return;
        }

        filtered.forEach(patient => {
            const age = calculateAge(patient.birthdate);
            
            // FIXED: Use bracesSchedule consistently
            const hasBraces = patient.braces_schedule && patient.braces_schedule.is_active;
            const nextAdjustment = hasBraces ? 
                formatDate(patient.braces_schedule.next_adjustment_date) : 
                '<span class="no-braces">No braces</span>';
            
            const row = document.createElement("tr");
            row.setAttribute('data-patient-id', patient.patient_id);
            row.innerHTML = `
                <td>${patient.full_name || 'N/A'}</td>
                <td>${patient.gender || 'N/A'}</td>
                <td>${age}</td>
                <td>${patient.contact_number || 'N/A'}</td>
                <td>${patient.email || 'N/A'}</td>
                <td>${nextAdjustment}</td>
                <td>
                    <button class="btn-view" onclick="viewPatient(${patient.patient_id})">View</button>
                </td>
            `;
            body.appendChild(row);
        });
    }

    // Search functionality
    const searchInput = document.getElementById("search");
    if (searchInput) {
        searchInput.addEventListener("input", () => renderPatients(searchInput.value));
    }

    // View patient function - UPDATED FOR PANEL WITH OVERLAY
    window.viewPatient = function(patientId) {
        const patient = patients.find(p => p.patient_id === patientId);
        if (!patient) {
            alert('Patient not found!');
            return;
        }

        // Update panel with patient data
        document.getElementById('panelPatientName').textContent = patient.full_name || 'N/A';
        document.getElementById('panelPatientGender').textContent = patient.gender || 'N/A';
        document.getElementById('panelPatientAge').textContent = calculateAge(patient.birthdate);
        document.getElementById('panelPatientBirthdate').textContent = formatDate(patient.birthdate);
        document.getElementById('panelPatientContact').textContent = patient.contact_number || 'N/A';
        document.getElementById('panelPatientEmail').textContent = patient.email || 'N/A';
        document.getElementById('panelPatientAddress').textContent = patient.address || 'N/A';

        // Handle braces information - FIXED: Use bracesSchedule consistently
        const bracesInfo = document.getElementById('panelBracesInfo');
        const noBracesMessage = document.getElementById('panelNoBracesMessage');
        const hasBraces = patient.braces_schedule && patient.braces_schedule.is_active;

        if (hasBraces) {
            bracesInfo.style.display = 'grid';
            noBracesMessage.style.display = 'none';
            
            document.getElementById('panelLastAdjustment').textContent = 
                formatDate(patient.braces_schedule.last_adjustment_date);  
            document.getElementById('panelNextAdjustment').textContent = 
                formatDate(patient.braces_schedule.next_adjustment_date);  
            document.getElementById('panelAdjustmentInterval').textContent = 
                patient.braces_schedule.adjustment_interval ?             
                `${patient.braces_schedule.adjustment_interval} days` : 'N/A';
            
            const statusElement = document.getElementById('panelBracesStatus');
            statusElement.textContent = 'Active';
            statusElement.className = 'braces-active';
        } else {
            bracesInfo.style.display = 'none';
            noBracesMessage.style.display = 'block';
        }

        // Set patient ID for edit button
        editPatientBtn.setAttribute('data-patient-id', patient.patient_id);

        // Show the floating panel and overlay
        if (detailsPanel) {
            detailsPanel.classList.add('active');
        }
        if (panelOverlay) {
            panelOverlay.classList.add('active');
        }
        
        // Prevent body scroll when panel is open
        document.body.style.overflow = 'hidden';
    };

    // Initial render
    renderPatients();

})();