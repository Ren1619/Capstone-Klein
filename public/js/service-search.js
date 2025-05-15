// Service Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('serviceSearch');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Get all table rows
            const rows = document.querySelectorAll('tbody tr');
            let visibleCount = 0;
            
            // Filter rows
            rows.forEach(row => {
                // Skip if single cell (no data) row
                if (row.cells.length <= 1) return;
                
                const serviceName = row.querySelector('td:first-child span').textContent.toLowerCase();
                const categoryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (serviceName.includes(searchTerm) || categoryName.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update results count
            const resultsCount = document.querySelector('.text-black.text-sm');
            if (resultsCount) {
                resultsCount.textContent = `Showing 1 to ${visibleCount} of ${visibleCount} results`;
            }
        });
    }
});