<!-- Reschedule Modal -->
<div id="rescheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Reschedule</span> appointment
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeRescheduleModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="rescheduleForm">
                    @csrf
                    <input type="hidden" id="reschedule_appointment_id" name="appointment_ID">
                    
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            Please select a new date and time for this appointment.
                        </p>
                    </div>
                    
                    <!-- Date and Time -->
                    <div class="mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input 
                                        type="date" 
                                        id="rescheduleDate" 
                                        name="date" 
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        required>
                                </div>
                            </div>
                            <div>
                                <select 
                                    id="rescheduleTime" 
                                    name="time" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    required>
                                    <option value="" disabled selected>Select Time</option>
                                    <option value="09:00:00">9:00 AM</option>
                                    <option value="10:00:00">10:00 AM</option>
                                    <option value="11:00:00">11:00 AM</option>
                                    <option value="13:00:00">1:00 PM</option>
                                    <option value="14:00:00">2:00 PM</option>
                                    <option value="15:00:00">3:00 PM</option>
                                    <option value="16:00:00">4:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Confirm
                        </button>
                        <button type="button" id="cancelRescheduleBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
    // Get the reschedule modal and its elements
    const rescheduleModal = document.getElementById('rescheduleModal');
    const closeRescheduleModalBtn = document.getElementById('closeRescheduleModalBtn');
    const cancelRescheduleBtn = document.getElementById('cancelRescheduleBtn');
    const rescheduleForm = document.getElementById('rescheduleForm');
    
    // Function to open reschedule modal
    function openRescheduleModal() {
        if (rescheduleModal) {
            rescheduleModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Function to close reschedule modal
    function closeRescheduleModal() {
        if (rescheduleModal) {
            rescheduleModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (rescheduleForm) rescheduleForm.reset();
        }
    }
    
    // Add event handlers for modal controls
    if (closeRescheduleModalBtn) closeRescheduleModalBtn.addEventListener('click', closeRescheduleModal);
    if (cancelRescheduleBtn) cancelRescheduleBtn.addEventListener('click', closeRescheduleModal);
    
    // Handle form submission
    if (rescheduleForm) {
        rescheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const appointmentId = document.getElementById('reschedule_appointment_id').value;
            const formData = new FormData(this);
            
            fetch(`/appointments/${appointmentId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Appointment rescheduled successfully!');
                    closeRescheduleModal();
                    
                    // Refresh the view
                    window.location.reload();
                } else {
                    alert('Failed to reschedule appointment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error rescheduling appointment:', error);
                alert('An error occurred while rescheduling the appointment');
            });
        });
    }
    
    // Expose methods to window for external access
    window.rescheduleFunctions = {
        open: openRescheduleModal,
        close: closeRescheduleModal
    };
});
</script>