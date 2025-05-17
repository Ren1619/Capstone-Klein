<!-- {{-- Add Patient Modal --}}
<div id="addPatientModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        Modal Background Overlay
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        Modal Content
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            Modal Header
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Patient
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn" onclick="closePatientModalDirect()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            Modal Body
            <div class="p-6">
                <form id="patientForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    Name Fields
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Name<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input type="text" id="firstName" name="firstName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="First Name" required>
                            </div>
                            <div>
                                <input type="text" id="middleName" name="middleName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Middle Name">
                            </div>
                            <div>
                                <input type="text" id="lastName" name="lastName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    
                    Sex and Date of Birth Fields
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                            <div class="flex space-x-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sex" value="male" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                    <span class="ml-2 text-sm text-gray-700">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sex" value="female" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                    <span class="ml-2 text-sm text-gray-700">Female</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Date of Birth<span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                    
                    Address Field
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Address<span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" id="address" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="House/Building No., Street, Barangay, City/Municipality, Province, ZIP Code" required>
                    </div>
                    
                    Contact and Civil Status Fields
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Contact Number<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="tel" id="contactNumber" name="contactNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="+63" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status</label>
                            <select id="civilStatus" name="civilStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>
                    </div>
                    
                    Health Metrics Fields
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Weight (kg)<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="number" id="weight" name="weight" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="0" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Height (cm)<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="number" id="height" name="height" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="0" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Blood Pressure<span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="flex items-center">
                                <input type="number" id="bpSystolic" name="bpSystolic" class="w-1/2 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="0" required>
                                <span class="px-2 text-gray-500">/</span>
                                <input type="number" id="bpDiastolic" name="bpDiastolic" class="w-1/2 px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                    
                    Button Actions
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Save
                        </button>
                        <button type="button" id="cancelBtn" onclick="closePatientModalDirect()" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
    console.log('Initializing patient modal with ID-only selectors');
    
    // Get the modal and its elements
    const modal = document.getElementById('addPatientModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const patientForm = document.getElementById('patientForm');
    
    // Core modal functions
    function openModal() {
        console.log('Opening patient modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeModal() {
        console.log('Closing patient modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (patientForm) patientForm.reset();
        }
    }
    
    // Make functions globally accessible
    window.modalFunctions = {
        ...window.modalFunctions,
        openPatientModal: openModal,
        closePatientModal: closeModal
    };
    
    // Add event handlers for modal close buttons
    if (closeModalBtn) {
        closeModalBtn.onclick = closeModal;
    }
    
    if (cancelBtn) {
        cancelBtn.onclick = closeModal;
    }
    
    if (modalOverlay) {
        modalOverlay.onclick = closeModal;
    }
    
    // Set up trigger for addPatientBtn
    const addPatientBtn = document.getElementById('addPatientBtn');
    if (addPatientBtn) {
        console.log('Found addPatientBtn, attaching click handler');
        addPatientBtn.onclick = openModal;
    } else {
        console.log('addPatientBtn not found on this page');
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Handle form submission
    if (patientForm) {
        patientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData(patientForm);
            const patientData = {};
            
            for (const [key, value] of formData.entries()) {
                patientData[key] = value;
            }
            
            console.log('Patient Data:', patientData);
            
            // Show success message
            alert('Patient added successfully!');
            closeModal();
        });
    }
});

// Provide global functions for inline handlers
function openPatientModalDirect() {
    const modal = document.getElementById('addPatientModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closePatientModalDirect() {
    const modal = document.getElementById('addPatientModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        const form = document.getElementById('patientForm');
        if (form) form.reset();
    }
}
</script> -->






{{-- Add Patient Modal --}}
<div id="addPatientModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="modalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Patient
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="addPatientForm" action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    <!-- Name Fields -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Name<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input type="text" id="first_name" name="first_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="First Name" required>
                            </div>
                            <div>
                                <input type="text" id="middle_name" name="middle_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Middle Name">
                            </div>
                            <div>
                                <input type="text" id="last_name" name="last_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sex and Date of Birth Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sex<span class="text-[#F91D7C]">*</span></label>
                            <div class="flex space-x-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sex" value="Male" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]" checked>
                                    <span class="ml-2 text-sm text-gray-700">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sex" value="Female" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                    <span class="ml-2 text-sm text-gray-700">Female</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sex" value="Other" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                    <span class="ml-2 text-sm text-gray-700">Other</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Date of Birth<span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Address<span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" id="address" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="House/Building No., Street, Barangay, City/Municipality, Province, ZIP Code" required>
                    </div>
                    
                    <!-- Contact and Civil Status Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Contact Number<span class="text-[#F91D7C]">*</span>
                            </label>
                            <input type="tel" id="contact_number" name="contact_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="+63" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status</label>
                            <select id="civil_status" name="civil_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Save
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
        const modal = document.getElementById('addPatientModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const patientForm = document.getElementById('addPatientForm');
        
        // Core modal functions
        function openModal() {
            console.log('Opening patient modal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeModal() {
            console.log('Closing patient modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (patientForm) patientForm.reset();
            }
        }
        
        // Add event handlers for modal close buttons
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
        
        // Set up trigger for addPatientBtn
        const addPatientBtn = document.getElementById('addPatientBtn');
        if (addPatientBtn) {
            console.log('Found addPatientBtn, attaching click handler');
            addPatientBtn.addEventListener('click', openModal);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form validation
        if (patientForm) {
            patientForm.addEventListener('submit', function(e) {
                const requiredFields = patientForm.querySelectorAll('[required]');
                let isValid = true;
                
                // Clear all previous error states
                const errorMessages = patientForm.querySelectorAll('.error-message');
                errorMessages.forEach(msg => msg.remove());
                
                requiredFields.forEach(field => {
                    field.classList.remove('border-red-500');
                    
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        
                        // Add error message below the field
                        const errorMsg = document.createElement('span');
                        errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                        errorMsg.textContent = 'This field is required';
                        field.parentElement.appendChild(errorMsg);
                    }
                });
                
                // Additional validation for date of birth - must be in the past
                const dobField = document.getElementById('date_of_birth');
                if (dobField && dobField.value) {
                    const dobDate = new Date(dobField.value);
                    const today = new Date();
                    if (dobDate > today) {
                        isValid = false;
                        dobField.classList.add('border-red-500');
                        const errorMsg = document.createElement('span');
                        errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                        errorMsg.textContent = 'Date of birth must be in the past';
                        dobField.parentElement.appendChild(errorMsg);
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Submit form via AJAX to enable SweetAlert
                    e.preventDefault();
                    
                    // Create FormData object
                    const formData = new FormData(patientForm);
                    
                    // Send form data
                    fetch(patientForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            closeModal();
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Patient added successfully',
                                icon: 'success',
                                confirmButtonColor: '#F91D7C',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reload the page to show the new patient
                                window.location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Something went wrong',
                                icon: 'error',
                                confirmButtonColor: '#F91D7C',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonColor: '#F91D7C',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        }
    });
</script>