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
                    
                    <!-- Service Selection Field -->
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
                    
                    <!-- Doctor/Provider Field -->
                    <!-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Doctor/Provider<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="serviceProvider" name="serviceProvider" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled selected>Select Provider</option>
                            <option value="1">Dr. Maria Santos</option>
                            <option value="2">Dr. Juan Dela Cruz</option>
                            <option value="3">Dr. Ana Reyes</option>
                            <option value="4">Nurse Rodrigo Duterte</option>
                        </select>
                    </div> -->
                    
                    <!-- Date and Time Fields -->
                    <!-- <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Date<span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="serviceDate" name="serviceDate" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Time<span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="time" id="serviceTime" name="serviceTime" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- Payment Status Field -->
                    <!-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Payment Status
                        </label>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="paymentStatus" value="paid" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                <span class="ml-2 text-sm text-gray-700">Paid</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="paymentStatus" value="unpaid" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]" checked>
                                <span class="ml-2 text-sm text-gray-700">Unpaid</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="paymentStatus" value="partial" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                <span class="ml-2 text-sm text-gray-700">Partial</span>
                            </label>
                        </div>
                    </div> -->
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="serviceNotes" name="serviceNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any special instructions or notes"></textarea>
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
</script>