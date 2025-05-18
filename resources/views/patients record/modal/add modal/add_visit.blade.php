
<!-- Add Visit Modal -->
<div id="add-visit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-2 sm:px-4">
        <!-- Modal Background Overlay -->
        <div class="modal-overlay fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            id="add-visit-modal-overlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-auto z-10 m-2">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 pb-0">
                <h3 class="text-xl sm:text-2xl font-bold">
                    <span class="text-[#F91D7C]">New</span> Visit
                </h3>
                <button type="button" class="close-modal-btn text-gray-400 hover:text-gray-500 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <form id="add-visit-form" method="POST" action="/patients/{{ $patient->PID }}/visits">
                    @csrf

                    <div class="mb-4">
                        <p class="text-xs sm:text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Visit Date -->
                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="visit-date">
                            Visit Date<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="visit-date" name="timestamp"
                                class="w-full pl-10 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                required>
                        </div>
                    </div>

                    <!-- Weight and Height -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="visit-weight">
                                Weight (kg)<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="number" id="visit-weight" name="weight" step="0.01" placeholder="50.0" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">

                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="visit-height">
                                Height (cm)<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="number" id="visit-height" name="height" step="0.01" placeholder="165.0"
                                required
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">


                        </div>
                    </div>

                    <!-- Blood Pressure -->
                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                            Blood Pressure<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="number" name="systolic" placeholder="Systolic" required
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            </div>
                            <div class="relative">
                                <input type="number" name="diastolic" placeholder="Diastolic" required
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                            </div>
                        </div>
                    </div>



                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-2 sm:py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white text-sm font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button"
                            class="cancel-btn w-full py-2 sm:py-3 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Add Visit Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const addVisitModal = document.getElementById('add-visit-modal');
        const modalOverlay = document.getElementById('add-visit-modal-overlay');
        const closeModalBtns = addVisitModal.querySelectorAll('.close-modal-btn, .cancel-btn');
        const addVisitForm = document.getElementById('add-visit-form');
        const newVisitBtn = document.getElementById('newVisitBtn');

        // Open Modal Function
        function openModal() {
            addVisitModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            addVisitModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (addVisitForm) {
                addVisitForm.reset();
            }
        }

        // Event Listeners for opening modal
        if (newVisitBtn) {
            newVisitBtn.addEventListener('click', openModal);
        }

        // Event Listeners for closing modal
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !addVisitModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Form Submission
        // Form Submission
        if (addVisitForm) {
            addVisitForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Create FormData object
                const formData = new FormData(addVisitForm);

                // Debug - log formData (remove in production)
                console.log("Form data before sending:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // Get the form action URL (which includes the patient ID)
                const formAction = addVisitForm.getAttribute('action');
                console.log("Form action URL:", formAction);

                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Format blood pressure correctly (DON'T remove original fields yet)
                const systolic = formData.get('systolic');
                const diastolic = formData.get('diastolic');

                if (systolic && diastolic) {
                    formData.append('blood_pressure', `${systolic}/${diastolic}`);
                }

                // Send data to server
                fetch(formAction, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                        // Don't set Content-Type header to allow browser to set it with boundary
                    },
                    body: formData // Keep FormData as is
                })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error("Error response:", data);
                                throw new Error(data.message || 'Error adding visit');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Success response:", data);
                        // Show success message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Visit added successfully',
                                icon: 'success',
                                confirmButtonColor: '#F91D7C'
                            }).then(() => {
                                // Reload the page to show the new visit
                                window.location.reload();
                            });
                        } else {
                            alert('Visit added successfully!');
                            window.location.reload();
                        }

                        // Close the modal
                        closeModal();
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
    });
</script>