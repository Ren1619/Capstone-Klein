{{-- View Medication Modal --}}
<div id="viewMedicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewMedicationModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Medication
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewMedicationBtn" onclick="closeMedicationModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Medication Information Display -->
                <div class="space-y-6">
                    <!-- Medication Name and Dosage -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Medication</h4>
                            <p id="viewMedication" class="text-base font-medium text-gray-900">Lisinopril</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Dosage</h4>
                            <p id="viewDosage" class="text-base font-medium text-gray-900">10mg</p>
                        </div>
                    </div>

                    <!-- Frequency and Duration -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Frequency</h4>
                            <p id="viewFrequency" class="text-base font-medium text-gray-900">Once daily</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Duration</h4>
                            <p id="viewDuration" class="text-base font-medium text-gray-900">Ongoing</p>
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Start Date</h4>
                        <p id="viewStartDate" class="text-base font-medium text-gray-900">2025-01-15</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="viewNotes" class="text-base text-black whitespace-pre-wrap">Take with food in the morning. Monitor for side effects such as dizziness or cough.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewMedicationModal = document.getElementById('viewMedicationModal');
        const viewMedicationModalOverlay = document.getElementById('viewMedicationModalOverlay');
        const closeViewMedicationBtn = document.getElementById('closeViewMedicationBtn');

        // Find all view buttons with the class
        const viewMedicationButtons = document.querySelectorAll('.view-medication-btn');

        // Open Modal Function
        function openModal(medication, dosage, frequency, duration, startDate, notes) {
            console.log('Opening medication view modal');

            // Set display values
            if (medication) document.getElementById('viewMedication').textContent = medication || 'N/A';
            if (dosage) document.getElementById('viewDosage').textContent = dosage || 'N/A';
            if (frequency) document.getElementById('viewFrequency').textContent = frequency || 'N/A';
            if (duration) document.getElementById('viewDuration').textContent = duration || 'N/A';
            if (startDate) document.getElementById('viewStartDate').textContent = startDate || 'N/A';
            if (notes) document.getElementById('viewNotes').textContent = notes || 'No notes available';

            // Show the modal
            viewMedicationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing medication view modal');
            viewMedicationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Create global close function for inline onclick
        window.closeMedicationModal = function() {
            closeModal();
            console.log('Modal closed via inline onclick handler');
        };

        // Add click event to each view button
        viewMedicationButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Get data attributes from the button
                const medication = this.getAttribute('data-medication');
                const dosage = this.getAttribute('data-dosage');
                const frequency = this.getAttribute('data-frequency');
                const duration = this.getAttribute('data-duration');
                const startDate = this.getAttribute('data-start-date');
                const notes = this.getAttribute('data-notes');

                // Open the modal with this medication's data
                openModal(medication, dosage, frequency, duration, startDate, notes);

                console.log('Opening modal for medication:', medication);
            });
        });

        // Event Listeners for modal controls
        if (closeViewMedicationBtn) {
            closeViewMedicationBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (viewMedicationModalOverlay) {
            viewMedicationModalOverlay.addEventListener('click', function (e) {
                if (e.target === viewMedicationModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !viewMedicationModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openViewMedicationModal = function (medication, dosage, frequency, duration, startDate, notes) {
            openModal(medication, dosage, frequency, duration, startDate, notes);
        };
    });
</script>