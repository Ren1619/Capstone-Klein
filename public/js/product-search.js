// Product Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearchInput');
    
    if (searchInput) {
        // Add a form to handle the search with page reload
        const searchForm = document.createElement('form');
        searchForm.action = window.location.pathname; // Current URL without query params
        searchForm.method = 'GET';
        searchForm.style.display = 'flex';
        searchForm.style.width = '100%';
        
        // Replace the input with our form
        const parentElement = searchInput.parentElement;
        parentElement.appendChild(searchForm);
        
        // Move the search input inside the form
        searchInput.name = 'search'; // Add name attribute for form submission
        searchForm.appendChild(searchInput);
        
        // Set initial search value from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('search');
        if (searchParam) {
            searchInput.value = searchParam;
            
            // Create clear search button
            createClearSearchButton(parentElement);
        }
        
        // Handle search submission (when user presses Enter)
        searchForm.addEventListener('submit', function(e) {
            const searchTerm = searchInput.value.trim();
            
            if (searchTerm === '') {
                e.preventDefault();
                
                // If search is empty and we had a previous search, redirect to base URL
                if (searchParam) {
                    window.location.href = window.location.pathname;
                }
            }
        });
        
        // Client-side filtering for small datasets or quick filtering
        searchInput.addEventListener('input', function(e) {
            const searchTerm = this.value.trim().toLowerCase();
            
            // Show/hide clear button based on search term
            if (searchTerm !== '') {
                if (!document.getElementById('clearSearchBtn')) {
                    createClearSearchButton(parentElement);
                }
            } else {
                const clearBtn = document.getElementById('clearSearchBtn');
                if (clearBtn) {
                    clearBtn.remove();
                }
            }
            
            // Only do client-side filtering if no server-side filtering is active
            if (!searchParam) {
                clientSideFiltering(searchTerm);
            }
        });
    }
    
    function createClearSearchButton(parentElement) {
        // Only create if it doesn't exist
        if (document.getElementById('clearSearchBtn')) return;
        
        const clearBtn = document.createElement('button');
        clearBtn.id = 'clearSearchBtn';
        clearBtn.type = 'button';
        clearBtn.className = 'ml-2';
        clearBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
        clearBtn.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
        
        parentElement.appendChild(clearBtn);
    }
    
    function clientSideFiltering(searchTerm) {
        // Get all table rows
        const rows = document.querySelectorAll('tbody tr');
        let visibleCount = 0;
        
        // Filter rows
        rows.forEach(row => {
            // Skip if single cell (no data) row
            if (row.cells.length <= 1) return;
            
            const productName = row.querySelector('td:first-child span')?.textContent.toLowerCase() || '';
            const categoryName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            
            if (productName.includes(searchTerm) || categoryName.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Mobile cards
        const cards = document.querySelectorAll('.md\\:hidden .bg-white.rounded-lg');
        cards.forEach(card => {
            const productName = card.querySelector('h3')?.textContent.toLowerCase() || '';
            const categoryName = card.querySelector('p')?.textContent.toLowerCase() || '';
            
            if (productName.includes(searchTerm) || categoryName.includes(searchTerm)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update results count
        const resultsCount = document.querySelector('.text-black.text-xs.sm\\:text-sm');
        if (resultsCount && searchTerm) {
            resultsCount.textContent = `Showing ${visibleCount} search results`;
        }
    }
});