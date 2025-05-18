<!-- {{-- Edit Prescription Modal --}}
<div id="editPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay--}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editModalOverlay"></div>

        {{-- Modal Content--}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            {{-- Modal Header--}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body--}}
            <div class="p-6">
                <form id="editPrescriptionForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    {{-- Hidden fields to store patient data--}}
                    <input type="hidden" id="editPatientName" name="patientName" value="">
                    <input type="hidden" id="editPatientAge" name="patientAge" value="">
                    <input type="hidden" id="editPatientSex" name="patientSex" value="">

                    {{-- Medication Section--}}
                    <div class="mb-4">
                        {{-- Add Medication Button--}}
                        <div class="flex justify-end mb-3">
                            <button type="button" id="editAddMedicationBtn"
                                class="text-[#F91D7C] flex items-center text-sm hover:text-[#e01a70] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        {{-- Column Headers - Rebalanced for better duration visibility--}}
                        <div class="grid grid-cols-12 gap-3 mb-2">
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Medication<span
                                        class="text-red-500">*</span></label>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Dosage<span
                                        class="text-red-500">*</span></label>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Frequency<span
                                        class="text-red-500">*</span></label>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Duration<span
                                        class="text-red-500">*</span></label>
                            </div>
                        </div>

                        {{-- Scrollable Medications List--}}
                        <div class="max-h-64 overflow-y-auto pr-1 mb-4 custom-scrollbar">
                            <div id="editMedicationsList" class="space-y-2">
                                {{-- Medication rows will be added by JavaScript--}}
                            </div>
                        </div>
                    </div>

                    {{-- Notes Field--}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea id="editPrescriptionNotes" name="prescriptionNotes" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add doctor's notes here"></textarea>
                    </div>

                    {{-- Button Actions--}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Medication Row Template (hidden)--}}
