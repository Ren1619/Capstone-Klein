<!-- {{-- Add Prescription Modal --}}
<div id="addPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <form id="prescriptionForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    {{-- Hidden fields to store patient data --}}
                    <input type="hidden" id="patientName" name="patientName" value="Earl Francis Philip">
                    <input type="hidden" id="patientAge" name="patientAge" value="21">
                    <input type="hidden" id="patientSex" name="patientSex" value="male">

                    {{-- Medication Section --}}
                    <div class="mb-4">
                        {{-- Add Medication Button --}}
                        <div class="flex justify-end mb-3">
                            <button type="button" id="addMedicationBtn"
                                class="text-[#F91D7C] flex items-center text-sm hover:text-[#e01a70] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        {{-- Column Headers - Rebalanced for better duration visibility --}}
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

                        {{-- Scrollable Medications List --}}
                        <div class="max-h-64 overflow-y-auto pr-1 mb-4 custom-scrollbar">
                            <div id="medicationsList" class="space-y-2">
                                {{-- Initial medication row will be added by JavaScript --}}
                            </div>
                        </div>
                    </div>

                    {{-- Notes Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea id="prescriptionNotes" name="prescriptionNotes" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add doctor's notes here"></textarea>
                    </div>

                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Medication Row Template (hidden) --}}
<template id="medicationRowTemplate">
    <div class="medication-row grid grid-cols-12 gap-3 items-center p-2 rounded-lg  hover:bg-gray-50">
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

</template>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const addPrescriptionModal = document.getElementById('addPrescriptionModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const prescriptionForm = document.getElementById('prescriptionForm');
        const addPrescriptionBtn = document.getElementById('addPrescriptionBtn');

        // Medication Elements
        const medicationsList = document.getElementById('medicationsList');
        const addMedicationBtn = document.getElementById('addMedicationBtn');
        const medicationRowTemplate = document.getElementById('medicationRowTemplate');

        // Add custom scrollbar styles
        const style = document.createElement('style');
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

        // Function to add new medication row
        function addMedicationRow() {
            const clone = document.importNode(medicationRowTemplate.content, true);
            const removeBtn = clone.querySelector('.remove-medication');

            // Set up removal functionality
            removeBtn.addEventListener('click', function () {
                const allRows = document.querySelectorAll('.medication-row');
                if (allRows.length > 1) {
                    this.closest('.medication-row').remove();
                } else {
                    showNotification('At least one medication is required', 'error');
                }
            });

            // Add the new row to the list
            medicationsList.appendChild(clone);

            // Set placeholder values for better UX
            const newRow = medicationsList.lastElementChild;
            const durationField = newRow.querySelector('input[name="duration[]"]');

            // Focus on the new medication field
            setTimeout(() => {
                const medicationField = newRow.querySelector('input[name="medication[]"]');
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

        // Form validation function with improved feedback
        function validateForm() {
            let isValid = true;
            const requiredFields = prescriptionForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = prescriptionForm.querySelectorAll('input, select, textarea');
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
        if (prescriptionForm) {
            prescriptionForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please fill out all required fields', 'error');
                    return;
                }

                // Collect medication data
                const medications = [];
                const medicationRows = document.querySelectorAll('.medication-row');

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
                    patientName: document.getElementById('patientName').value,
                    patientAge: document.getElementById('patientAge').value,
                    patientSex: document.getElementById('patientSex').value,
                    notes: document.getElementById('prescriptionNotes').value,
                    medications
                };

                // Here you would typically send the data to the server
                console.log('Prescription Data:', prescriptionData);

                // Show success and close modal
                showNotification('Prescription added successfully!', 'success');
                closeModal();
            });
        }

        // Open Modal Function
        function openModal() {
            addPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = prescriptionForm.querySelector('input:not([type="hidden"])');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing modal...');
            // Make sure we have a reference to the modal
            const modal = document.getElementById('addPrescriptionModal');
            if (modal) {
                modal.classList.add('hidden');
                console.log('Modal hidden class added');
            } else {
                console.error('Modal element not found');
            }

            document.body.style.overflow = 'auto';

            // Reset form if it exists
            if (prescriptionForm) {
                prescriptionForm.reset();
                console.log('Form reset');
            }

            // Remove all medication rows
            if (medicationsList) {
                while (medicationsList.firstChild) {
                    medicationsList.removeChild(medicationsList.firstChild);
                }
                console.log('Medication rows removed');

                // Add one fresh row
                addMedicationRow();
                console.log('Fresh row added');
            }
        }

        // Event Listeners
        if (addPrescriptionBtn) {
            addPrescriptionBtn.addEventListener('click', openModal);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via Cancel button');
            });
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === modalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !addPrescriptionModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Add initial medication row
        addMedicationRow();

        // Set up the "Add Medication" button
        if (addMedicationBtn) {
            addMedicationBtn.addEventListener('click', addMedicationRow);
        }
    });
