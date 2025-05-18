

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