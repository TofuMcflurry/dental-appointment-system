// Only run this code if we're on the audit trail page
if (document.querySelector('.audit-filters')) {
    // Add real-time search if needed
    const searchInput = document.querySelector('input[name="search"]');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Submit form after user stops typing for 500ms
                e.target.form.submit();
            }, 500);
        });
    }

    // Date range validation
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');

    if (startDate && endDate) {
        startDate.addEventListener('change', function() {
            if (this.value && endDate.value && this.value > endDate.value) {
                endDate.value = this.value;
            }
        });

        endDate.addEventListener('change', function() {
            if (this.value && startDate.value && this.value < startDate.value) {
                startDate.value = this.value;
            }
        });
    }
}