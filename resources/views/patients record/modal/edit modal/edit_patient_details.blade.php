{{-- Edit Patient Button --}}
<!-- <button id="editPatientBtn"
    class="flex items-center text-[#F91D7C] hover:text-[#e01a70] transition-colors font-medium text-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
    </svg>
    Edit Patient
</button> -->

{{-- Edit Patient Details Modal --}}
<!-- <div id="editPatientModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        Modal Background Overlay
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="patientModalOverlay"></div>

        Modal Content
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            Modal Header
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Patient Details
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closePatientModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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

                    Patient Information Form
                    <div class="space-y-4">
                        Patient Name Fields
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    First Name<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="patientFirstName" name="patientFirstName"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="First name" required value="Earl Francis Philip">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Middle Name
                                </label>
                                <input type="text" id="patientMiddleName" name="patientMiddleName"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Middle name (optional)" value=" M.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Last Name<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="patientLastName" name="patientLastName"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Last name" required value="Amoy">
                            </div>
                        </div>

                        First Row - Patient ID and Sex
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Patient ID<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="patientId" name="patientId"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Enter patient ID" required value="P-Mar-2025-01">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Sex<span class="text-red-500">*</span>
                                </label>
                                <select id="patientSex" name="patientSex"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    required>
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        Address (Full Width)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Address<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="patientAddress" name="patientAddress"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter address" required value="Dologon, Maramag, Bukidnon">
                        </div>

                        Contact Number and Date of Birth
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Contact Number<span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="patientContact" name="patientContact"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Enter contact number" required value="09123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Date of Birth<span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="patientDob" name="patientDob"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    required value="2003-05-01">
                            </div>
                        </div>

                        Civil Status and Weight
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Civil Status
                                </label>
                                <select id="patientCivilStatus" name="patientCivilStatus"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                    <option value="Single" selected>Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Weight (kg)
                                </label>
                                <input type="number" id="patientWeight" name="patientWeight"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Enter weight" value="50">
                            </div>
                        </div>

                        Height and Blood Pressure
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Height (cm)
                                </label>
                                <input type="number" id="patientHeight" name="patientHeight"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Enter height" value="165">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Blood Pressure
                                </label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" id="bpSystolic" name="bpSystolic"
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                        placeholder="Systolic" value="130">
                                    <span class="text-gray-500 font-medium">/</span>
                                    <input type="number" id="bpDiastolic" name="bpDiastolic"
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                        placeholder="Diastolic" value="90">
                                    <span class="text-gray-500 text-sm">mmHg</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    Button Actions
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelPatientBtn"
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
        const editPatientModal = document.getElementById('editPatientModal');
        const patientModalOverlay = document.getElementById('patientModalOverlay');
        const closePatientModalBtn = document.getElementById('closePatientModalBtn');
        const cancelPatientBtn = document.getElementById('cancelPatientBtn');
        const patientForm = document.getElementById('patientForm');

        // Button to open modal (You'll need to add this button to your UI)
        const editPatientBtn = document.getElementById('editPatientBtn');

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
            const requiredFields = patientForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = patientForm.querySelectorAll('input, select, textarea');
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

            // Additional validation for date of birth - must be in the past
            const dobField = document.getElementById('patientDob');
            if (dobField && dobField.value) {
                const dobDate = new Date(dobField.value);
                const today = new Date();
                if (dobDate > today) {
                    dobField.classList.add('border-red-500');
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                    errorMsg.textContent = 'Date of birth must be in the past';
                    dobField.parentElement.appendChild(errorMsg);
                    isValid = false;
                }
            }

            return isValid === true;
        }

        // Handle form submission
        if (patientForm) {
            patientForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }

                // Collect patient data
                const patientData = {
                    firstName: document.getElementById('patientFirstName').value,
                    middleName: document.getElementById('patientMiddleName').value,
                    lastName: document.getElementById('patientLastName').value,
                    id: document.getElementById('patientId').value,
                    sex: document.getElementById('patientSex').value,
                    address: document.getElementById('patientAddress').value,
                    contact: document.getElementById('patientContact').value,
                    dob: document.getElementById('patientDob').value,
                    civilStatus: document.getElementById('patientCivilStatus').value,
                    weight: document.getElementById('patientWeight').value,
                    height: document.getElementById('patientHeight').value,
                    bloodPressure: {
                        systolic: document.getElementById('bpSystolic').value,
                        diastolic: document.getElementById('bpDiastolic').value
                    }
                };

                // Here you would typically send the data to the server
                console.log('Patient Data:', patientData);

                // Show success and close modal
                showNotification('Patient details updated successfully!', 'success');
                closeModal();

                // Here you might want to update the UI with the new patient data
                // This is just a placeholder for demonstration
                updatePatientInfoDisplay(patientData);
            });
        }

        // Function to update the UI with new patient data
        function updatePatientInfoDisplay(patientData) {
            // This function would update the patient information on the page
            // For demonstration purposes we'll just log it
            console.log('Updating UI with:', patientData);

            // In a real implementation, you'd select the elements and update their content
            // Example:
            // document.querySelector('h2.patient-name').textContent = patientData.name;
            // document.querySelector('.patient-id').textContent = patientData.id;
            // etc.
        }

        // Open Modal Function
        function openModal() {
            console.log('Opening patient edit modal');
            editPatientModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Focus the first input field for better UX
            setTimeout(() => {
                const firstInput = patientForm.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing patient edit modal');
            editPatientModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = patientForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = patientForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }

        // Event Listeners
        if (editPatientBtn) {
            editPatientBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openModal();
            });
        }

        if (closePatientModalBtn) {
            closePatientModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        if (cancelPatientBtn) {
            cancelPatientBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via Cancel button');
            });
        }

        if (patientModalOverlay) {
            patientModalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === patientModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editPatientModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openEditPatientModal = openModal;
    });
