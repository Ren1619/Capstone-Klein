<!-- Add/Edit Staff Modal -->
<div id="staffModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Modal overlay -->
    <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay" onclick="closeAllModals()"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-auto z-10 px-4 sm:px-8 py-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl sm:text-2xl font-bold">
                    <span class="text-[#F91D7C]" id="modalAction">Add</span> Staff
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn" onclick="closeStaffModalDirect()">
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

            <!-- Modal Body -->
            <form id="staffForm">
                <!-- Hidden staff ID field for edit mode -->
                <input type="hidden" id="staffId" name="staffId" value="">

                <!-- Profile Image Upload - keeping for future implementation -->
                <div class="flex justify-center mb-6 sm:mb-8" style="display: none;">
                    <div class="w-28 sm:w-32 h-28 sm:h-32 flex flex-col items-center justify-center">
                        <div id="image-preview"
                            class="w-full h-full flex items-center justify-center border border-gray-300 rounded mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="file" class="hidden" id="staff-image" accept="image/*">
                        <button type="button" id="browse-button"
                            class="bg-[#F91D7C]/10 text-[#F91D7C] px-4 py-1 rounded text-sm">
                            Browse File
                        </button>
                    </div>
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">First Name<span
                                class="text-[#F91D7C]">*</span></label>
                        <input type="text" id="firstName" name="first_name"
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
                        <input type="text" id="lastName" name="last_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-700 mb-1">Email<span class="text-[#F91D7C]">*</span></label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-700 mb-1">Password<span
                            class="text-[#F91D7C]">*</span></label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]"
                        placeholder="Leave blank to keep current password (for edit)">
                </div>

                <!-- Role and Branch -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">
                            Role<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="relative">
                            <select id="role" name="role_ID"
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
                            <select id="branch" name="branch_ID"
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
                            maxlength="10">
                    </div>
                </div>

                <!-- Date of Birth and Gender - Hidden as not in Account model -->
                <div class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                        <div>
                            <label class="flex items-center text-sm text-gray-700 mb-1">
                                Date of Birth
                            </label>
                            <div class="relative">
                                <input type="text" id="dob" name="dob" placeholder="mm/dd/yyyy"
                                    class="w-full pl-9 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#F91D7C] focus:ring-1 focus:ring-[#F91D7C]">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-3">Sex</label>
                            <div class="px-3 py-2 border border-gray-300 rounded flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="male" class="h-4 w-4 text-[#F91D7C]">
                                    <span class="ml-2 text-sm">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="female" class="h-4 w-4 text-[#F91D7C]">
                                    <span class="ml-2 text-sm">Female</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6 sm:mt-8">
                    <button type="button" id="submitBtn"
                        class="bg-[#F91D7C] text-white px-8 py-2 rounded font-medium order-2 sm:order-1">
                        Add
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
        // Load roles and branches
        function loadDropdownData() {
            // Load roles
            fetch('/api/roles')
                .then(response => response.json())
                .then(data => {
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
                        }
                    }
                })
                .catch(error => console.error('Error loading roles:', error));

            // Load branches
            fetch('/api/branches')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const branchSelect = document.getElementById('branch');
                        if (branchSelect) {
                            branchSelect.innerHTML = '<option value="" disabled selected>Select Branch</option>';
                            data.data.forEach(branch => {
                                const option = document.createElement('option');
                                option.value = branch.branch_ID;
                                option.textContent = branch.branch_name;
                                branchSelect.appendChild(option);
                            });
                        }
                    }
                })
                .catch(error => console.error('Error loading branches:', error));
        }

        // Contact number validation
        const contactInput = document.getElementById('contactNumber');
        if (contactInput) {
            contactInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        // Submit handler
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.addEventListener('click', function () {
                let isValid = true;
                const staffId = document.getElementById('staffId');
                const isEditing = staffId.value !== '';
                const formData = {};
                
                // Required form fields
                const requiredFields = ['first_name', 'last_name', 'email', 'role_ID', 'branch_ID', 'contact_number'];

                // Validation
                requiredFields.forEach(field => {
                    let input;
                    if (field.includes('_')) {
                        const fieldParts = field.split('_');
                        input = document.getElementById(fieldParts[0] + fieldParts[1].charAt(0).toUpperCase() + fieldParts[1].slice(1));
                    } else {
                        input = document.getElementById(field);
                    }
                    
                    // Skip password validation for edit mode if empty
                    if (field === 'password' && isEditing && !input.value) return;

                    if (input && !input.value.trim()) {
                        input.classList.add('border-[#F91D7C]');
                        isValid = false;
                    } else if (input) {
                        input.classList.remove('border-[#F91D7C]');
                        formData[field] = input.value;
                    }
                });

                // Check password field separately
                const passwordInput = document.getElementById('password');
                if (!isEditing && (!passwordInput.value || !passwordInput.value.trim())) {
                    passwordInput.classList.add('border-[#F91D7C]');
                    isValid = false;
                } else {
                    passwordInput.classList.remove('border-[#F91D7C]');
                    if (passwordInput.value) formData['password'] = passwordInput.value;
                }

                if (!isValid) {
                    showError('Please fill all required fields');
                    return;
                }

                // Format phone number with +63
                if (formData.contact_number) {
                    formData.contact_number = '+63' + formData.contact_number;
                }

                const method = isEditing ? 'PUT' : 'POST';
                const url = isEditing ? `/api/accounts/${staffId.value}` : '/api/accounts';

                // Send request
                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            closeStaffModalDirect();
                            showSuccess(data.message);
                            // Reload the accounts table
                            if (typeof fetchAccounts === 'function') {
                                fetchAccounts();
                            }
                        } else {
                            showError(data.message || 'Failed to save staff');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving account:', error);
                        showError('Failed to save staff');
                    });
            });
        }

        // Load data when page loads
        loadDropdownData();

        // Add escape key handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStaffModalDirect();
            }
        });

        // Utility functions
        function showError(message) {
            // Implement your preferred notification method here
            alert(message);
        }

        function showSuccess(message) {
            // Implement your preferred notification method here
            alert(message);
        }
    });

    // Global functions for direct modal control
    function openStaffModalDirect() {
        const modal = document.getElementById('staffModal');
        if (modal) {
            const modalAction = document.getElementById('modalAction');
            const submitBtn = document.getElementById('submitBtn');
            const staffId = document.getElementById('staffId');
            
            modalAction.textContent = 'Add';
            submitBtn.textContent = 'Add';
            staffId.value = '';
            document.getElementById('staffForm').reset();
            document.getElementById('password').placeholder = 'Enter password';
            document.getElementById('password').required = true;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function openEditStaffModalDirect(staffId) {
        const modal = document.getElementById('staffModal');
        if (modal) {
            const modalAction = document.getElementById('modalAction');
            const submitBtn = document.getElementById('submitBtn');
            const staffIdInput = document.getElementById('staffId');
            
            modalAction.textContent = 'Edit';
            submitBtn.textContent = 'Update';
            staffIdInput.value = staffId;
            
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
                        document.getElementById('role').value = data.data.role_ID || '';
                        document.getElementById('branch').value = data.data.branch_ID || '';
                        
                        document.getElementById('password').placeholder = 'Leave blank to keep current password';
                        document.getElementById('password').required = false;
                    } else {
                        alert('Failed to load staff data');
                    }
                })
                .catch(error => {
                    console.error('Error fetching account:', error);
                    alert('Failed to load staff data');
                });
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }    function closeStaffModalDirect() {
        closeAllModals();
        const form = document.getElementById('staffForm');
        if (form) form.reset();
    }
</script>