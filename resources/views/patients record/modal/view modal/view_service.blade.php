<!-- View Service Modal -->
<div id="viewServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
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
            
            <!-- Modal Body -->
            <div class="p-6">
                <!-- Service Information Display -->
                <div class="space-y-6">
                    <!-- Service Selection Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Service</h4>
                        <p id="viewSelectedService" class="text-base font-medium text-gray-900">Dandruff and Scalp Treatment - ₱500</p>
                    </div>
                    
                    <!-- Notes Field -->
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
</script>