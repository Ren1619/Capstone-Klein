<!-- View Prescription Modal -->
<div id="viewPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Prescription
                </h3>
                
                <div class="flex items-center gap-4">
                    <!-- Print Button -->
                    <button title="Close" type="button" class="text-gray-700 hover:text-gray-900" id="printPrescriptionBtn" onclick="printPrescription()">
                        <img src="{{ asset('icons/print_icon.svg') }}" alt="Delete">
                    </button>
                    
                    <!-- Close Button -->
                    <button title="Print" type="button" class="text-gray-400 hover:text-gray-500" id="closeViewModalBtn" onclick="closePrescriptionModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>
            </div>
            
            <!-- Modal Body with Prescription -->
            <div class="p-6">
                <div id="prescriptionContent" class="bg-white p-8 w-full max-w-[714px] mx-auto border border-gray-200 rounded-md shadow-sm">
                    <!-- Prescription Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-xl font-bold">PELAEZ DERM CLINIC</h1>
                        <h2 class="text-base font-semibold">RONA GRACE V. VILLASO-PELAEZ, M.D., DPACCDI</h2>
                        <p class="text-sm">Dermatology/General Medicine</p>
                        
                        <div class="text-xs mt-4">
                            <p>09353719162/ 09352070914 - Valencia Branch</p>
                            <p>09752761417 - Malaybalay Branch</p>
                            <p>0905 075 9423/ 09751049664 - Maramag Branch</p>
                        </div>
                    </div>
                    
                    <!-- Patient Info -->
                    <div class="mb-8 grid grid-cols-12 gap-4">
                        <!-- Name -->
                        <div class="col-span-6">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Name</span>
                                    <span class="font-medium text-black">Earl Francis Philip M. Amoy</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date -->
                        <div class="col-span-2">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Date</span>
                                    <span class="font-medium text-black">3/25/25</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Age -->
                        <div class="col-span-2">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Age</span>
                                    <span class="font-medium text-black">22</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sex -->
                        <div class="col-span-2">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Sex</span>
                                    <span class="font-medium text-black">Male</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rx Symbol -->
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 flex items-center">
                            <span class="text-5xl font-bold">Rx</span>
                        </div>
                    </div>
                    
                    <!-- Medication Info -->
                    <div class="mb-6 grid grid-cols-12 gap-4">
                        <!-- Medication -->
                        <div class="col-span-4">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Medication</span>
                                    <span class="font-medium text-black">Lisinopril</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dosage -->
                        <div class="col-span-2">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Dosage</span>
                                    <span class="font-medium text-black">500mg</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Frequency -->
                        <div class="col-span-3">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Frequency</span>
                                    <span class="font-medium text-black">Three times daily</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Duration -->
                        <div class="col-span-3">
                            <div class="border-b border-neutral-500 pb-1">
                                <div class="flex flex-col">
                                    <span class="text-neutral-500 text-sm">Duration</span>
                                    <span class="font-medium text-black">7 days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notes Field -->
                    <div class="mb-12">
                        <div class="mb-2">
                            <span class="font-medium text-neutral-700">Note</span>
                        </div>
                        <div class="border border-neutral-300 p-4 min-h-32 rounded-md bg-gray-50">
                            <p class="text-base text-black leading-relaxed">Take medication with water after meals. Avoid alcohol consumption during treatment. Contact doctor if experiencing dizziness or persistent cough. Follow-up appointment scheduled for April 1, 2025.</p>
                        </div>
                    </div>
                    
                    <!-- Doctor Signature -->
                    <div class="flex justify-end">
                        <div class="text-right">
                            <p class="font-bold text-sm">RONA GRACE V. VILLASO-PELAEZ, M.D</p>
                            <p class="text-xs">PRC LIC. NO. 98076</p>
                            <p class="text-xs">PTR NO. 2024-5-G-107</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const viewPrescriptionModal = document.getElementById('viewPrescriptionModal');
        const viewModalOverlay = document.getElementById('viewModalOverlay');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');
        const printPrescriptionBtn = document.getElementById('printPrescriptionBtn');
        
        // Find all view buttons with the class
        const viewPrescriptionButtons = document.querySelectorAll('.view-prescription-btn');
        
        // Open Modal Function
        function openModal(patientName, patientAge, patientSex, prescriptionDate, medication, dosage, frequency, duration, notes) {
            console.log('Opening prescription view modal');
            
            // Show the modal
            viewPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            console.log('Closing prescription view modal');
            viewPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Create global close function for inline onclick
        window.closePrescriptionModal = function() {
            closeModal();
            console.log('Modal closed via inline onclick handler');
        };
        
        // Print function
        window.printPrescription = function() {
            const printContents = document.getElementById('prescriptionContent').innerHTML;
            const originalContents = document.body.innerHTML;
            
            document.body.innerHTML = `
                <div style="padding: 20px;">
                    ${printContents}
                </div>
            `;
            
            window.print();
            document.body.innerHTML = originalContents;
            
            // Reattach event listeners after printing
            document.addEventListener('DOMContentLoaded', function() {
                const closeViewModalBtn = document.getElementById('closeViewModalBtn');
                if (closeViewModalBtn) {
                    closeViewModalBtn.addEventListener('click', closeModal);
                }
            });
            
            console.log('Prescription printed');
        };
        
        // Add click event to each view button
        viewPrescriptionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const patientName = this.getAttribute('data-patient-name');
                const patientAge = this.getAttribute('data-patient-age');
                const patientSex = this.getAttribute('data-patient-sex');
                const prescriptionDate = this.getAttribute('data-prescription-date');
                const medication = this.getAttribute('data-medication');
                const dosage = this.getAttribute('data-dosage');
                const frequency = this.getAttribute('data-frequency');
                const duration = this.getAttribute('data-duration');
                const notes = this.getAttribute('data-notes');
                
                // Open the modal with this prescription's data
                openModal(patientName, patientAge, patientSex, prescriptionDate, medication, dosage, frequency, duration, notes);
                
                console.log('Opening modal for patient:', patientName);
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
            if (event.key === 'Escape' && !viewPrescriptionModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Example function to programmatically open the modal (for testing)
        window.openViewPrescriptionModal = function(patientName, patientAge, patientSex, prescriptionDate, medication, dosage, frequency, duration, notes) {
            openModal(patientName, patientAge, patientSex, prescriptionDate, medication, dosage, frequency, duration, notes);
        };
    });
</script>