<!-- {{-- Edit Service Modal --}}
<div id="editServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editModalOverlay"></div>
        
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Service
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6">
                <form id="editServiceForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    {{-- Service Selection Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Service<span class="text-red-500">*</span>
                        </label>
                        <select id="editSelectedService" name="selectedService" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled>Select Service</option>
                            <option value="1">Dandruff and Scalp Treatment - ₱500</option>
                            <option value="2">Wart and Skin Tag Removal - ₱1,200</option>
                            <option value="3">Acne Treatment - ₱2,000</option>
                        </select>
                    </div>
                    
                    {{-- Notes Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="editServiceNotes" name="serviceNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any special instructions or notes">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</textarea>
                    </div>
                    
                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
        const editModalOverlay = document.getElementById('editModalOverlay');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editServiceForm = document.getElementById('editServiceForm');
        
        // Find all edit buttons with the class
        const editServiceButtons = document.querySelectorAll('.edit-service-btn');
        
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
            const requiredFields = editServiceForm.querySelectorAll('[required]');
            
            // Clear all previous error states
            const allFields = editServiceForm.querySelectorAll('input, select, textarea');
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
        function openModal(serviceId, notes) {
            console.log('Opening service edit modal');
            
            // Set form values if data is provided
            if (serviceId) {
                const serviceSelect = document.getElementById('editSelectedService');
                if (serviceSelect) {
                    // Find the option with matching value
                    const option = Array.from(serviceSelect.options).find(opt => opt.value === serviceId);
                    if (option) option.selected = true;
                }
            }
            
            if (notes) {
                document.getElementById('editServiceNotes').value = notes;
            }
            
            // Show the modal
            editServiceModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            editServiceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Clear any validation errors
            const errorMessages = editServiceForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());
            
            const errorFields = editServiceForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }
        
        // Handle form submission
        if (editServiceForm) {
            editServiceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }
                
                // Collect service data
                const serviceData = {
                    serviceId: document.getElementById('editSelectedService').value,
                    notes: document.getElementById('editServiceNotes').value
                };
                
                console.log('Service Data:', serviceData);
                
                // Show success and close modal
                showNotification('Service updated successfully!', 'success');
                closeModal();
                
                // Here you might want to update the UI with the new service data
                // location.reload(); // or update specific UI elements
            });
        }
        
        // Add click event to each edit button
        editServiceButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const serviceId = this.getAttribute('data-service-id');
                const notes = this.getAttribute('data-service-notes');
                
                // Open the modal with this service's data
                openModal(serviceId, notes);
                
                console.log('Opening modal for service ID:', serviceId);
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
            editModalOverlay.addEventListener('click', function(e) {
                if (e.target === editModalOverlay) {
                    closeModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editServiceModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Example function to programmatically open the modal (for testing)
        window.openEditServiceModal = function(serviceId, notes) {
            openModal(serviceId, notes);
        };
    });
</script> -->




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