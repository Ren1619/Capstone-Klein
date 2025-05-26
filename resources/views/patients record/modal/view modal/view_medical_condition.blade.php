

{{-- View Medical Condition Modal --}}
<div id="viewMedicalConditionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="viewConditionModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Medical Condition
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewConditionModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Medical Condition Information Display -->
                <div class="space-y-6">
                    <!-- Condition -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Medical Condition</h4>
                        <p id="viewConditionName" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Notes</h4>
                        <p id="viewConditionNotes" class="text-base text-gray-900 p-3 bg-gray-50 rounded-md whitespace-pre-wrap min-h-[100px]">Loading...</p>
                    </div>

                    <!-- Close Button -->
                    <!-- <div class="pt-2">
                        <button type="button" id="closeViewConditionBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Close
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewMedicalConditionModal = document.getElementById('viewMedicalConditionModal');
        const viewConditionModalOverlay = document.getElementById('viewConditionModalOverlay');
        const closeViewConditionModalBtn = document.getElementById('closeViewConditionModalBtn');
        const closeViewConditionBtn = document.getElementById('closeViewConditionBtn');

        // Button to open modal
        const viewConditionBtns = document.querySelectorAll('.view-medical-condition-btn');

        // Open Modal Function
        function openViewModal(conditionId) {
            console.log('Opening medical condition view modal for ID:', conditionId);
            
            // Show modal first for better UX
            viewMedicalConditionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Show loading indicators
            document.getElementById('viewConditionName').textContent = 'Loading...';
            document.getElementById('viewConditionNotes').textContent = 'Loading...';
            
            // Fetch condition data via AJAX
            fetch(`/conditions/${conditionId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch condition data');
                }
                return response.json();
            })
            .then(data => {
                console.log('Condition data fetched for viewing:', data);
                
                // Populate display fields
                document.getElementById('viewConditionName').textContent = data.condition || 'N/A';
                document.getElementById('viewConditionNotes').textContent = data.note || 'No notes available';
            })
            .catch(error => {
                console.error('Error fetching condition data:', error);
                
                // Try to extract from page as fallback
                try {
                    const element = document.querySelector(`[data-condition-id="${conditionId}"]`);
                    if (element) {
                        const conditionSpan = element.querySelector('span.font-normal');
                        if (conditionSpan) {
                            const conditionText = conditionSpan.textContent.trim();
                            document.getElementById('viewConditionName').textContent = conditionText;
                            document.getElementById('viewConditionNotes').textContent = 'No notes available';
                            return;
                        }
                    }
                } catch (err) {
                    console.error('Error extracting from page:', err);
                }
                
                // If all else fails
                document.getElementById('viewConditionName').textContent = 'Could not load condition';
                document.getElementById('viewConditionNotes').textContent = 'Error fetching condition details';
                
                // Show error but keep modal open
                Swal.fire({
                    title: 'Warning',
                    text: 'Could not retrieve full condition details.',
                    icon: 'warning',
                    confirmButtonColor: '#F91D7C'
                });
            });
        }

        // Close Modal Function
        function closeViewModal() {
            console.log('Closing medical condition view modal');
            viewMedicalConditionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event Listeners
        viewConditionBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const conditionId = this.getAttribute('data-condition-id');
                if (!conditionId) {
                    console.error('No condition ID found on button');
                    return;
                }
                
                openViewModal(conditionId);
            });
        });

        // Setup event listeners for closing the modal
        if (closeViewConditionModalBtn) {
            closeViewConditionModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeViewModal();
            });
        }
        
        if (closeViewConditionBtn) {
            closeViewConditionBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeViewModal();
            });
        }
        
        if (viewConditionModalOverlay) {
            viewConditionModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewConditionModalOverlay) {
                    closeViewModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewMedicalConditionModal.classList.contains('hidden')) {
                closeViewModal();
            }
        });
    });
</script>