{{-- Edit Medication Modal --}}
<div id="editMedicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editMedicationModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Medication
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditMedicationModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="editMedicationForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Medication Name and Dosage -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Medication<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="editMedication" name="medication"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter medication name" required value="Lisinopril">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dosage<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="editDosage" name="dosage"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g., 500mg" required value="10mg">
                        </div>
                    </div>

                    <!-- Frequency and Duration -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Frequency<span class="text-red-500">*</span>
                            </label>
                            <select id="editFrequency" name="frequency"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                required>
                                <option value="Once daily" selected>Once daily</option>
                                <option value="Twice daily">Twice daily</option>
                                <option value="Three times daily">Three times daily</option>
                                <option value="Four times daily">Four times daily</option>
                                <option value="Every 4 hours">Every 4 hours</option>
                                <option value="Every 6 hours">Every 6 hours</option>
                                <option value="Every 8 hours">Every 8 hours</option>
                                <option value="Every 12 hours">Every 12 hours</option>
                                <option value="As needed">As needed</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Duration
                            </label>
                            <input type="text" id="editDuration" name="duration"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g., 10 days, ongoing" value="Ongoing">
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="editStartDate" name="startDate"
                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                value="2025-01-15">
                        </div>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="editNotes" name="notes" rows="5"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Additional notes about the medication, instructions, etc.">Take with food in the morning. Monitor for side effects such as dizziness or cough.</textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditMedicationBtn"
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
        const editMedicationModal = document.getElementById('editMedicationModal');
        const editMedicationModalOverlay = document.getElementById('editMedicationModalOverlay');
        const closeEditMedicationModalBtn = document.getElementById('closeEditMedicationModalBtn');
        const cancelEditMedicationBtn = document.getElementById('cancelEditMedicationBtn');
        const editMedicationForm = document.getElementById('editMedicationForm');

        // Find all edit buttons with the class
        const editMedicationButtons = document.querySelectorAll('.edit-medication-btn');

        // Show notification function
        function showNotification(message, type = 'info') {
            // Toast notification implementation
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} text-white`;
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
            const requiredFields = editMedicationForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = editMedicationForm.querySelectorAll('input, select, textarea');
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

        // Open Modal Function
        function openModal(medication, dosage, frequency, duration, startDate, notes) {
            console.log('Opening medication edit modal');

            // Set form values if data is provided
            if (medication) document.getElementById('editMedication').value = medication;
            if (dosage) document.getElementById('editDosage').value = dosage;

            if (frequency) {
                const frequencySelect = document.getElementById('editFrequency');
                if (frequencySelect) {
                    const option = Array.from(frequencySelect.options).find(opt => opt.value === frequency);
                    if (option) option.selected = true;
                }
            }

            if (duration) document.getElementById('editDuration').value = duration;
            if (startDate) document.getElementById('editStartDate').value = startDate;
            if (notes) document.getElementById('editNotes').value = notes;

            // Show the modal
            editMedicationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = editMedicationForm.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            editMedicationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = editMedicationForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = editMedicationForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Handle form submission
        if (editMedicationForm) {
            editMedicationForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect medication data
                const medicationData = {
                    medication: document.getElementById('editMedication').value,
                    dosage: document.getElementById('editDosage').value,
                    frequency: document.getElementById('editFrequency').value,
                    duration: document.getElementById('editDuration').value,
                    startDate: document.getElementById('editStartDate').value,
                    notes: document.getElementById('editNotes').value
                };

                console.log('Medication Data:', medicationData);

                // Show success and close modal
                showNotification('Medication updated successfully!', 'success');
                closeModal();

                // Here you might want to update the UI with the new medication data
                // location.reload(); // or update specific UI elements
            });
        }

        // Add click event to each edit button
        editMedicationButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Get data attributes from the button
                const medication = this.getAttribute('data-medication');
                const dosage = this.getAttribute('data-dosage');
                const frequency = this.getAttribute('data-frequency');
                const duration = this.getAttribute('data-duration');
                const startDate = this.getAttribute('data-start-date');
                const notes = this.getAttribute('data-notes');

                // Open the modal with this medication's data
                openModal(medication, dosage, frequency, duration, startDate, notes);

                console.log('Opening modal for medication:', medication);
            });
        });

        // Event Listeners for modal controls
        if (closeEditMedicationModalBtn) {
            closeEditMedicationModalBtn.addEventListener('click', closeModal);
        }

        if (cancelEditMedicationBtn) {
            cancelEditMedicationBtn.addEventListener('click', closeModal);
        }

        if (editMedicationModalOverlay) {
            editMedicationModalOverlay.addEventListener('click', function (e) {
                if (e.target === editMedicationModalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editMedicationModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditMedicationModal = function (medication, dosage, frequency, duration, startDate, notes) {
            openModal(medication, dosage, frequency, duration, startDate, notes);
        };
    });
</script>