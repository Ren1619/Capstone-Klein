<!-- Button to open modal -->
<!-- <button id="medicalConditionBtn" class="bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  Medical Condition
</button> -->

{{-- Medical Condition Modal --}}
<div id="medicalConditionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="medicalModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Medical</span> Condition
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeMedicalModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="medicalConditionForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Condition Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Condition<span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" id="condition" name="condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter medical condition" required>
                    </div>
                    
                   
                    <!-- Severity -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Severity
                        </label>
                        <select id="severity" name="severity" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            <option value="" disabled selected>Select Severity</option>
                            <option value="Mild">Mild</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe">Severe</option>
                        </select>
                    </div>
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="notes" name="notes" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Additional notes about the condition"></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelMedicalBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
        const medicalConditionModal = document.getElementById('medicalConditionModal');
        const medicalModalOverlay = document.getElementById('medicalModalOverlay');
        const closeMedicalModalBtn = document.getElementById('closeMedicalModalBtn');
        const cancelMedicalBtn = document.getElementById('cancelMedicalBtn');
        const medicalConditionForm = document.getElementById('medicalConditionForm');
        const medicalConditionBtn = document.getElementById('medicalConditionBtn');
        
        // Open Modal Function
        function openModal() {
            medicalConditionModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            medicalConditionModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (medicalConditionForm) {
                medicalConditionForm.reset();
            }
        }
        
        // Event Listeners for opening modal
        if (medicalConditionBtn) {
            medicalConditionBtn.addEventListener('click', openModal);
        }
        
        // Event Listeners for closing modal
        if (closeMedicalModalBtn) {
            closeMedicalModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelMedicalBtn) {
            cancelMedicalBtn.addEventListener('click', closeModal);
        }
        
        if (medicalModalOverlay) {
            medicalModalOverlay.addEventListener('click', closeModal);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !medicalConditionModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form Submission
        if (medicalConditionForm) {
            medicalConditionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically send the form data to your server
                // using fetch or axios
                
                // Example of collecting form data
                const formData = new FormData(medicalConditionForm);
                const medicalData = {};
                
                for (const [key, value] of formData.entries()) {
                    medicalData[key] = value;
                }
                
                console.log('Medical Condition Data:', medicalData);
                
                // Show success message or redirect
                alert('Medical condition added successfully!');
                closeModal();
                
                // Optionally refresh the medical conditions list
                // location.reload();
            });
        }
    });
</script>