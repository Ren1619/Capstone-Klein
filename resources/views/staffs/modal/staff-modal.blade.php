<div id="staffModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Modal overlay -->
    <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"
        onclick="closeAllModals()"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-auto z-10 px-4 sm:px-8 py-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl sm:text-2xl font-bold">
                    <span class="text-[#F91D7C]" id="modalAction">Add</span> Staff
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn"
                    onclick="closeStaffModalDirect()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-sm mb-6 sm:mb-8">
                All fields with <span class="text-[#F91D7C]">*</span> are required.
            </p>

            <!-- Error/Success Messages -->
            <div id="messageContainer" class="mb-4 hidden">
                <div id="errorMessage"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden">
                </div>
                <div id="successMessage"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 hidden">
                </div>
            </div>

            <!-- Modal Body -->
            <form id="staffForm">
                <!-- Hidden staff ID field for edit mode -->
                <input type="hidden" id="staffId" name="staffId" value="">

                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">First Name<span
                                class="text-[#F91D7C]">*</span></label>
                        <input type="text" id="firstName" name="first_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Middle Name</label>
                        <input type="text" id="middleName" name="middle_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Last Name<span
                                class="text-[#F91D7C]">*</span></label>
                        <input type="text" id="lastName" name="last_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-700 mb-1">Email<span class="text-[#F91D7C]">*</span></label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-700 mb-1">Password<span
                            class="text-[#F91D7C]">*</span></label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]"
                        placeholder="Enter password" minlength="8">
                </div>

                <!-- Role and Branch -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">
                            Role<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="relative">
                            <select id="role" name="role_ID" required
                                class="w-full px-3 py-2 border border-gray-300 rounded appearance-none focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                                <option value="" disabled selected>Select Role</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">
                            Branch<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="relative">
                            <select id="branch" name="branch_ID" required
                                class="w-full px-3 py-2 border border-gray-300 rounded appearance-none focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                                <option value="" disabled selected>Select Branch</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="mb-8">
                    <label class="block text-sm text-gray-700 mb-1">
                        Contact Number<span class="text-[#F91D7C]">*</span>
                    </label>
                    <div class="flex items-center border border-gray-300 rounded px-3 py-2">
                        <span class="text-gray-500 mr-1">+63</span>
                        <input type="tel" id="contactNumber" name="contact_number" class="w-full focus:outline-none"
                            maxlength="10" required pattern="[0-9]{10}" placeholder="9123456789">
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6 sm:mt-8">
                    <button type="submit" id="submitBtn"
                        class="bg-[#F91D7C] text-white px-8 py-2 rounded font-medium order-2 sm:order-1 disabled:opacity-50">
                        <span id="submitBtnText">Add</span>
                        <span id="submitBtnLoading" class="hidden">Saving...</span>
                    </button>
                    <button type="button" id="cancelBtn" onclick="closeStaffModalDirect()"
                        class="bg-black text-white px-8 py-2 rounded font-medium order-1 sm:order-2">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let isSubmitting = false;

        // Get CSRF token
        function getCSRFToken() {
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            return metaTag ? metaTag.getAttribute('content') : null;
        }

        // Load roles and branches
        function loadDropdownData() {
            console.log('Loading dropdown data...');

            // Load roles
            fetch('/roles')
                .then(response => {
                    console.log('Roles response status:', response.status);
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    console.log('Roles data:', data);
                    if (data.status === 'success') {
                        const roleSelect = document.getElementById('role');
                        if (roleSelect) {
                            roleSelect.innerHTML = '<option value="" disabled selected>Select Role</option>';
                            data.data.forEach(role => {
                                const option = document.createElement('option');
                                option.value = role.role_ID;
                                option.textContent = role.role_name;
                                roleSelect.appendChild(option);
                            });
                            console.log(`Loaded ${data.data.length} roles`);
                        }
                    } else {
                        console.error('Roles response not successful:', data);
                    }
                })
                .catch(error => {
                    console.error('Error loading roles:', error);
                    showError('Failed to load roles: ' + error.message);                });
                
            // Load branches
            console.log('Fetching branches from /api/branches/dropdown');
            fetch('/api/branches/dropdown')
                .then(response => {
                    console.log('Branches response:', response);
                    console.log('Branches response status:', response.status);
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })                .then(data => {
                    console.log('Branches data:', data);
                    console.log('Branches success status:', data.status);
                    if (data.success) { // Changed from data.status to data.success
                        const branchSelect = document.getElementById('branch');
                        console.log('Found branch select:', !!branchSelect);
                        if (branchSelect) {
                            branchSelect.innerHTML = '<option value="" disabled selected>Select Branch</option>';
                            data.data.forEach(branch => {
                                const option = document.createElement('option');
                                option.value = branch.branch_ID;
                                option.textContent = branch.name;
                                branchSelect.appendChild(option);
                            });
                            console.log(`Loaded ${data.data.length} branches`);
                        }
                    } else {
                        console.error('Branches response not successful:', data);
                    }
                })
                .catch(error => {
                    console.error('Error loading branches:', error);
                    showError('Failed to load branches: ' + error.message);
                });
        }

        // Contact number validation
        const contactInput = document.getElementById('contactNumber');
        if (contactInput) {
            contactInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        }

        // Form submit handler
        const staffForm = document.getElementById('staffForm');
        if (staffForm) {
            staffForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (isSubmitting) {
                    console.log('Already submitting, ignoring');
                    return;
                }

                console.log('Form submitted');
                handleFormSubmit();
            });
        }

        function handleFormSubmit() {
            isSubmitting = true;
            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const submitBtnLoading = document.getElementById('submitBtnLoading');

            // Show loading state
            submitBtn.disabled = true;
            submitBtnText.classList.add('hidden');
            submitBtnLoading.classList.remove('hidden');

            const staffId = document.getElementById('staffId').value;
            const isEditing = staffId !== '';

            // Collect form data
            const formData = {
                first_name: document.getElementById('firstName').value.trim(),
                last_name: document.getElementById('lastName').value.trim(),
                email: document.getElementById('email').value.trim(),
                role_ID: parseInt(document.getElementById('role').value),
                branch_ID: parseInt(document.getElementById('branch').value),
                contact_number: '+63' + document.getElementById('contactNumber').value.trim()
            };

            // Add optional fields
            const middleName = document.getElementById('middleName').value.trim();
            if (middleName) {
                formData.middle_name = middleName;
            }

            const password = document.getElementById('password').value;
            if (password || !isEditing) {
                formData.password = password;
            }

            console.log('Form data:', formData);

            // Validate required fields
            const requiredFields = ['first_name', 'last_name', 'email', 'role_ID', 'branch_ID', 'contact_number'];
            if (!isEditing) requiredFields.push('password');

            let isValid = true;
            requiredFields.forEach(field => {
                if (!formData[field]) {
                    isValid = false;
                    console.error(`Missing required field: ${field}`);
                }
            });

            if (!isValid) {
                showError('Please fill all required fields');
                resetSubmitButton();
                return;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                showError('Please enter a valid email address');
                resetSubmitButton();
                return;
            }

            // Validate phone number
            if (formData.contact_number.length !== 13) { // +63 + 10 digits
                showError('Please enter a valid 10-digit phone number');
                resetSubmitButton();
                return;
            }

            // Submit to server
            const method = isEditing ? 'PUT' : 'POST';
            const url = isEditing ? `/api/accounts/${staffId}` : '/api/accounts';
            const csrfToken = getCSRFToken();

            console.log(`Sending ${method} request to ${url}`);

            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            fetch(url, {
                method: method,
                headers: headers,
                body: JSON.stringify(formData)
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json().then(data => ({ status: response.status, data }));
                })
                .then(({ status, data }) => {
                    console.log('Response data:', data);

                    if (status >= 200 && status < 300 && data.status === 'success') {
                        showSuccess(data.message || 'Staff saved successfully!');
                        setTimeout(() => {
                            closeStaffModalDirect();
                            // Reload the accounts table if function exists
                            if (typeof fetchAccounts === 'function') {
                                fetchAccounts();
                            }
                            // Reload the page as fallback
                            else {
                                window.location.reload();
                            }
                        }, 1500);
                    } else {
                        let errorMessage = 'Failed to save staff';
                        if (data.errors) {
                            const errors = Object.values(data.errors).flat();
                            errorMessage = errors.join(', ');
                        } else if (data.message) {
                            errorMessage = data.message;
                        }
                        showError(errorMessage);
                        resetSubmitButton();
                    }
                })
                .catch(error => {
                    console.error('Error saving account:', error);
                    showError('Network error. Please try again.');
                    resetSubmitButton();
                });
        }

        function resetSubmitButton() {
            isSubmitting = false;
            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const submitBtnLoading = document.getElementById('submitBtnLoading');

            submitBtn.disabled = false;
            submitBtnText.classList.remove('hidden');
            submitBtnLoading.classList.add('hidden');
        }

        // Load data when page loads
        loadDropdownData();

        // Utility functions
        function showError(message) {
            console.error('Error:', message);
            const container = document.getElementById('messageContainer');
            const errorDiv = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMessage');

            successDiv.classList.add('hidden');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            container.classList.remove('hidden');

            // Auto hide after 5 seconds
            setTimeout(() => {
                errorDiv.classList.add('hidden');
                if (successDiv.classList.contains('hidden')) {
                    container.classList.add('hidden');
                }
            }, 5000);
        }

        function showSuccess(message) {
            console.log('Success:', message);
            const container = document.getElementById('messageContainer');
            const errorDiv = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMessage');

            errorDiv.classList.add('hidden');
            successDiv.textContent = message;
            successDiv.classList.remove('hidden');
            container.classList.remove('hidden');
        }

        // Make functions globally available
        window.loadDropdownData = loadDropdownData;
        window.showError = showError;
        window.showSuccess = showSuccess;
    });

    // Global functions for modal control
    function openStaffModalDirect() {
        const modal = document.getElementById('staffModal');
        if (modal) {
            const modalAction = document.getElementById('modalAction');
            const submitBtnText = document.getElementById('submitBtnText');
            const staffId = document.getElementById('staffId');

            modalAction.textContent = 'Add';
            submitBtnText.textContent = 'Add';
            staffId.value = '';
            document.getElementById('staffForm').reset();
            document.getElementById('password').placeholder = 'Enter password';
            document.getElementById('password').required = true;

            // Hide messages
            document.getElementById('messageContainer').classList.add('hidden');

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Reload dropdown data
            if (typeof loadDropdownData === 'function') {
                loadDropdownData();
            }
        }
    }

    function openEditStaffModalDirect(staffId) {
        const modal = document.getElementById('staffModal');
        if (modal) {
            const modalAction = document.getElementById('modalAction');
            const submitBtnText = document.getElementById('submitBtnText');
            const staffIdInput = document.getElementById('staffId');

            modalAction.textContent = 'Edit';
            submitBtnText.textContent = 'Update';
            staffIdInput.value = staffId;

            // Hide messages
            document.getElementById('messageContainer').classList.add('hidden');

            // Fetch account data
            fetch(`/api/accounts/${staffId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Populate form
                        document.getElementById('firstName').value = data.data.first_name || '';
                        document.getElementById('middleName').value = data.data.middle_name || '';
                        document.getElementById('lastName').value = data.data.last_name || '';
                        document.getElementById('email').value = data.data.email || '';
                        document.getElementById('contactNumber').value = data.data.contact_number
                            ? data.data.contact_number.replace('+63', '')
                            : '';

                        // Load dropdowns first, then set values
                        loadDropdownData();
                        setTimeout(() => {
                            document.getElementById('role').value = data.data.role_ID || '';
                            document.getElementById('branch').value = data.data.branch_ID || '';
                        }, 500);

                        document.getElementById('password').placeholder = 'Leave blank to keep current password';
                        document.getElementById('password').required = false;
                        document.getElementById('password').value = '';
                    } else {
                        showError('Failed to load staff data');
                    }
                })
                .catch(error => {
                    console.error('Error fetching account:', error);
                    showError('Failed to load staff data');
                });

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeStaffModalDirect() {
        const modal = document.getElementById('staffModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Reset the form
        const form = document.getElementById('staffForm');
        if (form) {
            form.reset();
        }

        // Hide messages
        document.getElementById('messageContainer').classList.add('hidden');
    }

    // Define closeAllModals for compatibility
    function closeAllModals() {
        closeStaffModalDirect();
    }
</script>