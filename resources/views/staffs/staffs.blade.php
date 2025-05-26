@extends('layouts.app')

@section('title', 'Staffs')
@section('header', 'Staffs')

@section('content')
    <!-- Main Staff Content -->
    <div class="bg-neutral-100 p-2 sm:p-5">
        <div class="flex-1 flex flex-col justify-between">
            <!-- Top Bar with Search and Add Button -->
            <div
                class="min-h-16 px-3 sm:px-7 py-3.5 bg-white rounded-[10px] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0 mb-7">
                <div class="w-full sm:w-64 px-2.5 py-1.5 rounded-md border border-neutral-200 flex items-center">
                    <img src="{{ asset('icons/search_icon.svg') }}" alt="Search Icon">
                    <input type="text" id="clinicSearchInput" class="flex-1 bg-transparent outline-none text-sm ml-2"
                        placeholder="Search Staff...">
                </div>

                <div class="flex justify-end items-center w-full sm:w-auto">
                    <button onclick="openStaffModalDirect()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] rounded-[5px] flex items-center gap-3.5 text-white w-full sm:w-auto justify-center sm:justify-start">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Staff">
                        <span class="text-sm font-normal font-poppins">Staff</span>
                    </button>
                </div>
            </div>

            <!-- Status Messages (will be updated by the script) -->
                <div id="statusMessage" class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded hidden">
                    <div id="statusText">Processing...</div>
                </div>

                <!-- Staff Table -->
                <div class="flex-1 pt-7 rounded-[10px]">
                    <div class="bg-white rounded-[10px] shadow-sm overflow-hidden">
                        <!-- Table Header - Hidden on mobile -->
                        <div class="hidden sm:block px-7 py-3.5 border-b border-gray-200">
                            <div class="grid grid-cols-12 items-center">
                                <div class="col-span-5 text-neutral-500 text-base font-normal font-poppins">Name</div>
                                <div class="col-span-2 text-neutral-500 text-base font-normal font-poppins">Role</div>
                                <div class="col-span-2 text-neutral-500 text-base font-normal font-poppins">Branch</div>
                                <div class="col-span-2 text-center text-neutral-500 text-base font-normal font-poppins">Status
                                </div>
                                <div class="col-span-1 text-neutral-500 text-base font-normal font-poppins">Action</div>
                            </div>
                        </div>

                        <!-- Table Body -->
                        <div class="py-2.5" id="staffTableBody">
                            <div class="text-center py-10 text-gray-500">Loading staff members...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('staffs.modal.staff-modal')
        @include('staffs.modal.staff-details-modal')

        <!-- Direct Inline Script - No Dependencies -->
        <script>
            // Immediately execute this code
            (function() {
                // Show status message
                function showStatus(message, type = 'info') {
                    const statusEl = document.getElementById('statusMessage');
                    const statusText = document.getElementById('statusText');

                    if (statusEl && statusText) {
                        statusText.innerText = message;
                        statusEl.classList.remove('hidden');

                        // Set appropriate styling based on message type
                        statusEl.className = 'p-4 mb-4 rounded';

                        if (type === 'error') {
                            statusEl.classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700');
                        } else if (type === 'success') {
                            statusEl.classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700');
                        } else {
                            statusEl.classList.add('bg-blue-100', 'border-l-4', 'border-blue-500', 'text-blue-700');
                        }
                    }

                    // Also log to console
                    console.log(`STATUS (${type}):`, message);
                }

                // Load staff data immediately
                function loadStaffData() {
                    showStatus('Loading staff data...');

                    const tableBody = document.getElementById('staffTableBody');
                    if (!tableBody) return;

                    tableBody.innerHTML = '<div class="text-center py-10 text-gray-500">Loading staff members...</div>';

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    console.log('CSRF Token:', csrfToken ? 'Found' : 'Not Found');

                    // Make API request
                    const staffApiUrl = '/api/accounts/role/3';
                    console.log('Fetching from:', staffApiUrl);

                    fetch(staffApiUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(function(response) {
                        console.log('Response received, status:', response.status);

                        if (!response.ok) {
                            throw new Error('API request failed with status ' + response.status);
                        }

                        return response.json();
                    })
                    .then(function(result) {
                        console.log('Data received:', result);

                        // Check if we have valid data
                        if (result.status === 'success' && Array.isArray(result.data)) {
                            showStatus('Successfully loaded ' + result.data.length + ' staff members', 'success');
                            displayStaff(result.data);
                        } else {
                            showStatus('Received data but no staff found', 'error');
                            tableBody.innerHTML = '<div class="text-center py-10 text-gray-500">No staff members found</div>';
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading staff data:', error);
                        showStatus('Error loading staff data: ' + error.message, 'error');

                        tableBody.innerHTML = '<div class="text-center py-10 text-red-500">Error: ' + error.message + '</div>';
                    });
                }

                // Display staff in the table
                function displayStaff(staffList) {
                    const tableBody = document.getElementById('staffTableBody');
                    if (!tableBody) return;

                    if (staffList.length === 0) {
                        tableBody.innerHTML = '<div class="text-center py-10 text-gray-500">No staff members found</div>';
                        return;
                    }

                    let html = '';

                    // Generate rows for each staff member
                    staffList.forEach(function(staff) {
                        // Get initials for avatar
                        const firstName = staff.first_name || '';
                        const lastName = staff.last_name || '';
                        const firstInitial = firstName ? firstName.charAt(0).toUpperCase() : '';
                        const lastInitial = lastName ? lastName.charAt(0).toUpperCase() : '';
                        const initials = firstInitial + lastInitial;

                        // Create HTML for this staff row
                        html += `
                            <div class="px-4 sm:px-7 py-3.5 border-b border-neutral-200 hover:bg-[#F91D7C]/10">
                                <!-- Mobile View -->
                                <div class="block sm:hidden">
                                    <div class="flex items-start mb-2 cursor-pointer" onclick="openStaffDetailsModal(${staff.account_ID})">
                                        <div
                                            class="w-12 h-12 rounded-[5px] border border-neutral-200 flex justify-center items-center overflow-hidden mr-3">
                                            <div
                                                class="w-8 h-8 bg-[#F91D7C] flex items-center justify-center text-white font-bold">
                                                ${initials}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-black text-base font-normal font-poppins">${firstName} ${lastName}
                                            </div>
                                            <div class="flex justify-between mt-1">
                                                <span class="text-gray-500 text-sm">${staff.role?.role_name || 'Staff'}</span>
                                                <span class="text-gray-500 text-sm ml-2">${staff.branch?.branch_name || 'N/A'}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="w-24 p-2 bg-green-500/30 rounded-[5px] text-center">
                                            <span
                                                class="text-green-700 text-sm font-normal font-poppins">Active</span>
                                        </div>
                                        <div class="flex items-center gap-3.5">
                                            <button class="text-green-600 hover:text-green-800" onclick="openEditStaffModalDirect(${staff.account_ID})">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                            </button>
                                            <button class="text-red-600 hover:text-red-800" onclick="deleteStaff(${staff.account_ID})">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desktop View -->
                                <div class="hidden sm:grid grid-cols-12 items-center">
                                    <div class="col-span-5 flex items-center gap-3.5 cursor-pointer" onclick="openStaffDetailsModal(${staff.account_ID})">
                                        <div
                                            class="w-12 h-12 rounded-[5px] border border-neutral-200 flex justify-center items-center overflow-hidden">
                                            <div
                                                class="w-8 h-8 bg-[#F91D7C] flex items-center justify-center text-white font-bold">
                                                ${initials}
                                            </div>
                                        </div>
                                        <div class="text-black text-base font-normal font-poppins">${firstName} ${lastName}</div>
                                    </div>
                                    <div class="col-span-2 text-black text-base font-normal font-poppins cursor-pointer" onclick="openStaffDetailsModal(${staff.account_ID})">
                                        ${staff.role?.role_name || 'Staff'}
                                    </div>
                                    <div class="col-span-2 text-black text-base font-normal font-poppins cursor-pointer" onclick="openStaffDetailsModal(${staff.account_ID})">
                                        ${staff.branch?.branch_name || 'N/A'}
                                    </div>
                                    <div class="col-span-2 flex justify-center cursor-pointer" onclick="openStaffDetailsModal(${staff.account_ID})">
                                        <div class="w-24 p-2.5 bg-green-500/30 rounded-[5px] text-center">
                                            <span
                                                class="text-green-700 text-sm font-normal font-poppins">Active</span>
                                        </div>
                                    </div>
                                    <div class="col-span-1 flex items-center gap-3.5">
                                        <button class="text-green-600 hover:text-green-800" onclick="openEditStaffModalDirect(${staff.account_ID})">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" onclick="deleteStaff(${staff.account_ID})">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Update the table with the generated HTML
                    tableBody.innerHTML = html;
                }

                // Delete staff function
                window.deleteStaff = function(staffId) {
                    if (confirm('Are you sure you want to delete this staff member?')) {
                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                        fetch('/api/accounts/' + staffId, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(result) {
                            if (result.status === 'success') {
                                showStatus('Staff deleted successfully', 'success');
                                // Reload staff data
                                loadStaffData();
                            } else {
                                showStatus('Failed to delete staff: ' + (result.message || 'Unknown error'), 'error');
                            }
                        })
                        .catch(function(error) {
                            showStatus('Error deleting staff: ' + error.message, 'error');
                        });
                    }
                };

                // Set up search functionality
                const searchInput = document.getElementById('clinicSearchInput');
                if (searchInput) {
                    searchInput.addEventListener('input', function(event) {
                        const searchValue = event.target.value.toLowerCase();

                        const staffRows = document.querySelectorAll('#staffTableBody > div');
                        staffRows.forEach(function(row) {
                            const nameElement = row.querySelector('.col-span-5 .text-black');
                            const roleElement = row.querySelector('.col-span-2:nth-child(2)');
                            const branchElement = row.querySelector('.col-span-2:nth-child(3)');

                            if (nameElement && roleElement && branchElement) {
                                const name = nameElement.textContent.toLowerCase();
                                const role = roleElement.textContent.toLowerCase();
                                const branch = branchElement.textContent.toLowerCase();

                                const matches = name.includes(searchValue) || 
                                               role.includes(searchValue) || 
                                               branch.includes(searchValue);

                                row.style.display = matches ? '' : 'none';
                            }
                        });
                    });
                }

                // Start loading data immediately
                loadStaffData();
            })();
        </script>
@endsection

@php
    $activePage = 'staffs';
@endphp