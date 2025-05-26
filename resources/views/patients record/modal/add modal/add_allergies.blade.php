
{{-- Add Allergy Modal --}}
<div id="addAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="allergyModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Allergy
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeAllergyModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="addAllergyForm" action="{{ route('allergies.store', $patient->PID) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Allergy Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Allergy<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="allergies" name="allergies" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter allergy" required>
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
                        <button type="button" id="cancelAllergyBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
        const modal = document.getElementById('addAllergyModal');
        const modalOverlay = document.getElementById('allergyModalOverlay');
        const closeModalBtn = document.getElementById('closeAllergyModalBtn');
        const cancelBtn = document.getElementById('cancelAllergyBtn');
        const allergyForm = document.getElementById('addAllergyForm');
        
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
                if (allergyForm) allergyForm.reset();
            }
        }
        
        // Make closeModal available globally for fetch callbacks
        window.closeAddAllergyModal = closeModal;
        
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
        
        // Connect the addAllergiesBtn
        const addAllergiesBtn = document.getElementById('addAllergiesBtn');
        if (addAllergiesBtn) {
            addAllergiesBtn.addEventListener('click', openModal);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form validation and submission
        if (allergyForm) {
            allergyForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent normal form submission
                
                // Basic client-side validation
                const requiredFields = allergyForm.querySelectorAll('[required]');
                let isValid = true;
                
                // Clear all previous error states
                const errorMessages = allergyForm.querySelectorAll('.error-message');
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
                    const formData = new FormData(allergyForm);
                    
                    // Get form action URL
                    const formAction = allergyForm.getAttribute('action');
                    
                    // Get CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
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
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error("Error response:", data);
                                throw new Error(data.message || 'Error adding allergy');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                        
                        // Close the modal
                        window.closeAddAllergyModal();
                        
                        // Show success message with confirmation button
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Allergy added successfully!',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Reload page when user clicks OK or closes the alert
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
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
        window.openAddAllergyModal = openModal;
    });
</script>