

{{-- View Allergies Modal --}}
<div id="viewAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="allergyModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Allergy
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewAllergyBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Allergy Information Display -->
                <div class="space-y-6">
                    <!-- Allergy -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Allergy</h4>
                        <p id="viewAllergyName" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Notes</h4>
                        <p id="viewAllergyNotes" class="text-base text-gray-900 p-3 bg-gray-50 rounded-md whitespace-pre-wrap min-h-[100px]">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Immediately add click handler to existing elements
    (function() {
        console.log('Initializing allergy view handlers immediately');
        
        // Add click handlers to existing rows
        const addClickHandlers = function() {
            const viewAllergyBtns = document.querySelectorAll('.view-allergy-btn');
            console.log('Found view buttons:', viewAllergyBtns.length);
            
            viewAllergyBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    console.log('Row clicked!');
                    const allergyId = this.getAttribute('data-allergy-id');
                    if (!allergyId) {
                        console.error('No allergy ID found on button');
                        return;
                    }
                    openViewAllergyModal(allergyId);
                });
            });
        };
        
        // Try adding handlers now
        addClickHandlers();
        
        // Also add them when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, adding allergy view handlers');
            
            // Define modal elements
            const viewAllergyModal = document.getElementById('viewAllergyModal');
            const allergyModalOverlay = document.getElementById('allergyModalOverlay');
            const closeViewAllergyBtn = document.getElementById('closeViewAllergyBtn');
            
            // Add handlers again in case they weren't added before
            addClickHandlers();
            
            // Setup event listeners for closing the modal
            if (closeViewAllergyBtn) {
                closeViewAllergyBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeViewAllergyModal();
                });
            }
            
            if (allergyModalOverlay) {
                allergyModalOverlay.addEventListener('click', function(e) {
                    if (e.target === allergyModalOverlay) {
                        closeViewAllergyModal();
                    }
                });
            }
            
            // Close modal on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !viewAllergyModal.classList.contains('hidden')) {
                    closeViewAllergyModal();
                }
            });
        });
        
        // Global functions for opening and closing the modal
        window.openViewAllergyModal = function(allergyId) {
            console.log('Opening allergy view modal for ID:', allergyId);
            
            const viewAllergyModal = document.getElementById('viewAllergyModal');
            
            // Show modal first for better UX
            viewAllergyModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Show loading indicators
            document.getElementById('viewAllergyName').textContent = 'Loading...';
            document.getElementById('viewAllergyNotes').textContent = 'Loading...';
            
            // Fetch allergy data via AJAX
            fetch(`/allergies/${allergyId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch allergy data');
                }
                return response.json();
            })
            .then(data => {
                console.log('Allergy data fetched for viewing:', data);
                
                // Populate display fields
                document.getElementById('viewAllergyName').textContent = data.allergies || 'N/A';
                document.getElementById('viewAllergyNotes').textContent = data.note || 'No notes available';
            })
            .catch(error => {
                console.error('Error fetching allergy data:', error);
                
                // Try to extract from page as fallback
                try {
                    const element = document.querySelector(`[data-allergy-id="${allergyId}"]`);
                    if (element) {
                        const allergySpan = element.querySelector('span.font-normal');
                        if (allergySpan) {
                            const allergyText = allergySpan.textContent.trim();
                            document.getElementById('viewAllergyName').textContent = allergyText;
                            document.getElementById('viewAllergyNotes').textContent = 'No notes available';
                            return;
                        }
                    }
                } catch (err) {
                    console.error('Error extracting from page:', err);
                }
                
                // If all else fails
                document.getElementById('viewAllergyName').textContent = 'Could not load allergy';
                document.getElementById('viewAllergyNotes').textContent = 'Error fetching allergy details';
                
                // Show error if SweetAlert is available
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Could not retrieve full allergy details.',
                        icon: 'warning',
                        confirmButtonColor: '#F91D7C'
                    });
                } else {
                    console.error('SweetAlert not available');
                }
            });
        };

        window.closeAllergyModal = function() {
            console.log('Closing allergy view modal');
            const viewAllergyModal = document.getElementById('viewAllergyModal');
            viewAllergyModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };
        
        window.closeViewAllergyModal = window.closeAllergyModal;
    })();
</script>