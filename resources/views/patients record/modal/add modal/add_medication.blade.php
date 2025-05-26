

{{-- Add Medication Modal --}}
<div id="addMedicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="medicationModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Medication
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeMedicationModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="addMedicationForm" action="{{ route('medications.store', $patient->PID) }}" method="POST">
                    @csrf
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
                        <input type="text" id="medication" name="medication" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter medication name" required>
                    </div>
                    
                    <!-- Dosage Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Dosage<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="dosage" name="dosage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="e.g. 500mg" required>
                    </div>
                    
                    <!-- Frequency Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Frequency<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="frequency" name="frequency" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="e.g. Twice daily" required>
                    </div>
                    
                    <!-- Duration Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Duration<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="duration" name="duration" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="e.g. 10 days" required>
                    </div>
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="note" name="note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter any additional notes"></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Save
                        </button>
                        <button type="button" id="cancelMedicationBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
        // Get the modal and its elements
        const modal = document.getElementById('addMedicationModal');
        const modalOverlay = document.getElementById('medicationModalOverlay');
        const closeModalBtn = document.getElementById('closeMedicationModalBtn');
        const cancelBtn = document.getElementById('cancelMedicationBtn');
        const medicationForm = document.getElementById('addMedicationForm');
        
        // Modal toggle functions
        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (medicationForm) medicationForm.reset();
            }
        }
        
        // Make closeModal available globally for fetch callbacks
        window.closeAddMedicationModal = closeModal;
        
        // Add event handlers for modal close buttons
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
        
        // Set up trigger for elements with class 'open-medication-modal'
        const addMedicationBtns = document.querySelectorAll('.open-medication-modal');
        if (addMedicationBtns.length > 0) {
            addMedicationBtns.forEach(btn => {
                btn.addEventListener('click', openModal);
            });
        }
        
        // Also connect the addMedicationBtn if it exists
        const addMedicationBtn = document.getElementById('addMedicationBtn');
        if (addMedicationBtn) {
            addMedicationBtn.addEventListener('click', openModal);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form validation and submission
        if (medicationForm) {
            medicationForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent normal form submission
                
                const requiredFields = medicationForm.querySelectorAll('[required]');
                let isValid = true;
                
                // Clear all previous error states
                const errorMessages = medicationForm.querySelectorAll('.error-message');
                errorMessages.forEach(msg => msg.remove());
                
                requiredFields.forEach(field => {
                    field.classList.remove('border-red-500');
                    
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        
                        // Add error message below the field
                        const errorMsg = document.createElement('span');
                        errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                        errorMsg.textContent = 'This field is required';
                        field.parentElement.appendChild(errorMsg);
                    }
                });
                
                // If form is valid, submit via AJAX
                if (isValid) {
                    // Create FormData object
                    const formData = new FormData(medicationForm);
                    
                    // Get form action URL
                    const formAction = medicationForm.getAttribute('action');
                    
                    // Get CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Log form submission (for debugging)
                    console.log("Submitting medication form to:", formAction);
                    
                    // Send data to server
                    fetch(formAction, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log("Response status:", response.status);
                        
                        // Check if we got a successful response
                        if (response.ok) {
                            // Check the content type of the response
                            const contentType = response.headers.get('content-type');
                            
                            if (contentType && contentType.includes('application/json')) {
                                // Response is JSON as expected
                                return response.json();
                            } else {
                                // Response is HTML (likely a redirect)
                                console.log("Server returned HTML instead of JSON (likely a redirect)");
                                
                                // Close the modal
                                closeModal();
                                
                                // Show success message and reload
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Medication added successfully!',
                                    icon: 'success',
                                    confirmButtonColor: '#F91D7C',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                                
                                // Return empty object to skip the next then handler
                                return Promise.reject(new Error('HTML_REDIRECT'));
                            }
                        } else {
                            // Error handling
                            if (response.headers.get('content-type')?.includes('application/json')) {
                                return response.json().then(data => {
                                    throw new Error(data.message || 'Error adding medication');
                                });
                            } else {
                                throw new Error('Server error: ' + response.status);
                            }
                        }
                    })
                    .then(data => {
                        console.log('Success:', data);
                        
                        // Close the modal
                        closeModal();
                        
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Medication added successfully!',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Skip showing error for HTML redirect
                        if (error.message === 'HTML_REDIRECT') {
                            return;
                        }
                        
                        // Show error message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                confirmButtonColor: '#F91D7C'
                            });
                        } else {
                            alert('Error: ' + error.message);
                        }
                    });
                }
            });
        }
        
        // Make the openModal function available globally
        window.openAddMedicationModal = openModal;
    });
</script>