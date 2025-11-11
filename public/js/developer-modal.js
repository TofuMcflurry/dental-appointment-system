function openDeveloperModal() {
    const modal = document.getElementById('developer-modal');
    const container = document.getElementById('modal-content-container');
    
    // Prevent multiple calls
    if (modal.style.display === 'block') {
        return;
    }
    
    if (!modal || !container) {
        return;
    }
    
    // Show loading state
    container.innerHTML = '<div style="padding: 40px; text-align: center;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #4299E1;"></i><p style="margin-top: 20px;">Loading developer profile...</p></div>';
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Load content via AJAX
    fetch('/developer-modal')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            container.innerHTML = html;
        })
        .catch(error => {
            container.innerHTML = '<div style="padding: 40px; text-align: center;"><h3>Developer Profile</h3><p>Unable to load profile content.</p></div>';
        });
    
    // Add event listener for closing when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeDeveloperModal();
        }
    });
    
    // Add event listener for Escape key
    document.addEventListener('keydown', function escapeHandler(event) {
        if (event.key === 'Escape') {
            closeDeveloperModal();
            document.removeEventListener('keydown', escapeHandler);
        }
    });
}

function closeDeveloperModal() {
    const modal = document.getElementById('developer-modal');
    
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}