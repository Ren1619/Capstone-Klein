{{-- Edit Allergies Modal --}}
<div id="editAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto"> 
    <div class="flex items-center justify-center min-h-screen px-4"> 
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="allergyModalOverlay"></div>

        <!-- Modal Content - Changed to max-w-md to match add modal -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10"> 
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Allergy
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeAllergyModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="allergyForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Allergy Information Form -->
                    <div class="space-y-4">
                        <!-- Allergy -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Allergy<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="allergyName" name="allergyName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter allergy name" required value="Peanuts">
                        </div>

                        <!-- Reaction Severity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Reaction Severity
                            </label>
                            <select id="allergySeverity" name="allergySeverity"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="Mild">Mild</option>
                                <option value="Moderate" selected>Moderate</option>
                                <option value="Severe">Severe</option>
                                <option value="Life-threatening">Life-threatening</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea id="allergyNotes" name="allergyNotes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Additional notes">Patient experiences hives and difficulty breathing when exposed to peanuts. Patient carries an EpiPen.</textarea>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelAllergyBtn"
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
        const editAllergyModal = document.getElementById('editAllergyModal');
        const allergyModalOverlay = document.getElementById('allergyModalOverlay');
        const closeAllergyModalBtn = document.getElementById('closeAllergyModalBtn');
        const cancelAllergyBtn = document.getElementById('cancelAllergyBtn');
        const allergyForm = document.getElementById('allergyForm');

        // Find all edit buttons with the class
        const editButtons = document.querySelectorAll('.edit-allergy-btn');

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
            const requiredFields = allergyForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = allergyForm.querySelectorAll('input, select, textarea');
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
        if (allergyForm) {
            allergyForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect allergy data
                const allergyData = {
                    name: document.getElementById('allergyName').value,
                    severity: document.getElementById('allergySeverity').value,
                    notes: document.getElementById('allergyNotes').value
                };

                // Here you would typically send the data to the server
                console.log('Allergy Data:', allergyData);

                // Show success and close modal
                showNotification('Allergy updated successfully!', 'success');
                closeModal();

                // Here you might want to update the UI with the new allergy data
                // This is just a placeholder for demonstration
                updateAllergyDisplay(allergyData);
            });
        }

        // Function to update the UI with new allergy data
        function updateAllergyDisplay(allergyData) {
            // This function would update the allergy information on the page
            // For demonstration purposes we'll just log it
            console.log('Updating UI with:', allergyData);

            // In a real implementation, you'd select the elements and update their content
            // Example:
            // document.querySelector('.allergy-name').textContent = allergyData.name;
            // document.querySelector('.allergy-severity').textContent = allergyData.severity;
            // etc.
        }

        // Open Modal Function
        function openModal(allergyName, allergySeverity, allergyNotes) {
            console.log('Opening allergy edit modal');
            
            // If data is provided, set form values
            if (allergyName) {
                document.getElementById('allergyName').value = allergyName || '';
            }
            
            if (allergySeverity) {
                const severitySelect = document.getElementById('allergySeverity');
                if (severitySelect) {
                    // Find the option with matching value
                    const option = Array.from(severitySelect.options).find(opt => opt.value === allergySeverity);
                    if (option) {
                        option.selected = true;
                    }
                }
            }
            
            if (allergyNotes) {
                document.getElementById('allergyNotes').value = allergyNotes || '';
            }
            
            // Show the modal
            editAllergyModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = allergyForm.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing allergy edit modal');
            editAllergyModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = allergyForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = allergyForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Add click event to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const allergyName = this.getAttribute('data-allergy-name');
                const allergySeverity = this.getAttribute('data-allergy-severity');
                const allergyNotes = this.getAttribute('data-allergy-notes');
                
                // Open the modal with this allergy's data
                openModal(allergyName, allergySeverity, allergyNotes);
                
                console.log('Opening modal for allergy:', allergyName);
            });
        });

        // Event Listeners for modal controls
        if (closeAllergyModalBtn) {
            closeAllergyModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (cancelAllergyBtn) {
            cancelAllergyBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via Cancel button');
            });
        }

        if (allergyModalOverlay) {
            allergyModalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === allergyModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editAllergyModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditAllergyModal = function(allergyName, allergySeverity, allergyNotes) {
            openModal(allergyName, allergySeverity, allergyNotes);
        };
    });
</script>