{{-- View Medical Condition Modal --}}
<div id="viewMedicalConditionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="medicalConditionModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Medical Condition
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalXBtn">
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
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Condition</h4>
                        <p id="conditionName" class="text-base font-medium text-gray-900">Hypertension</p>
                    </div>

                    <!-- Severity -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Severity</h4>
                        <p id="conditionSeverity" class="text-base font-medium text-gray-900">Moderate</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="conditionNotes" class="text-base text-black whitespace-pre-wrap">Patient shows good response to medication. Recommend continued monitoring of sodium intake and regular exercise.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewMedicalConditionModal = document.getElementById('viewMedicalConditionModal');
        const medicalConditionModalOverlay = document.getElementById('medicalConditionModalOverlay');
        const closeModalXBtn = document.getElementById('closeModalXBtn');

        // Find all view buttons with the class
        const viewButtons = document.querySelectorAll('.view-medical-condition-btn');
        
        // Remove references to the close button that no longer exists
        const closeMedicalConditionBtn = null;

        // Add custom scrollbar styles if not already added
        if (!document.getElementById('customScrollbarStyles')) {
            const style = document.createElement('style');
            style.id = 'customScrollbarStyles';
            style.textContent = `
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #ddd;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #ccc;
            }
            `;
            document.head.appendChild(style);
        }

        // Open Modal Function
        function openModal(conditionName, conditionSeverity, conditionNotes) {
            console.log('Opening medical condition view modal');
            
            // Set display values
            if (conditionName) {
                document.getElementById('conditionName').textContent = conditionName || 'N/A';
            }
            
            if (conditionSeverity) {
                document.getElementById('conditionSeverity').textContent = conditionSeverity || 'N/A';
            }
            
            if (conditionNotes) {
                document.getElementById('conditionNotes').textContent = conditionNotes || 'No notes available';
            }
            
            // Show the modal
            viewMedicalConditionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing medical condition view modal');
            viewMedicalConditionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Add click event to each view button
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const conditionName = this.getAttribute('data-condition-name');
                const conditionSeverity = this.getAttribute('data-condition-severity');
                const conditionNotes = this.getAttribute('data-condition-notes');
                
                // Open the modal with this condition's data
                openModal(conditionName, conditionSeverity, conditionNotes);
                
                console.log('Opening modal for condition:', conditionName);
            });
        });

        // Event Listeners for modal controls
        if (closeModalXBtn) {
            closeModalXBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        } else {
            console.error('Close button (X) was not found in the DOM');
        }



        if (medicalConditionModalOverlay) {
            medicalConditionModalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === medicalConditionModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !viewMedicalConditionModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openViewMedicalConditionModal = function(conditionName, conditionSeverity, conditionNotes) {
            openModal(conditionName, conditionSeverity, conditionNotes);
        };
    });
</script>