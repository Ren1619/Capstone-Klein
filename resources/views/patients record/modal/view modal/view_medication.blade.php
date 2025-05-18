
{{-- View Medication Modal --}}
<div id="viewMedicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="viewMedicationModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Medication
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewMedicationModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Medication Information Display -->
                <div class="space-y-6">
                    <!-- Medication Name and Dosage -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Medication</h4>
                            <p id="viewMedicationName" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Dosage</h4>
                            <p id="viewMedicationDosage" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                    </div>

                    <!-- Frequency and Duration -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Frequency</h4>
                            <p id="viewMedicationFrequency" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Duration</h4>
                            <p id="viewMedicationDuration" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                    </div>

                    <!-- Start Date -->
                    <!-- <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Start Date</h4>
                        <p id="viewMedicationStartDate" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                    </div> -->

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Notes</h4>
                        <p id="viewMedicationNotes" class="text-base text-gray-900 p-3 bg-gray-50 rounded-md whitespace-pre-wrap min-h-[80px]">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewMedicationModal = document.getElementById('viewMedicationModal');
        const viewMedicationModalOverlay = document.getElementById('viewMedicationModalOverlay');
        const closeViewMedicationModalBtn = document.getElementById('closeViewMedicationModalBtn');

        // Button to open modal
        const viewMedicationBtns = document.querySelectorAll('.view-medication-btn');

        // Open Modal Function
        function openViewModal(medicationId) {
            console.log('Opening medication view modal for ID:', medicationId);
            
            // Show modal first for better UX
            viewMedicationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Show loading indicators
            document.getElementById('viewMedicationName').textContent = 'Loading...';
            document.getElementById('viewMedicationDosage').textContent = 'Loading...';
            document.getElementById('viewMedicationFrequency').textContent = 'Loading...';
            document.getElementById('viewMedicationDuration').textContent = 'Loading...';
            // document.getElementById('viewMedicationStartDate').textContent = 'Loading...';
            document.getElementById('viewMedicationNotes').textContent = 'Loading...';
            
            // Fetch medication data via AJAX
            fetch(`/medications/${medicationId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch medication data');
                }
                return response.json();
            })
            .then(data => {
                console.log('Raw response:', data);
                
                // Populate display fields
                document.getElementById('viewMedicationName').textContent = data.medication || 'N/A';
                document.getElementById('viewMedicationDosage').textContent = data.dosage || 'N/A';
                document.getElementById('viewMedicationFrequency').textContent = data.frequency || 'N/A';
                document.getElementById('viewMedicationDuration').textContent = data.duration || 'N/A';
                // document.getElementById('viewMedicationStartDate').textContent = data.start_date || 'N/A';
                document.getElementById('viewMedicationNotes').textContent = data.note || 'No notes available';
            })
            .catch(error => {
                console.error('Error fetching medication data:', error);
                
                // Try to extract from page as fallback
                try {
                    const element = document.querySelector(`[data-medication-id="${medicationId}"]`);
                    if (element) {
                        const medicationSpan = element.querySelector('span.font-normal');
                        if (medicationSpan) {
                            const medicationText = medicationSpan.textContent.trim();
                            document.getElementById('viewMedicationName').textContent = medicationText;
                            document.getElementById('viewMedicationDosage').textContent = 'N/A';
                            document.getElementById('viewMedicationFrequency').textContent = 'N/A';
                            document.getElementById('viewMedicationDuration').textContent = 'N/A';
                            document.getElementById('viewMedicationStartDate').textContent = 'N/A';
                            document.getElementById('viewMedicationNotes').textContent = 'No notes available';
                            return;
                        }
                    }
                } catch (err) {
                    console.error('Error extracting from page:', err);
                }
                
                // If all else fails
                document.getElementById('viewMedicationName').textContent = 'Could not load medication';
                document.getElementById('viewMedicationDosage').textContent = 'Error';
                document.getElementById('viewMedicationFrequency').textContent = 'Error';
                document.getElementById('viewMedicationDuration').textContent = 'Error';
                // document.getElementById('viewMedicationStartDate').textContent = 'Error';
                document.getElementById('viewMedicationNotes').textContent = 'Error fetching medication details';
                
                // Show error but keep modal open
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Could not retrieve full medication details.',
                        icon: 'warning',
                        confirmButtonColor: '#F91D7C'
                    });
                }
            });
        }

        // Close Modal Function
        function closeViewModal() {
            console.log('Closing medication view modal');
            viewMedicationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event Listeners
        viewMedicationBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const medicationId = this.getAttribute('data-medication-id');
                if (!medicationId) {
                    console.error('No medication ID found on button');
                    return;
                }
                
                openViewModal(medicationId);
            });
        });

        // Setup event listeners for closing the modal
        if (closeViewMedicationModalBtn) {
            closeViewMedicationModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeViewModal();
            });
        }
        
        if (viewMedicationModalOverlay) {
            viewMedicationModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewMedicationModalOverlay) {
                    closeViewModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewMedicationModal.classList.contains('hidden')) {
                closeViewModal();
            }
        });
        
        // Make functions available globally
        window.openViewMedicationModal = openViewModal;
        window.closeMedicationModal = closeViewModal;
    });
</script>