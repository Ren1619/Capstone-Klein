


{{-- View Prescription Modal --}}
<div id="viewPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="viewPrescriptionModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewPrescriptionModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Prescription Information Display -->
                <div class="space-y-6">
                    <!-- Medication Name and Dosage -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Medication</h4>
                            <p id="viewPrescriptionName" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Dosage</h4>
                            <p id="viewPrescriptionDosage" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                    </div>

                    <!-- Frequency and Duration -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Frequency</h4>
                            <p id="viewPrescriptionFrequency" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Duration</h4>
                            <p id="viewPrescriptionDuration" class="text-base font-medium text-gray-900 p-3 bg-gray-50 rounded-md">Loading...</p>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Notes</h4>
                        <p id="viewPrescriptionNotes" class="text-base text-gray-900 p-3 bg-gray-50 rounded-md whitespace-pre-wrap min-h-[80px]">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewPrescriptionModal = document.getElementById('viewPrescriptionModal');
        const viewPrescriptionModalOverlay = document.getElementById('viewPrescriptionModalOverlay');
        const closeViewPrescriptionModalBtn = document.getElementById('closeViewPrescriptionModalBtn');

        // Buttons to open modal
        const viewPrescriptionBtns = document.querySelectorAll('.view-prescription-btn');
        console.log('Found view prescription buttons:', viewPrescriptionBtns.length);

        // Open Modal Function
        function openViewModal(prescriptionId) {
            console.log('Opening prescription view modal for ID:', prescriptionId);
            
            // Show modal first for better UX
            viewPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Show loading indicators
            document.getElementById('viewPrescriptionName').textContent = 'Loading...';
            document.getElementById('viewPrescriptionDosage').textContent = 'Loading...';
            document.getElementById('viewPrescriptionFrequency').textContent = 'Loading...';
            document.getElementById('viewPrescriptionDuration').textContent = 'Loading...';
            document.getElementById('viewPrescriptionNotes').textContent = 'Loading...';
            
            // Try to fetch the updated prescription data from the edit endpoint
            fetch(`/prescriptions/${prescriptionId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Could not fetch prescription data');
                }
                return response.json();
            })
            .then(response => {
                console.log('Received API response:', response);
                
                if (response.success) {
                    const prescription = response.data;
                    
                    // Populate the view fields with the prescription data
                    document.getElementById('viewPrescriptionName').textContent = prescription.medication_name || 'N/A';
                    document.getElementById('viewPrescriptionDosage').textContent = prescription.dosage || 'N/A';
                    document.getElementById('viewPrescriptionFrequency').textContent = prescription.frequency || 'N/A';
                    document.getElementById('viewPrescriptionDuration').textContent = prescription.duration || 'N/A';
                    document.getElementById('viewPrescriptionNotes').textContent = prescription.note || 'No notes provided';
                }
            })
            .catch(error => {
                console.error('Error fetching prescription data:', error);
                
                // Fallback to extracting data from the DOM
                try {
                    const row = document.querySelector(`.view-prescription-btn[data-id="${prescriptionId}"]`);
                    if (row) {
                        console.log('Found row in DOM:', row);
                        
                        // Get the medication name from the span
                        const nameElement = row.querySelector('span.font-normal');
                        if (nameElement) {
                            document.getElementById('viewPrescriptionName').textContent = nameElement.textContent.trim();
                        } else {
                            document.getElementById('viewPrescriptionName').textContent = 'Could not determine';
                        }
                        
                        // For other fields, we need to check if we have expanded details
                        // This depends on your actual HTML structure
                        const detailsContainer = row.parentElement.querySelector('.text-xs');
                        if (detailsContainer) {
                            const spans = detailsContainer.querySelectorAll('.inline-block');
                            if (spans.length >= 3) {
                                document.getElementById('viewPrescriptionDosage').textContent = spans[0].textContent.trim();
                                document.getElementById('viewPrescriptionFrequency').textContent = spans[1].textContent.trim();
                                document.getElementById('viewPrescriptionDuration').textContent = spans[2].textContent.trim();
                            } else {
                                document.getElementById('viewPrescriptionDosage').textContent = 'N/A';
                                document.getElementById('viewPrescriptionFrequency').textContent = 'N/A';
                                document.getElementById('viewPrescriptionDuration').textContent = 'N/A';
                            }
                            
                            // Look for notes
                            const noteElement = detailsContainer.querySelector('p');
                            if (noteElement) {
                                const noteText = noteElement.textContent.replace('Note:', '').trim();
                                document.getElementById('viewPrescriptionNotes').textContent = noteText;
                            } else {
                                document.getElementById('viewPrescriptionNotes').textContent = 'No notes available';
                            }
                        } else {
                            // Default values if no details container found
                            document.getElementById('viewPrescriptionDosage').textContent = 'N/A';
                            document.getElementById('viewPrescriptionFrequency').textContent = 'N/A';
                            document.getElementById('viewPrescriptionDuration').textContent = 'N/A';
                            document.getElementById('viewPrescriptionNotes').textContent = 'No notes available';
                        }
                    } else {
                        console.error('Could not find prescription row in DOM');
                        setDefaultValues();
                    }
                } catch (err) {
                    console.error('Error extracting data from DOM:', err);
                    setDefaultValues();
                }
            });
        }
        
        function setDefaultValues() {
            document.getElementById('viewPrescriptionName').textContent = 'N/A';
            document.getElementById('viewPrescriptionDosage').textContent = 'N/A';
            document.getElementById('viewPrescriptionFrequency').textContent = 'N/A';
            document.getElementById('viewPrescriptionDuration').textContent = 'N/A';
            document.getElementById('viewPrescriptionNotes').textContent = 'No notes available';
        }

        // Close Modal Function
        function closeViewModal() {
            console.log('Closing prescription view modal');
            viewPrescriptionModal.classList.remove('flex');
            viewPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event Listeners for opening modal
        viewPrescriptionBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const prescriptionId = this.getAttribute('data-id');
                if (!prescriptionId) {
                    console.error('No prescription ID found on button');
                    return;
                }
                
                openViewModal(prescriptionId);
            });
        });
        
        // Also use event delegation as a backup
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.view-prescription-btn');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                
                const prescriptionId = btn.getAttribute('data-id');
                if (!prescriptionId) {
                    console.error('No prescription ID found on button via delegation');
                    return;
                }
                
                openViewModal(prescriptionId);
            }
        });

        // Setup event listeners for closing the modal
        if (closeViewPrescriptionModalBtn) {
            closeViewPrescriptionModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeViewModal();
            });
        }
        
        if (viewPrescriptionModalOverlay) {
            viewPrescriptionModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewPrescriptionModalOverlay) {
                    closeViewModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewPrescriptionModal.classList.contains('hidden')) {
                closeViewModal();
            }
        });
        
        // Make functions available globally
        window.openViewPrescriptionModal = openViewModal;
        window.closePrescriptionModal = closeViewModal;
    });
</script>