<template id="editMedicationRowTemplate">
    <div class="medication-row grid grid-cols-12 gap-3 items-center p-2 rounded-lg hover:bg-gray-50">
        <div class="col-span-3">
            <input type="text" name="medication[]"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent text-sm"
                placeholder="Enter medication" required>
        </div>
        <div class="col-span-3">
            <input type="text" name="dosage[]"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent text-sm"
                placeholder="Dosage" required>
        </div>
        <div class="col-span-3">
            <select name="frequency[]"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent text-sm"
                required>
                <option value="">Select</option>
                <option value="Once daily">Once daily</option>
                <option value="Twice daily">Twice daily</option>
                <option value="Three times daily">Three times daily</option>
                <option value="Four times daily">Four times daily</option>
                <option value="Every 4 hours">Every 4 hours</option>
                <option value="Every 6 hours">Every 6 hours</option>
                <option value="Every 8 hours">Every 8 hours</option>
                <option value="As needed">As needed</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="col-span-2">
            <input type="text" name="duration[]"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent text-sm font-medium"
                placeholder="Days" required>
        </div>
        <div class="col-span-1 flex justify-center">
            <button type="button"
                class="remove-medication text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-gray-100">
                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
            </button>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const editPrescriptionModal = document.getElementById('editPrescriptionModal');
        const editModalOverlay = document.getElementById('editModalOverlay');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editPrescriptionForm = document.getElementById('editPrescriptionForm');

        // Find all edit buttons with the class
        const editPrescriptionButtons = document.querySelectorAll('.edit-prescription-btn');

        // Medication Elements
        const editMedicationsList = document.getElementById('editMedicationsList');
        const editAddMedicationBtn = document.getElementById('editAddMedicationBtn');
        const editMedicationRowTemplate = document.getElementById('editMedicationRowTemplate');

        // Add custom scrollbar styles if not already added
        if (!document.querySelector('style.prescription-styles')) {
            const style = document.createElement('style');
            style.className = 'prescription-styles';
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
            /* Ensure text doesn't get cut off in smaller fields */
            input, select {
                text-overflow: ellipsis;
                min-width: 0;
            }
            /* Make duration field more readable */
            input[name="duration[]"] {
                font-weight: 500; /* Slightly bolder for better readability */
                font-size: 0.9rem; /* Slightly larger */
                text-align: center; /* Center text for better visibility */
            }
            /* Prevent long text from breaking layout */
            .medication-row input, .medication-row select {
                min-width: 0;
            }
            /* Add tooltip for truncated text */
            .medication-row input:hover, .medication-row select:hover {
                position: relative;
            }
            /* Increase legibility */
            .medication-row {
                transition: all 0.2s ease;
            }
            .medication-row:hover {
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
        `;
            document.head.appendChild(style);
        }

        // Function to add new medication row
        function addMedicationRow(medication = '', dosage = '', frequency = '', duration = '') {
            const clone = document.importNode(editMedicationRowTemplate.content, true);

            // Set values if provided
            if (medication) clone.querySelector('input[name="medication[]"]').value = medication;
            if (dosage) clone.querySelector('input[name="dosage[]"]').value = dosage;
            if (frequency) {
                const select = clone.querySelector('select[name="frequency[]"]');
                const option = Array.from(select.options).find(opt => opt.value === frequency);
                if (option) option.selected = true;
            }
            if (duration) clone.querySelector('input[name="duration[]"]').value = duration;

            const removeBtn = clone.querySelector('.remove-medication');

            // Set up removal functionality
            removeBtn.addEventListener('click', function () {
                const allRows = document.querySelectorAll('#editMedicationsList .medication-row');
                if (allRows.length > 1) {
                    this.closest('.medication-row').remove();
                } else {
                    showNotification('At least one medication is required', 'error');
                }
            });

            // Add the new row to the list
            editMedicationsList.appendChild(clone);

            // Focus on the new medication field
            setTimeout(() => {
                const medicationField = editMedicationsList.lastElementChild.querySelector('input[name="medication[]"]');
                if (medicationField) medicationField.focus();
            }, 10);
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
            const requiredFields = editPrescriptionForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = editPrescriptionForm.querySelectorAll('input, select, textarea');
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
        function openModal(prescriptionData) {
            console.log('Opening prescription edit modal');

            // Clear existing medication rows
            while (editMedicationsList.firstChild) {
                editMedicationsList.removeChild(editMedicationsList.firstChild);
            }

            // Set form values if data is provided
            if (prescriptionData) {
                // Set patient data
                if (prescriptionData.patientName) document.getElementById('editPatientName').value = prescriptionData.patientName;
                if (prescriptionData.patientAge) document.getElementById('editPatientAge').value = prescriptionData.patientAge;
                if (prescriptionData.patientSex) document.getElementById('editPatientSex').value = prescriptionData.patientSex;

                // Set notes
                if (prescriptionData.notes) document.getElementById('editPrescriptionNotes').value = prescriptionData.notes;

                // Add medication rows
                if (prescriptionData.medications && prescriptionData.medications.length > 0) {
                    prescriptionData.medications.forEach(med => {
                        addMedicationRow(med.medication, med.dosage, med.frequency, med.duration);
                    });
                } else {
                    // Add at least one empty row
                    addMedicationRow();
                }
            } else {
                // Add one empty row if no data provided
                addMedicationRow();
            }

            // Show the modal
            editPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            editPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = editPrescriptionForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = editPrescriptionForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Handle form submission
        if (editPrescriptionForm) {
            editPrescriptionForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect medication data
                const medications = [];
                const medicationRows = document.querySelectorAll('#editMedicationsList .medication-row');

                medicationRows.forEach(row => {
                    medications.push({
                        medication: row.querySelector('input[name="medication[]"]').value,
                        dosage: row.querySelector('input[name="dosage[]"]').value,
                        frequency: row.querySelector('select[name="frequency[]"]').value,
                        duration: row.querySelector('input[name="duration[]"]').value
                    });
                });

                // Prepare the full prescription data
                const prescriptionData = {
                    patientName: document.getElementById('editPatientName').value,
                    patientAge: document.getElementById('editPatientAge').value,
                    patientSex: document.getElementById('editPatientSex').value,
                    notes: document.getElementById('editPrescriptionNotes').value,
                    medications
                };

                console.log('Updated Prescription Data:', prescriptionData);

                // Show success and close modal
                showNotification('Prescription updated successfully!', 'success');
                closeModal();

                // Here you might want to update the UI with the updated prescription data
                // location.reload(); // or update specific UI elements
            });
        }

        // Add click event to each edit button
        editPrescriptionButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Get prescription data from data attributes or API
                // This is just an example - you would typically get this data from your backend
                const prescriptionData = {
                    patientName: this.getAttribute('data-patient-name') || 'Earl Francis Philip',
                    patientAge: this.getAttribute('data-patient-age') || '21',
                    patientSex: this.getAttribute('data-patient-sex') || 'male',
                    notes: this.getAttribute('data-notes') || '',
                    medications: JSON.parse(this.getAttribute('data-medications') || '[]')
                };

                // If no medications were found in the data attribute, add a sample one for testing
                if (prescriptionData.medications.length === 0) {
                    prescriptionData.medications = [
                        {
                            medication: 'Lisinopril',
                            dosage: '500mg',
                            frequency: 'Three times daily',
                            duration: '7'
                        }
                    ];
                }

                // Open the modal with this prescription's data
                openModal(prescriptionData);

                console.log('Opening modal for prescription');
            });
        });

        // Event Listeners for modal controls
        if (closeEditModalBtn) {
            closeEditModalBtn.addEventListener('click', closeModal);
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeModal);
        }

        if (editModalOverlay) {
            editModalOverlay.addEventListener('click', function (e) {
                if (e.target === editModalOverlay) {
                    closeModal();
                }
            });
        }

        // Add medication button listener
        if (editAddMedicationBtn) {
            editAddMedicationBtn.addEventListener('click', function () {
                addMedicationRow();
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editPrescriptionModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditPrescriptionModal = function (prescriptionData) {
            openModal(prescriptionData);
        };
    });
</script> -->


{{-- Edit Prescription Modal (Simplified) --}}
<div id="editPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="editPrescriptionForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" id="edit_prescription_ID" name="prescription_ID">
                    <input type="hidden" id="edit_visit_ID" name="visit_ID">

                    <!-- Single Medication Entry -->
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <!-- Medication Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Medication Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_medication_name" name="medication_name" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter medication name" required>
                        </div>

                        <!-- Dosage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dosage <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_dosage" name="dosage" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 500mg" required>
                        </div>

                        <!-- Frequency -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Frequency <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_frequency" name="frequency" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. Twice daily" required>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_duration" name="duration" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 7 days" required>
                        </div>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea id="edit_note" name="note" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add doctor's notes here"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditBtn"
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
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const editPrescriptionModal = document.getElementById('editPrescriptionModal');
        const editModalOverlay = document.getElementById('editModalOverlay');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editPrescriptionForm = document.getElementById('editPrescriptionForm');
        
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.edit-prescription-btn');
        
        // Function to open edit modal and load prescription data
        function openEditModal(prescriptionId) {
            // Fetch prescription data with detailed error handling
            fetch(`/prescriptions/${prescriptionId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Edit API Response Status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response Error Text:', text);
                        throw new Error(`Failed to fetch prescription details (Status: ${response.status})`);
                    });
                }
                return response.json();
            })
            .then(response => {
                if (response.success) {
                    const prescription = response.data;
                    
                    // Populate form fields
                    document.getElementById('edit_prescription_ID').value = prescription.prescription_ID;
                    document.getElementById('edit_visit_ID').value = prescription.visit_ID;
                    document.getElementById('edit_medication_name').value = prescription.medication_name;
                    document.getElementById('edit_dosage').value = prescription.dosage;
                    document.getElementById('edit_frequency').value = prescription.frequency;
                    document.getElementById('edit_duration').value = prescription.duration;
                    document.getElementById('edit_note').value = prescription.note || '';
                    
                    // Show the modal
                    editPrescriptionModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Failed to load prescription details',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error',
                    confirmButtonColor: '#F91D7C'
                });
                console.error('Error:', error);
            });
        }
        
        // Function to close modal
        function closeEditModal() {
            editPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            editPrescriptionForm.reset();
        }
        
        // Add click event to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const prescriptionId = this.getAttribute('data-id');
                openEditModal(prescriptionId);
            });
        });
        
        // Handle form submission
        if (editPrescriptionForm) {
            editPrescriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple validation
                const requiredFields = editPrescriptionForm.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (!isValid) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please fill out all required fields',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    return;
                }
                
                // Get prescription ID from hidden field
                const prescriptionId = document.getElementById('edit_prescription_ID').value;
                
                // Prepare form data
                const formData = new FormData(editPrescriptionForm);
                
                // Send update request
                fetch(`/prescriptions/${prescriptionId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                      document.querySelector('input[name="_token"]')?.value
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update prescription');
                    }
                    return response.json();
                })
                .then(response => {
                    if (response.success) {
                        // Close modal first
                        closeEditModal();
                        
                        // Then show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Prescription updated successfully',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C'
                        }).then(() => {
                            // Reload the page to reflect the changes
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Failed to update prescription',
                            icon: 'error',
                            confirmButtonColor: '#F91D7C'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    console.error('Error:', error);
                });
            });
        }
        
        // Event listeners for modal controls
        if (closeEditModalBtn) {
            closeEditModalBtn.addEventListener('click', closeEditModal);
        }
        
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeEditModal);
        }
        
        if (editModalOverlay) {
            editModalOverlay.addEventListener('click', function(e) {
                if (e.target === editModalOverlay) {
                    closeEditModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editPrescriptionModal.classList.contains('hidden')) {
                closeEditModal();
            }
        });
    });
</script>