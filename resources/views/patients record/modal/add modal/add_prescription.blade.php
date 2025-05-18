

{{-- Add Prescription Modal --}}
<div id="addPrescriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Prescription
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Use a direct form submission, but capture it with JavaScript -->
                <form id="prescriptionForm">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="visit_ID" id="prescription_visit_ID">
                    <input type="hidden" name="PID" id="prescription_PID">
                    <input type="hidden" name="timestamp" value="{{ now() }}">
                    <!-- Removed medication_ID field -->

                    <!-- Single Medication Entry -->
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <!-- Medication Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Medication Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="medication" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter medication name" required>
                        </div>

                        <!-- Dosage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dosage <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dosage" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 500mg" required>
                        </div>

                        <!-- Frequency -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Frequency <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="frequency" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. Twice daily" required>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="duration" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="e.g. 7 days" required>
                        </div>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Note
                        </label>
                        <textarea name="note" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add doctor's notes here"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const addPrescriptionModal = document.getElementById('addPrescriptionModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const addPrescriptionBtn = document.getElementById('addPrescriptionBtn');
        const prescriptionForm = document.getElementById('prescriptionForm');

        // Get visit ID and PID from the current page context
        // This assumes we're on the visits.show page
        // Use URL parameters if available - more reliable
        const urlParams = new URLSearchParams(window.location.search);
        const visitIdParam = window.location.pathname.split('/').pop(); // Gets last segment of URL
        const patientIdParam = urlParams.get('patient') || urlParams.get('PID');
        
        // Fallback options if URL doesn't have parameters
        const visitId = visitIdParam || '{{ $visit->visit_ID ?? "" }}';
        const patientId = patientIdParam || '{{ $visit->PID ?? $patient->PID ?? "" }}';
        
        console.log('Visit ID:', visitId);
        console.log('Patient ID:', patientId);
        
        // Set the values
        if (document.getElementById('prescription_visit_ID')) {
            document.getElementById('prescription_visit_ID').value = visitId;
        }
        if (document.getElementById('prescription_PID')) {
            document.getElementById('prescription_PID').value = patientId;
        }

        // Open Modal Function
        function openModal() {
            addPrescriptionModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            addPrescriptionModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            prescriptionForm.reset();
            // Reset hidden fields
            if (document.getElementById('prescription_visit_ID')) {
                document.getElementById('prescription_visit_ID').value = visitId;
            }
            if (document.getElementById('prescription_PID')) {
                document.getElementById('prescription_PID').value = patientId;
            }
        }

        // Handle form submission
        if (prescriptionForm) {
            prescriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple validation
                const requiredFields = prescriptionForm.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (!isValid) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please fill out all required fields',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    return;
                }
                
                // Prepare form data
                const formData = new FormData(prescriptionForm);
                
                // Prepare the prescription data
                const prescriptionData = {
                    visit_ID: document.getElementById('prescription_visit_ID').value,
                    medication_name: formData.get('medication'),
                    timestamp: formData.get('timestamp') || new Date().toISOString(),
                    dosage: formData.get('dosage'),
                    frequency: formData.get('frequency'),
                    duration: formData.get('duration'),
                    note: formData.get('note')
                };
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value;
                
                // Submit the prescription directly
                fetch('{{ route("prescriptions.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(prescriptionData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to create prescription');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Close modal first
                    closeModal();

                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Prescription added successfully',
                        icon: 'success',
                        confirmButtonColor: '#F91D7C'
                    }).then((result) => {
                        // Reload the page to reflect the changes
                        window.location.reload();
                    });
                })
                .catch(error => {
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to add prescription',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    console.error('Error:', error);
                });
            });
        }

        // Event Listeners
        if (addPrescriptionBtn) {
            addPrescriptionBtn.addEventListener('click', openModal);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !addPrescriptionModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>