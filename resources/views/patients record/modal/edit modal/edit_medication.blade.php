

{{-- Edit Medication Modal - Following Medical Condition Pattern --}}
<div id="editMedicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="medicationModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Medication
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeMedicationModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="medicationForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Medication Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medication<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="medicationName" name="medication"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Enter medication name" required>
                    </div>

                    <!-- Dosage Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Dosage<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="medicationDosage" name="dosage"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="e.g. 500mg" required>
                    </div>

                    <!-- Frequency Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Frequency<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="medicationFrequency" name="frequency"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="e.g. Twice daily" required>
                    </div>

                    <!-- Duration Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Duration<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="medicationDuration" name="duration"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="e.g. 10 days" required>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="medicationNote" name="note" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Enter any additional notes"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelMedicationBtn"
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
        const medicationModalOverlay = document.getElementById('medicationModalOverlay');
        const closeMedicationModalBtn = document.getElementById('closeMedicationModalBtn');
        const cancelMedicationBtn = document.getElementById('cancelMedicationBtn');
        const medicationForm = document.getElementById('medicationForm');

        // Button to open modal
        const editMedicationBtns = document.querySelectorAll('.edit-medication-btn');

        console.log('Medication edit modal setup - Modal exists:', !!editMedicationModal);
        console.log('Found edit medication buttons:', editMedicationBtns.length);

        // Form validation function
        function validateForm() {
            let isValid = true;
            const requiredFields = medicationForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = medicationForm.querySelectorAll('input, select, textarea');
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
        if (medicationForm) {
            medicationForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please check the form for errors',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    return;
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                 document.querySelector('input[name="_token"]')?.value;
                
                // Create FormData object
                const formData = new FormData(medicationForm);
                
                // Send form data via AJAX
                fetch(medicationForm.action, {
                    method: 'POST', // Using POST with _method=PUT for Laravel method spoofing
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Close modal
                    closeModal();
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Medication updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#F91D7C'
                    }).then(() => {
                        // Reload the page to show updated data
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                });
            });
        }

        // Open Modal Function - EXACTLY matching the medical condition pattern
        function openModal(medicationId) {
            console.log('Opening medication edit modal for ID:', medicationId);
            
            // Fetch medication data via AJAX
            fetch(`/medications/${medicationId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('medicationName').value = data.medication || '';
                document.getElementById('medicationDosage').value = data.dosage || '';
                document.getElementById('medicationFrequency').value = data.frequency || '';
                document.getElementById('medicationDuration').value = data.duration || '';
                document.getElementById('medicationNote').value = data.note || '';
                
                // Set form action
                medicationForm.action = `/medications/${medicationId}`;
                
                // Show modal
                editMedicationModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Focus the first input field
                setTimeout(() => {
                    document.getElementById('medicationName').focus();
                }, 100);
            })
            .catch(error => {
                console.error('Error fetching medication data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load medication data',
                    icon: 'error',
                    confirmButtonColor: '#F91D7C'
                });
            });
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing medication edit modal');
            editMedicationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = medicationForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = medicationForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
            
            // Reset form
            medicationForm.reset();
        }

        // Event Listeners
        editMedicationBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const medicationId = this.getAttribute('data-medication-id');
                openModal(medicationId);
            });
        });

        if (closeMedicationModalBtn) {
            closeMedicationModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (cancelMedicationBtn) {
            cancelMedicationBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (medicationModalOverlay) {
            medicationModalOverlay.addEventListener('click', function (e) {
                if (e.target === medicationModalOverlay) {
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

        // Add a direct function for testing
        window.openMedicationModal = function(medicationId) {
            openModal(medicationId);
        };
    });
</script>