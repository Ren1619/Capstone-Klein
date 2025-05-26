{{-- Edit Visit Modal --}}
<div id="editVisitModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="visitModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-[101]">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Visit
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeVisitModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="visitForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="visitId" name="visit_id">
                    
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Visit Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="visitDate">
                            Visit Date<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="visitDate" name="timestamp"
                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                required>
                        </div>
                    </div>

                    <!-- Weight and Height -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="visitWeight">
                                Weight (kg)<span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="visitWeight" name="weight" step="0.01" placeholder="50.0"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="visitHeight">
                                Height (cm)<span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="visitHeight" name="height" step="0.01" placeholder="165.0"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Blood Pressure -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Blood Pressure<span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="number" name="systolic" id="visitSystolic" placeholder="Systolic" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            </div>
                            <div class="relative">
                                <input type="number" name="diastolic" id="visitDiastolic" placeholder="Diastolic"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelVisitBtn"
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
        // VISIT MODAL
        // Modal Elements
        const editVisitModal = document.getElementById('editVisitModal');
        const visitModalOverlay = document.getElementById('visitModalOverlay');
        const closeVisitModalBtn = document.getElementById('closeVisitModalBtn');
        const cancelVisitBtn = document.getElementById('cancelVisitBtn');
        const visitForm = document.getElementById('visitForm');
        
        // Edit Visit Buttons
        const editVisitBtns = document.querySelectorAll('.edit-visit-btn');
        
        console.log("Visit edit modal setup - Modal exists:", !!editVisitModal);
        console.log("Found edit visit buttons:", editVisitBtns.length);
        
        // Form validation function for visits
        function validateVisitForm() {
            let isValid = true;
            const requiredFields = visitForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = visitForm.querySelectorAll('input, select, textarea');
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
        
        // Open Visit Modal Function
        function openVisitModal(visitId) {
            console.log('Opening visit edit modal for ID:', visitId);
            
            // Show the modal with loading
            editVisitModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Set the visit ID
            document.getElementById('visitId').value = visitId;
            
            // Set form action
            visitForm.action = `/visits/${visitId}`;
            
            // Fetch visit data
            fetch(`/visits/${visitId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log("Fetch response status:", response.status);
                if (!response.ok) {
                    throw new Error(`Server returned ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Received visit data:", data);

                // Populate form fields
                document.getElementById('visitDate').value = data.timestamp.substring(0, 10);
                document.getElementById('visitWeight').value = data.weight;
                document.getElementById('visitHeight').value = data.height;

                // Handle blood pressure format (systolic/diastolic)
                if (data.blood_pressure) {
                    const bpParts = data.blood_pressure.split('/');
                    if (bpParts.length === 2) {
                        document.getElementById('visitSystolic').value = bpParts[0].trim();
                        document.getElementById('visitDiastolic').value = bpParts[1].trim();
                    }
                }
                
                // Focus the first field
                setTimeout(() => {
                    document.getElementById('visitDate').focus();
                }, 100);
            })
            .catch(error => {
                console.error('Error fetching visit data:', error);

                // Fall back to using data attributes if API fails
                const button = document.querySelector(`.edit-visit-btn[data-visit-id="${visitId}"]`);
                if (button) {
                    console.log("Falling back to data attributes from button:", button);

                    const timestamp = button.getAttribute('data-timestamp');
                    const weight = button.getAttribute('data-weight');
                    const height = button.getAttribute('data-height');
                    const bloodPressure = button.getAttribute('data-blood-pressure');

                    console.log("Data attributes found:", { timestamp, weight, height, bloodPressure });

                    // Populate form fields with data attributes
                    if (timestamp) {
                        document.getElementById('visitDate').value = timestamp.substring(0, 10);
                    }
                    document.getElementById('visitWeight').value = weight || '';
                    document.getElementById('visitHeight').value = height || '';

                    // Handle blood pressure
                    if (bloodPressure) {
                        const bpParts = bloodPressure.split('/');
                        if (bpParts.length === 2) {
                            document.getElementById('visitSystolic').value = bpParts[0].trim();
                            document.getElementById('visitDiastolic').value = bpParts[1].trim();
                        }
                    }
                } else {
                    console.error("Could not find button with data-visit-id:", visitId);
                    
                    // Show error if we can't find the data
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load visit data',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    
                    // Close modal
                    closeVisitModal();
                }
            });
        }
        
        // Close Visit Modal Function
        function closeVisitModal() {
            console.log('Closing visit edit modal');
            editVisitModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Clear any validation errors
            const errorMessages = visitForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = visitForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
            
            // Reset form
            visitForm.reset();
        }
        
        // Event Listeners for Visit Modal
        editVisitBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const visitId = this.getAttribute('data-visit-id');
                console.log('Edit button clicked for visit ID:', visitId);
                
                if (!visitId) {
                    console.error('No visit ID found on button');
                    return;
                }
                
                openVisitModal(visitId);
            });
        });
        
        // Setup event listeners for closing the visit modal
        if (closeVisitModalBtn) {
            closeVisitModalBtn.addEventListener('click', closeVisitModal);
        }
        
        if (cancelVisitBtn) {
            cancelVisitBtn.addEventListener('click', closeVisitModal);
        }
        
        if (visitModalOverlay) {
            visitModalOverlay.addEventListener('click', function(e) {
                if (e.target === visitModalOverlay) {
                    closeVisitModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editVisitModal.classList.contains('hidden')) {
                closeVisitModal();
            }
        });
        
        // Form submission for Visits
        if (visitForm) {
            visitForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log("Visit form submission started");
                
                if (!validateVisitForm()) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please check the form for errors',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    return;
                }
                
                // Create FormData object
                const formData = new FormData(visitForm);
                
                // Get the visit ID
                const visitId = document.getElementById('visitId').value;
                console.log("Submitting for visit ID:", visitId);
                
                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Add method spoofing for Laravel
                formData.append('_method', 'PUT');
                
                // Log form data for debugging
                console.log("Form data:");
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                // Send data to server
                fetch(`/visits/${visitId}`, {
                    method: 'POST', // Using POST with _method=PUT for Laravel method spoofing
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log("Submit response status:", response.status);
                    if (!response.ok) {
                        return response.json().then(data => {
                            console.error("Error response data:", data);
                            throw new Error(data.message || 'Error updating visit');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Submit success response:", data);
                    
                    // Close the modal
                    closeVisitModal();
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Visit updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#F91D7C'
                    }).then(() => {
                        // Reload the page to show the updated visit
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'An error occurred while updating the visit.',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                });
            });
        }
    });
</script>