</script>

 -->









 {{-- Edit Patient Details Modal --}}
<div id="editPatientModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" id="patientModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Patient Details
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closePatientModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="patientForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Patient Information Form -->
                    <div class="space-y-4">
                        <!-- Patient Name Fields -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    First Name<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="patientFirstName" name="first_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="First name" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Middle Name
                                </label>
                                <input type="text" id="patientMiddleName" name="middle_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Middle name (optional)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Last Name<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="patientLastName" name="last_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Last name" required>
                            </div>
                        </div>

                        <!-- First Row - Patient ID and Sex -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Patient ID
                                </label>
                                <input type="text" id="patientId" name="PID"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Sex<span class="text-red-500">*</span>
                                </label>
                                <select id="patientSex" name="sex"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Address (Full Width) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Address<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="patientAddress" name="address"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                placeholder="Enter address" required>
                        </div>

                        <!-- Contact Number and Date of Birth -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Contact Number<span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="patientContact" name="contact_number"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="Enter contact number" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Date of Birth<span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="patientDob" name="date_of_birth"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    required>
                            </div>
                        </div>

                        <!-- Civil Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Civil Status
                            </label>
                            <select id="patientCivilStatus" name="civil_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelPatientBtn"
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
        const editPatientModal = document.getElementById('editPatientModal');
        const patientModalOverlay = document.getElementById('patientModalOverlay');
        const closePatientModalBtn = document.getElementById('closePatientModalBtn');
        const cancelPatientBtn = document.getElementById('cancelPatientBtn');
        const patientForm = document.getElementById('patientForm');

        // Button to open modal (You'll need to add this button to your UI)
        const editPatientBtns = document.querySelectorAll('.edit-patient-btn');

        // Form validation function
        function validateForm() {
            let isValid = true;
            const requiredFields = patientForm.querySelectorAll('[required]');

            // Clear all previous error states
            const allFields = patientForm.querySelectorAll('input, select, textarea');
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

            // Additional validation for date of birth - must be in the past
            const dobField = document.getElementById('patientDob');
            if (dobField && dobField.value) {
                const dobDate = new Date(dobField.value);
                const today = new Date();
                if (dobDate > today) {
                    dobField.classList.add('border-red-500');
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
                    errorMsg.textContent = 'Date of birth must be in the past';
                    dobField.parentElement.appendChild(errorMsg);
                    isValid = false;
                }
            }

            return isValid === true;
        }

        // Handle form submission
        if (patientForm) {
            patientForm.addEventListener('submit', function (e) {
                e.preventDefault();

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
                const formData = new FormData(patientForm);
                
                // Send form data via AJAX
                fetch(patientForm.action, {
                    method: 'POST', // Using POST with _method=PUT for Laravel method spoofing
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Close modal
                        closeModal();
                        
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Patient updated successfully',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C'
                        }).then(() => {
                            // Reload the page to show updated data
                            window.location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Something went wrong',
                            icon: 'error',
                            confirmButtonColor: '#F91D7C'
                        });
                    }
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

        // Open Modal Function
        function openModal(patientId) {
            console.log('Opening patient edit modal for ID:', patientId);
            
            // Fetch patient data via AJAX
            fetch(`/patients/${patientId}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('patientFirstName').value = data.first_name;
                document.getElementById('patientMiddleName').value = data.middle_name || '';
                document.getElementById('patientLastName').value = data.last_name;
                document.getElementById('patientId').value = data.PID;
                document.getElementById('patientSex').value = data.sex;
                document.getElementById('patientAddress').value = data.address;
                document.getElementById('patientContact').value = data.contact_number;
                document.getElementById('patientDob').value = data.date_of_birth;
                document.getElementById('patientCivilStatus').value = data.civil_status || 'Single';
                
                // Set form action
                patientForm.action = `/patients/${patientId}`;
                
                // Show modal
                editPatientModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Focus the first input field
                setTimeout(() => {
                    document.getElementById('patientFirstName').focus();
                }, 100);
            })
            .catch(error => {
                console.error('Error fetching patient data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load patient data',
                    icon: 'error',
                    confirmButtonColor: '#F91D7C'
                });
            });
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing patient edit modal');
            editPatientModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Clear any validation errors
            const errorMessages = patientForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = patientForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
            
            // Reset form
            patientForm.reset();
        }

        // Event Listeners
        editPatientBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const patientId = this.getAttribute('data-pid');
                openModal(patientId);
            });
        });

        if (closePatientModalBtn) {
            closePatientModalBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (cancelPatientBtn) {
            cancelPatientBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }

        if (patientModalOverlay) {
            patientModalOverlay.addEventListener('click', function (e) {
                if (e.target === patientModalOverlay) {
                    closeModal();
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !editPatientModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>