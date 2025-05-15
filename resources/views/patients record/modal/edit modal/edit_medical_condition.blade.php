{{-- Edit Medical Condition Modal --}}
<div id="editMedicalConditionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="medicalConditionModalOverlay"></div>

        <!-- Modal Content - Changed from max-w-2xl to max-w-md -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Medical Condition
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeMedicalConditionModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="medicalConditionForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Medical Condition Information Form -->
                    <div class="space-y-4">
                        <!-- Condition -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Condition<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="conditionName" name="conditionName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter condition name" required value="Hypertension">
                        </div>

                        <!-- Severity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Severity
                            </label>
                            <select id="conditionSeverity" name="conditionSeverity"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="Mild">Mild</option>
                                <option value="Moderate" selected>Moderate</option>
                                <option value="Severe">Severe</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea id="conditionNotes" name="conditionNotes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Additional notes">Patient shows good response to medication. Recommend continued monitoring of sodium intake and regular exercise.</textarea>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelMedicalConditionBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const editMedicalConditionModal = document.getElementById('editMedicalConditionModal');
        const medicalConditionModalOverlay = document.getElementById('medicalConditionModalOverlay');
        const closeMedicalConditionModalBtn = document.getElementById('closeMedicalConditionModalBtn');
        const cancelMedicalConditionBtn = document.getElementById('cancelMedicalConditionBtn');
        const medicalConditionForm = document.getElementById('medicalConditionForm');

        // Find all edit buttons with the class
        const editButtons = document.querySelectorAll('.edit-medical-condition-btn');

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

        // Show notification function
        function showNotification(message, type = 'info') {
            // Toast notification implementation
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'
                } text-white`;
            toast.textContent = message;
            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => document.body.removeChild(toast), 500);
            }, 3000);
        }

        // Form validation function
        function validateForm() {
            let isValid = true;
            const requiredFields = medicalConditionForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = medicalConditionForm.querySelectorAll('input, select, textarea');
            allFields.forEach(field => {
                field.classList.remove('border-red-500');
                const errorMsg = field.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            });

            // Check each required field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');

                    // Add error message below the field
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                    errorMsg.textContent = 'This field is required';
                    field.parentElement.appendChild(errorMsg);

                    isValid = false;

                    // Focus the first invalid field
                    if (isValid === false) {
                        setTimeout(() => field.focus(), 100);
                        isValid = null; // Prevent focusing multiple fields
                    }
                }
            });

            return isValid === true;
        }

        // Handle form submission
        if (medicalConditionForm) {
            medicalConditionForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect medical condition data
                const medicalConditionData = {
                    name: document.getElementById('conditionName').value,
                    severity: document.getElementById('conditionSeverity').value,
                    notes: document.getElementById('conditionNotes').value
                };

                // Here you would typically send the data to the server
                console.log('Medical Condition Data:', medicalConditionData);

                 // Show success and close modal
                 showNotification('Medical Condition updated successfully!', 'success');
                closeModal();
                // Here you might want to update the UI with the new medical condition data
                // This is just a placeholder for demonstration
                updateMedicalConditionDisplay(medicalConditionData);
            });
        }

        // Function to update the UI with new medical condition data
        function updateMedicalConditionDisplay(medicalConditionData) {
            // This function would update the medical condition information on the page
            // For demonstration purposes we'll just log it
            console.log('Updating UI with:', medicalConditionData);

            // In a real implementation, you'd select the elements and update their content
            // Example:
            // document.querySelector('.condition-name').textContent = medicalConditionData.name;
            // document.querySelector('.condition-status').textContent = medicalConditionData.status;
            // etc.
        }

        // Open Modal Function
        function openModal(conditionName, conditionSeverity, conditionNotes) {
            console.log('Opening medical condition edit modal');
            
            // If data is provided, set form values
            if (conditionName) {
                document.getElementById('conditionName').value = conditionName || '';
            }
            
            if (conditionSeverity) {
                const severitySelect = document.getElementById('conditionSeverity');
                if (severitySelect) {
                    // Find the option with matching value
                    const option = Array.from(severitySelect.options).find(opt => opt.value === conditionSeverity);
                    if (option) {
                        option.selected = true;
                    }
                }
            }
            
            if (conditionNotes) {
                document.getElementById('conditionNotes').value = conditionNotes || '';
            }
            
            // Show the modal
            editMedicalConditionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = medicalConditionForm.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing medical condition edit modal');
            editMedicalConditionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = medicalConditionForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = medicalConditionForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Add click event to each edit button
        editButtons.forEach(button => {
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
        if (closeMedicalConditionModalBtn) {
            closeMedicalConditionModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (cancelMedicalConditionBtn) {
            cancelMedicalConditionBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via Cancel button');
            });
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
            if (event.key === 'Escape' && !editMedicalConditionModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditMedicalConditionModal = function(conditionName, conditionSeverity, conditionNotes) {
            openModal(conditionName, conditionSeverity, conditionNotes);
        };
    });
</script>