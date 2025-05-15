<!-- Button to open modal -->
<!-- <button id="newVisitBtn" class="bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  New Visit
</button> -->

{{-- New Visit Modal - Responsive for all screen sizes --}}
<div id="newVisitModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-2 sm:px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="visitModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-auto z-10 m-2">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 pb-0">
                <h3 class="text-xl sm:text-2xl font-bold">
                    <span class="text-[#F91D7C]">New</span> Visit
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 p-2" id="closeVisitModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <form id="visitForm">
                    <div class="mb-4">
                        <p class="text-xs sm:text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Visit Date -->
                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                            Visit Date<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="visitDate" name="visitDate" class="w-full pl-10 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                        </div>
                    </div>
                    
                    <!-- Visit Type -->
                    <!-- <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                            Visit Type<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="visitType" name="visitType" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled selected>Select Visit Type</option>
                            <option value="Regular Checkup">Regular Checkup</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Treatment">Treatment</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                    </div> -->
                    
                    <!-- Reason for Visit -->
                    <!-- <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                            Reason for Visit<span class="text-[#F91D7C]">*</span>
                        </label>
                        <textarea id="visitReason" name="visitReason" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Describe the reason for this visit" required></textarea>
                    </div> -->
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-6">
                        <button type="submit" class="w-full py-2 sm:py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white text-sm font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelVisitBtn" class="w-full py-2 sm:py-3 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-md transition-colors">
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
        const newVisitModal = document.getElementById('newVisitModal');
        const visitModalOverlay = document.getElementById('visitModalOverlay');
        const closeVisitModalBtn = document.getElementById('closeVisitModalBtn');
        const cancelVisitBtn = document.getElementById('cancelVisitBtn');
        const visitForm = document.getElementById('visitForm');
        const newVisitBtn = document.getElementById('newVisitBtn');
        
        // Open Modal Function
        function openModal() {
            newVisitModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            newVisitModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (visitForm) {
                visitForm.reset();
            }
        }
        
        // Event Listeners for opening modal
        if (newVisitBtn) {
            newVisitBtn.addEventListener('click', openModal);
        }
        
        // Event Listeners for closing modal
        if (closeVisitModalBtn) {
            closeVisitModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelVisitBtn) {
            cancelVisitBtn.addEventListener('click', closeModal);
        }
        
        if (visitModalOverlay) {
            visitModalOverlay.addEventListener('click', closeModal);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !newVisitModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Make sure body stays fixed on iOS devices when modal is open
        function lockBodyScroll() {
            if (newVisitModal && !newVisitModal.classList.contains('hidden')) {
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            } else {
                document.body.style.position = '';
                document.body.style.width = '';
            }
        }
        
        // Watch for modal visibility changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    lockBodyScroll();
                }
            });
        });
        
        if (newVisitModal) {
            observer.observe(newVisitModal, { attributes: true });
        }
        
        // Form Submission
        if (visitForm) {
            visitForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically send the form data to your server
                // using fetch or axios
                
                // Example of collecting form data
                const formData = new FormData(visitForm);
                const visitData = {};
                
                for (const [key, value] of formData.entries()) {
                    visitData[key] = value;
                }
                
                console.log('Visit Data:', visitData);
                
                // Show success message or redirect
                alert('Visit added successfully!');
                closeModal();
                
                // Optionally refresh the visit list
                // location.reload();
            });
        }
    });
</script>