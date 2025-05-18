<!-- {{-- Button to open modal --}}
{{-- <button id="availServiceBtn" class="bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  Avail Service
</button> --}}

{{-- Avail Service Modal --}}
<div id="availServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Avail</span> Service
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6">
                <form id="availServiceForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    {{-- Service Selection Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Service<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="selectedService" name="selectedService" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled selected>Select Service</option>
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
                        <textarea id="serviceNotes" name="serviceNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any special instructions or notes"></textarea>
                    </div>
                    
                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal JavaScript - Directly embedded within the component --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const availServiceModal = document.getElementById('availServiceModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const availServiceForm = document.getElementById('availServiceForm');
        const availServiceBtn = document.getElementById('availServiceBtn');
        
        // Open Modal Function
        function openModal() {
            availServiceModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            availServiceModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (availServiceForm) {
                availServiceForm.reset();
            }
        }
        
        // Event Listeners for opening modal
        if (availServiceBtn) {
            availServiceBtn.addEventListener('click', openModal);
        }
        
        // Event Listeners for closing modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
        
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !availServiceModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form Submission
        if (availServiceForm) {
            availServiceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically send the form data to your server
                // using fetch or axios
                
                // Example of collecting form data
                const formData = new FormData(availServiceForm);
                const serviceData = {};
                
                for (const [key, value] of formData.entries()) {
                    serviceData[key] = value;
                }
                
                console.log('Service Appointment Data:', serviceData);
                
                // Show success message or redirect
                alert('Service appointment added successfully!');
                closeModal();
                
                // Optionally refresh the appointments list
                // location.reload();
            });
        }
        
        // Set minimum date to today
        const dateInput = document.getElementById('serviceDate');
        if (dateInput) {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            dateInput.min = `${year}-${month}-${day}`;
        }
    });
</script> -->




<!-- Button to open modal -->
<!-- <button id="availServiceBtn" class="bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  Avail Service
</button> -->

{{-- Avail Service Modal --}}
<div id="availServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Avail</span> Service
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="availServiceForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Hidden Visit ID Field -->
                    <input type="hidden" id="visit_ID" name="visit_ID" value="">
                    
                    <!-- Service Selection Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Service<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="service_ID" name="service_ID" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled selected>Select Service</option>
                            <!-- Services will be populated by JavaScript -->
                        </select>
                    </div>
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="note" name="note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any special instructions or notes"></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const availServiceModal = document.getElementById('availServiceModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const availServiceForm = document.getElementById('availServiceForm');
        const availServiceBtn = document.getElementById('availServiceBtn');
        const serviceSelect = document.getElementById('service_ID');
        
        // Fetch all services when the page loads
        fetchServices();
        
        // Function to fetch services from the backend
        function fetchServices() {
            fetch('/api/services')
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    serviceSelect.innerHTML = '<option value="" disabled selected>Select Service</option>';
                    
                    // Populate dropdown with services
                    data.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.service_ID;
                        option.textContent = `${service.name} - ₱${parseFloat(service.price).toFixed(2)}`;
                        serviceSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching services:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load services. Please try again.',
                    });
                });
        }
        
        // Set visit ID dynamically (you'll need to implement this based on your page structure)
        function setVisitId(visitId) {
            document.getElementById('visit_ID').value = visitId;
        }
        
        // Open Modal Function
        function openModal(visitId) {
            // Set the visit ID for the form
            setVisitId(visitId);
            
            availServiceModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            availServiceModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (availServiceForm) {
                availServiceForm.reset();
            }
        }
        
        // Event Listeners for opening modal
        if (availServiceBtn) {
            availServiceBtn.addEventListener('click', function() {
                // Get the visit ID from data attribute or another source
                const visitId = this.dataset.visitId || '';
                openModal(visitId);
            });
        }
        
        // Make modal opening function available globally
        window.openAvailServiceModal = function(visitId) {
            openModal(visitId);
        };
        
        // Event Listeners for closing modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
        
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !availServiceModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form Submission
        if (availServiceForm) {
            availServiceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(availServiceForm);
                const visitServiceData = Object.fromEntries(formData.entries());
                
                // Send AJAX request to store the visit service
                fetch('/patient/visit-services', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(visitServiceData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Service added successfully!',
                            confirmButtonColor: '#F91D7C'
                        });
                        
                        // Close modal
                        closeModal();
                        
                        // Refresh the services list on the page if needed
                        if (typeof updateVisitServicesList === 'function') {
                            updateVisitServicesList(data.services);
                        } else {
                            // Fallback to page reload if updateVisitServicesList isn't defined
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to add service',
                            confirmButtonColor: '#F91D7C'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request',
                        confirmButtonColor: '#F91D7C'
                    });
                });
            });
        }
    });
</script> -->