<!-- Appointment Schedule Modal -->
<div id="appointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Set</span> your preferred schedule
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="appointmentForm">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Name Fields -->
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input 
                                    type="text" 
                                    id="firstName" 
                                    name="first_name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    placeholder="First Name*" 
                                    required>
                            </div>
                            <div>
                                <input 
                                    type="text" 
                                    id="lastName" 
                                    name="last_name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    placeholder="Last Name*" 
                                    required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Fields -->
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input 
                                    type="tel" 
                                    id="phoneNumber" 
                                    name="phone_number" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    placeholder="Phone Number*" 
                                    required>
                            </div>
                            <div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    placeholder="Email">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date and Time -->
                    <div class="mb-4">
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
                                        id="appointmentDate" 
                                        name="date" 
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        required>
                                </div>
                            </div>
                            <div>
                                <select 
                                    id="preferredTime" 
                                    name="time" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    required>
                                    <option value="" disabled selected>Preferred Time*</option>
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
                    
                    <!-- Branch and Type -->
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select 
                                    id="preferredBranch" 
                                    name="branch_ID" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    required>
                                    <option value="" disabled selected>Preferred Branch*</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->branch_ID }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select 
                                    id="appointmentType" 
                                    name="appointment_type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                    required>
                                    <option value="" disabled selected>Appointment Type*</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Treatment/Service">Treatment/Service</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Concerns and Referral Code -->
                    <div class="mb-4">
                        <textarea 
                            id="concerns" 
                            name="concern" 
                            rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent mb-4" 
                            placeholder="Concerns"></textarea>
                            
                        <input 
                            type="text" 
                            id="referralCode" 
                            name="referral_code" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                            placeholder="Referral Code (if any)">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and its elements
    const modal = document.getElementById('appointmentModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const appointmentForm = document.getElementById('appointmentForm');
    
    // Function to open modal
    function openModal() {
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Function to close modal
    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (appointmentForm) appointmentForm.reset();
        }
    }
    
    // Add event handlers for modal controls
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    if (modalOverlay) modalOverlay.addEventListener('click', closeModal);
    
    // Set up trigger for addAppointmentBtn
    const addAppointmentBtn = document.getElementById('addAppointmentBtn');
    if (addAppointmentBtn) {
        addAppointmentBtn.addEventListener('click', openModal);
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Handle form submission
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("appointments.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Appointment scheduled successfully!');
                    closeModal();
                    
                    // Refresh the view
                    window.location.reload();
                } else {
                    alert('Failed to schedule appointment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error scheduling appointment:', error);
                alert('An error occurred while scheduling the appointment');
            });
        });
    }
});
</script>