</script> -->


{{-- Add Prescription Modal --}}
<div id="addPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Use a direct form submission, but capture it with JavaScript -->
                <form id="prescriptionForm">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="visit_ID" id="prescription_visit_ID">
                    <input type="hidden" name="PID" id="prescription_PID">
                    <input type="hidden" name="timestamp" value="{{ now() }}">
                    <!-- Removed medication_ID field -->

                    <!-- Single Medication Entry -->
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <!-- Medication Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Medication Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="medication" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter medication name" required>
                        </div>

                        <!-- Dosage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dosage <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dosage" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 500mg" required>
                        </div>

                        <!-- Frequency -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Frequency <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="frequency" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. Twice daily" required>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="duration" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 7 days" required>
                        </div>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea name="note" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add doctor's notes here"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const addPrescriptionModal = document.getElementById('addPrescriptionModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const addPrescriptionBtn = document.getElementById('addPrescriptionBtn');
        const prescriptionForm = document.getElementById('prescriptionForm');

        // Get visit ID and PID from the current page context
        // This assumes we're on the visits.show page
        // Use URL parameters if available - more reliable
        const urlParams = new URLSearchParams(window.location.search);
        const visitIdParam = window.location.pathname.split('/').pop(); // Gets last segment of URL
        const patientIdParam = urlParams.get('patient') || urlParams.get('PID');
        
        // Fallback options if URL doesn't have parameters
        const visitId = visitIdParam || '{{ $visit->visit_ID ?? "" }}';
        const patientId = patientIdParam || '{{ $visit->PID ?? $patient->PID ?? "" }}';
        
        console.log('Visit ID:', visitId);
        console.log('Patient ID:', patientId);
        
        // Set the values
        if (document.getElementById('prescription_visit_ID')) {
            document.getElementById('prescription_visit_ID').value = visitId;
        }
        if (document.getElementById('prescription_PID')) {
            document.getElementById('prescription_PID').value = patientId;
        }

        // Open Modal Function
        function openModal() {
            addPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            addPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            prescriptionForm.reset();
            // Reset hidden fields
            if (document.getElementById('prescription_visit_ID')) {
                document.getElementById('prescription_visit_ID').value = visitId;
            }
            if (document.getElementById('prescription_PID')) {
                document.getElementById('prescription_PID').value = patientId;
            }
        }

        // Handle form submission
        if (prescriptionForm) {
            prescriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple validation
                const requiredFields = prescriptionForm.querySelectorAll('[required]');
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
                
                // Prepare form data
                const formData = new FormData(prescriptionForm);
                
                // Prepare the prescription data
                const prescriptionData = {
                    visit_ID: document.getElementById('prescription_visit_ID').value,
                    medication_name: formData.get('medication'),
                    timestamp: formData.get('timestamp') || new Date().toISOString(),
                    dosage: formData.get('dosage'),
                    frequency: formData.get('frequency'),
                    duration: formData.get('duration'),
                    note: formData.get('note')
                };
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value;
                
                // Submit the prescription directly
                fetch('{{ route("prescriptions.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(prescriptionData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to create prescription');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Close modal first
                    closeModal();

                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Prescription added successfully',
                        icon: 'success',
                        confirmButtonColor: '#F91D7C'
                    }).then((result) => {
                        // Reload the page to reflect the changes
                        window.location.reload();
                    });
                })
                .catch(error => {
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to add prescription',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    console.error('Error:', error);
                });
            });
        }

        // Event Listeners
        if (addPrescriptionBtn) {
            addPrescriptionBtn.addEventListener('click', openModal);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !addPrescriptionModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>