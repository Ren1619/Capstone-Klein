
{{-- Edit Service Modal --}}
<div id="editServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editServiceModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Service
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditServiceModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="editServiceForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" id="edit_visit_services_ID" name="visit_services_ID">
                    <input type="hidden" id="edit_visit_ID" name="visit_ID">

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Service <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_service_ID" name="service_ID" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            <option value="" disabled selected>Select Service</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>

                    <!-- Note -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea id="edit_note" name="note" rows="3" placeholder="Add a note about this service (optional)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditServiceBtn"
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
        const editServiceModal = document.getElementById('editServiceModal');
        const editServiceModalOverlay = document.getElementById('editServiceModalOverlay');
        const closeEditServiceModalBtn = document.getElementById('closeEditServiceModalBtn');
        const cancelEditServiceBtn = document.getElementById('cancelEditServiceBtn');
        const editServiceForm = document.getElementById('editServiceForm');
        
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.edit-service-btn');
        
        console.log('Found edit service buttons:', editButtons.length);
        
        // Function to open edit modal and load service data
        function openEditModal(visitServiceId) {
            console.log('Opening edit modal for visit service ID:', visitServiceId);
            
            // Show loading indicator in the modal
            editServiceModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Fetch service data with detailed error handling
            fetch(`/visit-services/${visitServiceId}/edit`, {
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
                        throw new Error(`Failed to fetch service details (Status: ${response.status})`);
                    });
                }
                return response.json();
            })
            .then(response => {
                if (response.success) {
                    const visitService = response.data;
                    console.log('Visit service data received:', visitService);
                    
                    // Populate form fields
                    document.getElementById('edit_visit_services_ID').value = visitService.visit_services_ID;
                    document.getElementById('edit_visit_ID').value = visitService.visit_ID;
                    document.getElementById('edit_note').value = visitService.note || '';
                    
                    // Get the service ID to select
                    const serviceIdToSelect = visitService.service_ID;
                    console.log('Service ID to select:', serviceIdToSelect);
                    
                    // Get services from the services-data element (same as add service modal)
                    const servicesDataElement = document.getElementById('services-data');
                    if (servicesDataElement && servicesDataElement.dataset.services) {
                        try {
                            const servicesData = JSON.parse(servicesDataElement.dataset.services);
                            populateServicesDropdown(servicesData, serviceIdToSelect);
                        } catch (error) {
                            console.error('Error parsing services data:', error);
                            showError('Failed to parse services data. Please refresh the page and try again.');
                        }
                    } else {
                        console.error('Services data not found in DOM');
                        showError('Services data not found. Please refresh the page and try again.');
                    }
                } else {
                    throw new Error(response.message || 'Failed to load service details');
                }
            })
            .catch(error => {
                console.error('Error loading service:', error);
                
                // Close the modal
                closeEditModal();
                
                // Show error message
                showError(error.message);
            });
        }
        
        // Helper function to show errors
        function showError(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: message,
                    icon: 'error',
                    confirmButtonColor: '#F91D7C'
                });
            } else {
                alert('Error: ' + message);
            }
        }
        
        // Function to populate services dropdown
        function populateServicesDropdown(services, selectedServiceId) {
            console.log('Populating dropdown with', services.length, 'services. Selected ID:', selectedServiceId);
            
            const serviceSelect = document.getElementById('edit_service_ID');
            if (!serviceSelect) {
                console.error('Service select element not found');
                return;
            }
            
            // Clear dropdown
            serviceSelect.innerHTML = '<option value="" disabled>Select Service</option>';
            
            // Add services to dropdown
            services.forEach(service => {
                const option = document.createElement('option');
                option.value = service.service_ID;
                
                // Format price if available
                const price = service.price ? parseFloat(service.price).toFixed(2) : '0.00';
                
                // Set option text
                option.textContent = `${service.name} - ₱${price}`;
                
                // Add option to select
                serviceSelect.appendChild(option);
            });
            
            // Set selected service
            console.log('Setting selected service ID:', selectedServiceId);
            serviceSelect.value = selectedServiceId;
            
            // Verify selection worked
            if (serviceSelect.value != selectedServiceId) {
                console.warn('Failed to select service. Current value:', serviceSelect.value, 'Expected:', selectedServiceId);
                
                // Try manual selection
                for (let i = 0; i < serviceSelect.options.length; i++) {
                    if (serviceSelect.options[i].value == selectedServiceId) {
                        serviceSelect.selectedIndex = i;
                        console.log('Selected using index:', i);
                        break;
                    }
                }
            } else {
                console.log('Service successfully selected');
            }
        }
        
        // Function to close modal
        function closeEditModal() {
            editServiceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset form
            if (editServiceForm) {
                editServiceForm.reset();
            }
        }
        
        // Add click event to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const visitServiceId = this.getAttribute('data-id');
                if (!visitServiceId) {
                    console.error('No data-id attribute found on edit button');
                    return;
                }
                
                console.log('Edit button clicked for ID:', visitServiceId);
                openEditModal(visitServiceId);
            });
        });
        
        // Handle form submission
        if (editServiceForm) {
            editServiceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple validation
                const requiredFields = editServiceForm.querySelectorAll('[required]');
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
                    showError('Please fill out all required fields');
                    return;
                }
                
                // Get visit service ID from hidden field
                const visitServiceId = document.getElementById('edit_visit_services_ID').value;
                
                // Create FormData object
                const formData = new FormData(editServiceForm);
                
                // Log form data for debugging
                console.log('Form data being submitted:');
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }
                
                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Send update request
                fetch(`/visit-services/${visitServiceId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Update response status:', response.status);
                    if (!response.ok) {
                        return response.json().then(data => {
                            console.error('Error response:', data);
                            throw new Error(data.message || 'Failed to update service');
                        });
                    }
                    return response.json();
                })
                .then(response => {
                    console.log('Update success response:', response);
                    
                    if (response.success) {
                        // Close modal first
                        closeEditModal();
                        
                        // Then show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Service updated successfully',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C'
                        }).then(() => {
                            // Reload the page to reflect the changes
                            window.location.reload();
                        });
                    } else {
                        throw new Error(response.message || 'Failed to update service');
                    }
                })
                .catch(error => {
                    console.error('Error updating service:', error);
                    showError(error.message);
                });
            });
        }
        
        // Event listeners for modal controls
        if (closeEditServiceModalBtn) {
            closeEditServiceModalBtn.addEventListener('click', closeEditModal);
        }
        
        if (cancelEditServiceBtn) {
            cancelEditServiceBtn.addEventListener('click', closeEditModal);
        }
        
        if (editServiceModalOverlay) {
            editServiceModalOverlay.addEventListener('click', function(e) {
                if (e.target === editServiceModalOverlay) {
                    closeEditModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editServiceModal.classList.contains('hidden')) {
                closeEditModal();
            }
        });
    });
</script>