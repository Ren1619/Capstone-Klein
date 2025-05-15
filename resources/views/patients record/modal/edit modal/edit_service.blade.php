<!-- Edit Service Modal -->
<div id="editServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
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
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="editServiceForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Service Selection Field -->
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
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="editServiceNotes" name="serviceNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any special instructions or notes">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</textarea>
                    </div>
                    
                    <!-- Button Actions -->
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
</script>