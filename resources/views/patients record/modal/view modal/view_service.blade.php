<!-- {{-- View Service Modal --}}
<div id="viewServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewModalOverlay"></div>
        
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Service
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewModalBtn" onclick="closeServiceModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6">
                {{-- Service Information Display --}}
                <div class="space-y-6">
                    {{-- Service Selection Field --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Service</h4>
                        <p id="viewSelectedService" class="text-base font-medium text-gray-900">Dandruff and Scalp Treatment - ₱500</p>
                    </div>
                    
                    {{-- Notes Field --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="viewServiceNotes" class="text-base text-black whitespace-pre-wrap">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const viewServiceModal = document.getElementById('viewServiceModal');
        const viewModalOverlay = document.getElementById('viewModalOverlay');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');
        
        // Find all view buttons with the class
        const viewServiceButtons = document.querySelectorAll('.view-service-btn');
        
        // Service options mapping (for displaying service name based on ID)
        const serviceOptions = {
            "1": "Dandruff and Scalp Treatment - ₱500",
            "2": "Wart and Skin Tag Removal - ₱1,200",
            "3": "Acne Treatment - ₱2,000"
        };
        
        // Open Modal Function
        function openModal(serviceId, notes) {
            console.log('Opening service view modal');
            
            // Set display values
            if (serviceId) {
                const serviceName = serviceOptions[serviceId] || 'Unknown Service';
                document.getElementById('viewSelectedService').textContent = serviceName;
            }
            
            if (notes) {
                document.getElementById('viewServiceNotes').textContent = notes || 'No notes available';
            }
            
            // Show the modal
            viewServiceModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            console.log('Closing service view modal');
            viewServiceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Create global close function for inline onclick
        window.closeServiceModal = function() {
            closeModal();
            console.log('Modal closed via inline onclick handler');
        };
        
        // Add click event to each view button
        viewServiceButtons.forEach(button => {
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
        if (closeViewModalBtn) {
            closeViewModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }
        
        if (viewModalOverlay) {
            viewModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewServiceModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Example function to programmatically open the modal (for testing)
        window.openViewServiceModal = function(serviceId, notes) {
            openModal(serviceId, notes);
        };
    });
</script> -->



<!-- View Service Modal -->
<div id="viewServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewServiceModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Service
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewServiceModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Service Information Display -->
                <div class="space-y-6">
                    <!-- Service Selection Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Service</h4>
                        <p id="viewSelectedService" class="text-base font-medium text-gray-900">Loading service...</p>
                    </div>

                    <!-- Notes Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="viewServiceNotes" class="text-base text-black whitespace-pre-wrap">Loading notes...</p>
                    </div>
                </div>

                <!-- Close Button -->
                <!-- <div class="mt-8">
                    <button type="button" id="viewServiceCloseBtn"
                        class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                        Close
                    </button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewServiceModal = document.getElementById('viewServiceModal');
        const viewServiceModalOverlay = document.getElementById('viewServiceModalOverlay');
        const closeViewServiceModalBtn = document.getElementById('closeViewServiceModalBtn');
        const viewServiceCloseBtn = document.getElementById('viewServiceCloseBtn');

        // Get all view buttons
        const viewButtons = document.querySelectorAll('.view-service-btn');
        console.log('Found view service buttons:', viewButtons.length);

        // Function to open view modal and load service data
        function openViewModal(visitServiceId) {
            console.log('Opening view modal for visit service ID:', visitServiceId);

            // Show loading state
            viewServiceModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Set loading state for fields
            document.getElementById('viewSelectedService').textContent = 'Loading service...';
            document.getElementById('viewServiceNotes').textContent = 'Loading notes...';

            // Fetch service data using the edit endpoint
            fetch(`/visit-services/${visitServiceId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    console.log('View API Response Status:', response.status);
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

                        // First try to get the service name from the service relationship
                        if (visitService.service) {
                            // Format price
                            const price = visitService.service.price
                                ? parseFloat(visitService.service.price).toFixed(2)
                                : '0.00';

                            // Set service name and price
                            document.getElementById('viewSelectedService').textContent =
                                `${visitService.service.name} - ₱${price}`;
                        } else {
                            // If no service relationship, try to get service name from the services-data element
                            const servicesDataElement = document.getElementById('services-data');

                            if (servicesDataElement && servicesDataElement.dataset.services) {
                                try {
                                    const servicesData = JSON.parse(servicesDataElement.dataset.services);
                                    const service = servicesData.find(s => s.service_ID == visitService.service_ID);

                                    if (service) {
                                        const price = service.price
                                            ? parseFloat(service.price).toFixed(2)
                                            : '0.00';

                                        document.getElementById('viewSelectedService').textContent =
                                            `${service.name} - ₱${price}`;
                                    } else {
                                        document.getElementById('viewSelectedService').textContent =
                                            `Service ID: ${visitService.service_ID}`;
                                    }
                                } catch (e) {
                                    console.error('Error parsing services data:', e);
                                    document.getElementById('viewSelectedService').textContent =
                                        `Service ID: ${visitService.service_ID}`;
                                }
                            } else {
                                document.getElementById('viewSelectedService').textContent =
                                    `Service ID: ${visitService.service_ID}`;
                            }
                        }

                        // Display notes or placeholder
                        document.getElementById('viewServiceNotes').textContent =
                            visitService.note || 'No notes provided';

                    } else {
                        throw new Error(response.message || 'Failed to load service details');
                    }
                })
                .catch(error => {
                    console.error('Error loading service:', error);

                    // Show error in the modal
                    document.getElementById('viewSelectedService').textContent = 'Error loading service';
                    document.getElementById('viewServiceNotes').textContent = error.message;

                    // Optionally show error message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Error',
                            text: error.message,
                            icon: 'error',
                            confirmButtonColor: '#F91D7C'
                        });
                    }
                });
        }

        // Function to close modal
        function closeViewModal() {
            viewServiceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Add click event to each view button
        viewButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const visitServiceId = this.getAttribute('data-id');
                if (!visitServiceId) {
                    console.error('No data-id attribute found on view button');
                    return;
                }

                console.log('View button clicked for ID:', visitServiceId);
                openViewModal(visitServiceId);
            });
        });

        // Event listeners for modal controls
        if (closeViewServiceModalBtn) {
            closeViewServiceModalBtn.addEventListener('click', closeViewModal);
        }

        if (viewServiceCloseBtn) {
            viewServiceCloseBtn.addEventListener('click', closeViewModal);
        }

        if (viewServiceModalOverlay) {
            viewServiceModalOverlay.addEventListener('click', function (e) {
                if (e.target === viewServiceModalOverlay) {
                    closeViewModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !viewServiceModal.classList.contains('hidden')) {
                closeViewModal();
            }
        });

        // Make function globally accessible (for external calls)
        window.openViewServiceModal = function (visitServiceId) {
            openViewModal(visitServiceId);
        };
    });
</script>