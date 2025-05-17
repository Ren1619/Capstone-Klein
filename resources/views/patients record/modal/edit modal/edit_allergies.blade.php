<!-- {{-- Edit Allergies Modal --}}
<div id="editAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto"> 
    <div class="flex items-center justify-center min-h-screen px-4"> 
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="allergyModalOverlay"></div>

        {{-- Modal Content - Changed to max-w-md to match add modal --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10"> 
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Allergy
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeAllergyModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <form id="allergyForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    {{-- Allergy Information Form --}}
                    <div class="space-y-4">
                        {{-- Allergy --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Allergy<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="allergyName" name="allergyName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter allergy name" required value="Peanuts">
                        </div>

                        {{-- Reaction Severity --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Reaction Severity
                            </label>
                            <select id="allergySeverity" name="allergySeverity"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="Mild">Mild</option>
                                <option value="Moderate" selected>Moderate</option>
                                <option value="Severe">Severe</option>
                                <option value="Life-threatening">Life-threatening</option>
                            </select>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea id="allergyNotes" name="allergyNotes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Additional notes">Patient experiences hives and difficulty breathing when exposed to peanuts. Patient carries an EpiPen.</textarea>
                        </div>
                    </div>

                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelAllergyBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const editAllergyModal = document.getElementById('editAllergyModal');
        const allergyModalOverlay = document.getElementById('allergyModalOverlay');
        const closeAllergyModalBtn = document.getElementById('closeAllergyModalBtn');
        const cancelAllergyBtn = document.getElementById('cancelAllergyBtn');
        const allergyForm = document.getElementById('allergyForm');

        // Find all edit buttons with the class
        const editButtons = document.querySelectorAll('.edit-allergy-btn');

        // Add custom scrollbar styles if not already added
        if (!document.getElementById('customScrollbarStyles')) {
            const style = document.createElement('style');
            style.id = 'customScrollbarStyles';
            style.textContent = `
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #ddd;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #ccc;
            }
            `;
            document.head.appendChild(style);
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            // Toast notification implementation
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'
                } text-white`;
            toast.textContent = message;
            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => document.body.removeChild(toast), 500);
            }, 3000);
        }

        // Form validation function
        function validateForm() {
            let isValid = true;
            const requiredFields = allergyForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = allergyForm.querySelectorAll('input, select, textarea');
            allFields.forEach(field => {
                field.classList.remove('border-red-500');
                const errorMsg = field.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            });

            // Check each required field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');

                    // Add error message below the field
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                    errorMsg.textContent = 'This field is required';
                    field.parentElement.appendChild(errorMsg);

                    isValid = false;

                    // Focus the first invalid field
                    if (isValid === false) {
                        setTimeout(() => field.focus(), 100);
                        isValid = null; // Prevent focusing multiple fields
                    }
                }
            });

            return isValid === true;
        }

        // Handle form submission
        if (allergyForm) {
            allergyForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect allergy data
                const allergyData = {
                    name: document.getElementById('allergyName').value,
                    severity: document.getElementById('allergySeverity').value,
                    notes: document.getElementById('allergyNotes').value
                };

                // Here you would typically send the data to the server
                console.log('Allergy Data:', allergyData);

                // Show success and close modal
                showNotification('Allergy updated successfully!', 'success');
                closeModal();

                // Here you might want to update the UI with the new allergy data
                // This is just a placeholder for demonstration
                updateAllergyDisplay(allergyData);
            });
        }

        // Function to update the UI with new allergy data
        function updateAllergyDisplay(allergyData) {
            // This function would update the allergy information on the page
            // For demonstration purposes we'll just log it
            console.log('Updating UI with:', allergyData);

            // In a real implementation, you'd select the elements and update their content
            // Example:
            // document.querySelector('.allergy-name').textContent = allergyData.name;
            // document.querySelector('.allergy-severity').textContent = allergyData.severity;
            // etc.
        }

        // Open Modal Function
        function openModal(allergyName, allergySeverity, allergyNotes) {
            console.log('Opening allergy edit modal');
            
            // If data is provided, set form values
            if (allergyName) {
                document.getElementById('allergyName').value = allergyName || '';
            }
            
            if (allergySeverity) {
                const severitySelect = document.getElementById('allergySeverity');
                if (severitySelect) {
                    // Find the option with matching value
                    const option = Array.from(severitySelect.options).find(opt => opt.value === allergySeverity);
                    if (option) {
                        option.selected = true;
                    }
                }
            }
            
            if (allergyNotes) {
                document.getElementById('allergyNotes').value = allergyNotes || '';
            }
            
            // Show the modal
            editAllergyModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = allergyForm.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing allergy edit modal');
            editAllergyModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = allergyForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = allergyForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Add click event to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const allergyName = this.getAttribute('data-allergy-name');
                const allergySeverity = this.getAttribute('data-allergy-severity');
                const allergyNotes = this.getAttribute('data-allergy-notes');
                
                // Open the modal with this allergy's data
                openModal(allergyName, allergySeverity, allergyNotes);
                
                console.log('Opening modal for allergy:', allergyName);
            });
        });

        // Event Listeners for modal controls
        if (closeAllergyModalBtn) {
            closeAllergyModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (cancelAllergyBtn) {
            cancelAllergyBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via Cancel button');
            });
        }

        if (allergyModalOverlay) {
            allergyModalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === allergyModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editAllergyModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditAllergyModal = function(allergyName, allergySeverity, allergyNotes) {
            openModal(allergyName, allergySeverity, allergyNotes);
        };
    });
</script> -->



{{-- Edit Allergy Modal - FIXED BASED ON MEDICAL CONDITION PATTERN --}}
<div id="editAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="allergyModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Allergy
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeAllergyModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="editAllergyForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Allergy Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Allergy<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_allergies" name="allergies" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter allergy" required>
                    </div>
                    
                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="edit_note" name="note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Enter any additional notes"></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelAllergyBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const editAllergyModal = document.getElementById('editAllergyModal');
        const allergyModalOverlay = document.getElementById('allergyModalOverlay');
        const closeAllergyModalBtn = document.getElementById('closeAllergyModalBtn');
        const cancelAllergyBtn = document.getElementById('cancelAllergyBtn');
        const allergyForm = document.getElementById('editAllergyForm');

        // Button to open modal
        const editAllergyBtns = document.querySelectorAll('.edit-allergy-btn');
        
        console.log('Allergy edit modal setup - Modal exists:', !!editAllergyModal);
        console.log('Found edit allergy buttons:', editAllergyBtns.length);

        // Form validation function
        function validateForm() {
            let isValid = true;
            const requiredFields = allergyForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = allergyForm.querySelectorAll('input, select, textarea');
            allFields.forEach(field => {
                field.classList.remove('border-red-500');
                const errorMsg = field.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            });

            // Check each required field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');

                    // Add error message below the field
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                    errorMsg.textContent = 'This field is required';
                    field.parentElement.appendChild(errorMsg);

                    isValid = false;

                    // Focus the first invalid field
                    if (isValid === false) {
                        setTimeout(() => field.focus(), 100);
                        isValid = null; // Prevent focusing multiple fields
                    }
                }
            });

            return isValid === true;
        }

        // Handle form submission
        if (allergyForm) {
            allergyForm.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Allergy form submitted');

                if (!validateForm()) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please check the form for errors',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                    return;
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                 document.querySelector('input[name="_token"]')?.value;
                
                // Create FormData object
                const formData = new FormData(allergyForm);
                
                // Send form data via AJAX - using the form's action directly
                fetch(allergyForm.action, {
                    method: 'POST', // Using POST with _method=PUT for Laravel method spoofing
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success response:', data);
                    
                    // Close modal
                    closeModal();
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Allergy updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#F91D7C'
                    }).then(() => {
                        // Reload the page to show updated data
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                });
            });
        }

        // Open Modal Function - FIXED to match medical condition pattern
        function openModal(allergyId) {
            console.log('Opening allergy edit modal for ID:', allergyId);
            
            // Fetch allergy data via AJAX - using the same pattern as medical condition
            fetch(`/allergies/${allergyId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_allergies').value = data.allergies || '';
                document.getElementById('edit_note').value = data.note || '';
                
                // Set form action
                allergyForm.action = `/allergies/${allergyId}`;
                
                // Show modal
                editAllergyModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Focus the first input field
                setTimeout(() => {
                    document.getElementById('edit_allergies').focus();
                }, 100);
            })
            .catch(error => {
                console.error('Error fetching allergy data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load allergy data',
                    icon: 'error',
                    confirmButtonColor: '#F91D7C'
                });
            });
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing allergy edit modal');
            editAllergyModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = allergyForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = allergyForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
            
            // Reset form
            allergyForm.reset();
        }

        // Event Listeners
        editAllergyBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const allergyId = this.getAttribute('data-allergy-id');
                console.log('Edit button clicked for allergy ID:', allergyId);
                openModal(allergyId);
            });
        });

        if (closeAllergyModalBtn) {
            closeAllergyModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (cancelAllergyBtn) {
            cancelAllergyBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (allergyModalOverlay) {
            allergyModalOverlay.addEventListener('click', function (e) {
                if (e.target === allergyModalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editAllergyModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>