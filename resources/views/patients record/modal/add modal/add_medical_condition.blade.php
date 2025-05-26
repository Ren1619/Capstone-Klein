

{{-- Add Medical Condition Modal --}}
<div id="addConditionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity modal-overlay" id="conditionModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Medical Condition
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500 close-modal-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <form id="addConditionForm" action="{{ route('conditions.store', $patient->PID) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Condition Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medical Condition<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="condition" name="condition"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Enter medical condition" required>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="note" name="note" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Enter any additional notes"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Save
                        </button>
                        <button type="button"
                            class="cancel-btn w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Add Medical Condition Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const addConditionModal = document.getElementById('addConditionModal');
        const modalOverlay = document.getElementById('conditionModalOverlay');
        const closeModalBtns = addConditionModal.querySelectorAll('.close-modal-btn, .cancel-btn');
        const addConditionForm = document.getElementById('addConditionForm');
        const medicalConditionBtn = document.getElementById('medicalConditionBtn');

        // Open Modal Function
        function openModal() {
            addConditionModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            addConditionModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (addConditionForm) {
                addConditionForm.reset();
            }
        }

        // Event Listeners for opening modal
        if (medicalConditionBtn) {
            // Remove any existing event listeners first
            const newBtn = medicalConditionBtn.cloneNode(true);
            medicalConditionBtn.parentNode.replaceChild(newBtn, medicalConditionBtn);

            // Get the new button reference and attach handler
            const refreshedBtn = document.getElementById('medicalConditionBtn');
            if (refreshedBtn) {
                refreshedBtn.addEventListener('click', openModal);
                console.log('Attached click handler to medicalConditionBtn');
            }
        }

        // Add handler to other buttons with open-condition-modal class
        const addConditionBtns = document.querySelectorAll('.open-condition-modal');
        addConditionBtns.forEach(btn => {
            if (btn.id !== 'medicalConditionBtn') { // Skip the main button we already handled
                btn.addEventListener('click', openModal);
            }
        });

        // Event Listeners for closing modal
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function (e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !addConditionModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Form Submission
        if (addConditionForm) {
            addConditionForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Create FormData object
                const formData = new FormData(addConditionForm);

                // Debug - log formData (remove in production)
                console.log("Form data before sending:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // Get the form action URL
                const formAction = addConditionForm.getAttribute('action');
                console.log("Form action URL:", formAction);

                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send data to server
                // Send data to server
                fetch(formAction, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error("Error response:", data);
                                throw new Error(data.message || 'Error adding medical condition');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);

                        // Close the modal
                        closeModal();

                        // Show success message with confirmation button 
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Medical condition added successfully!',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C',
                            confirmButtonText: 'OK'  // Explicitly set the button text
                        }).then((result) => {
                            // Only reload if user clicked a button (not if dismissed via ESC, etc.)
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show error message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                confirmButtonColor: '#F91D7C'

                            });
                        } else {
                            alert('Error: ' + error.message);
                        }
                    });
            });
        }

        // Export the openModal function to make it accessible to other scripts
        window.openMedicalConditionModal = openModal;
    });
</script>