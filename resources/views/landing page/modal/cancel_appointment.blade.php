<!-- Button to open modal -->
<!-- <button class="cancelAppointmentBtn bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  Cancel Appointment
</button> -->

{{-- Cancel Appointment Modal --}}
<div id="cancelAppointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Can't</span> make it?
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="cancelAppointmentForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-[#F91D7C]">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Appointment Code Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Appointment code<span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" id="appointmentCode" name="appointmentCode" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                    </div>
                    
                    <!-- Phone Number and Email Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                        </div>
                    </div>
                    
                    <!-- Reason Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Reason
                        </label>
                        <textarea id="reason" name="reason" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Confirm
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
        const cancelAppointmentModal = document.getElementById('cancelAppointmentModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelAppointmentForm = document.getElementById('cancelAppointmentForm');
        const cancelAppointmentBtns = document.querySelectorAll('.cancelAppointmentBtn');
        
        // Open Modal Function
        function openModal() {
            cancelAppointmentModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            cancelAppointmentModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (cancelAppointmentForm) {
                cancelAppointmentForm.reset();
            }
        }
        
        // Event Listeners for opening modal
        if (cancelAppointmentBtns.length > 0) {
            cancelAppointmentBtns.forEach(btn => {
                btn.addEventListener('click', openModal);
            });
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
            if (event.key === 'Escape' && !cancelAppointmentModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form Submission
        if (cancelAppointmentForm) {
            cancelAppointmentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically send the form data to your server
                // using fetch or axios
                
                // Example of collecting form data
                const formData = new FormData(cancelAppointmentForm);
                const appointmentData = {};
                
                for (const [key, value] of formData.entries()) {
                    appointmentData[key] = value;
                }
                
                console.log('Cancellation Data:', appointmentData);
                
                // Show success message or redirect
                alert('Appointment cancelled successfully!');
                closeModal();
            });
        }
    });
</script>