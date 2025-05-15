// Clinic Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('clinicSearchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Get all table rows (desktop view)
            const desktopRows = document.querySelectorAll('.hidden.sm\\:block .grid.grid-cols-12.gap-2.text-black');
            
            // Get all mobile cards
            const mobileCards = document.querySelectorAll('.sm\\:hidden .bg-white.rounded-lg.p-4');
            
            // Filter desktop rows
            if (desktopRows.length > 0) {
                desktopRows.forEach(row => {
                    const branchName = row.querySelector('.col-span-3 span').textContent.toLowerCase();
                    const address = row.querySelector('.col-span-5').textContent.toLowerCase();
                    const contact = row.querySelector('.col-span-2').textContent.toLowerCase();
                    
                    if (branchName.includes(searchTerm) || address.includes(searchTerm) || contact.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            // Filter mobile cards
            if (mobileCards.length > 0) {
                mobileCards.forEach(card => {
                    const branchName = card.querySelector('.font-medium').textContent.toLowerCase();
                    const address = card.querySelectorAll('.grid.grid-cols-2 div')[1].textContent.toLowerCase();
                    const contact = card.querySelectorAll('.grid.grid-cols-2 div')[3].textContent.toLowerCase();
                    
                    if (branchName.includes(searchTerm) || address.includes(searchTerm) || contact.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
    }
});