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
                    <input type="text" id="clinicSearchInput" class="flex-1 bg-transparent outline-none text-sm ml-2" placeholder="Search Staff...">
                </div>

                <div class="flex justify-end items-center w-full sm:w-auto">
                    <button onclick="openStaffModal()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] rounded-[5px] flex items-center gap-3.5 text-white w-full sm:w-auto justify-center sm:justify-start">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Staff">
                        <span class="text-sm font-normal font-poppins">Staff</span>
                    </button>
                </div>
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
                        <!-- Staff rows will be loaded here via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 sm:px-7 py-3.5 flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0" id="paginationSection">
                        <!-- Pagination content will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('staffs.modal.staff-modal')
    @include('staffs.modal.staff-details-modal')
@endsection

@php
    $activePage = 'staffs'; // Set the active page for this specific view
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const config = {
        apiUrl: '/api/accounts',
        rolesUrl: '/api/roles',  // You'll need to create this route
        branchesUrl: '/api/branches'  // You'll need to create this route
    };

    // State
    let currentPage = 1;
    let searchTerm = '';
    let accounts = [];
    let roles = [];
    let branches = [];

    // Load initial data
    fetchAccounts();
    fetchRoles();
    fetchBranches();

    // Search functionality
    document.getElementById('clinicSearchInput')?.addEventListener('input', function(e) {
        searchTerm = e.target.value.toLowerCase();
        filterAndDisplayAccounts();
    });

    // Fetch accounts from API
    function fetchAccounts(page = 1) {
        currentPage = page;
        
        fetch(`${config.apiUrl}?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    accounts = data.data.data;
                    renderAccountsTable(accounts);
                    renderPagination(data.data);
                }
            })
            .catch(error => {
                console.error('Error fetching accounts:', error);
                showError('Failed to load staff data');
            });
    }

    // Fetch roles
    function fetchRoles() {
        fetch(config.rolesUrl)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    roles = data.data;
                    populateRoleDropdown();
                }
            })
            .catch(error => console.error('Error fetching roles:', error));
    }

    // Fetch branches
    function fetchBranches() {
        fetch(config.branchesUrl)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    branches = data.data;
                    populateBranchDropdown();
                }
            })
            .catch(error => console.error('Error fetching branches:', error));
    }

    // Render accounts table
    function renderAccountsTable(accountsList) {
        const tableBody = document.getElementById('staffTableBody');
        if (!tableBody) return;

        tableBody.innerHTML = accountsList.map(account => {
            const initials = getInitials(account.first_name, account.last_name);
            return createAccountRow(account, initials);
        }).join('');
    }

    // Create account row HTML
    function createAccountRow(account, initials) {
        return `
            <div class="px-4 sm:px-7 py-3.5 border-b border-neutral-200 hover:bg-[#F91D7C]/10">
                <!-- Mobile View -->
                <div class="block sm:hidden">
                    <div class="flex items-start mb-2 cursor-pointer" onclick="openStaffDetailsModal(${account.account_ID})">
                        <div
                            class="w-12 h-12 rounded-[5px] border border-neutral-200 flex justify-center items-center overflow-hidden mr-3">
                            <div
                                class="w-8 h-8 bg-[#F91D7C] flex items-center justify-center text-white font-bold">
                                ${initials}
                            </div>
                        </div>
                        <div>
                            <div class="text-black text-base font-normal font-poppins">${account.first_name} ${account.last_name}
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-gray-500 text-sm">${account.role?.role_name || 'N/A'}</span>
                                <span class="text-gray-500 text-sm ml-2">${account.branch?.branch_name || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-24 p-2 bg-green-500/30 rounded-[5px] text-center">
                            <span
                                class="text-green-700 text-sm font-normal font-poppins">Active</span>
                        </div>
                        <div class="flex items-center gap-3.5">
                            <button class="text-green-600 hover:text-green-800" onclick="openEditStaffModal(${account.account_ID})">
                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                            </button>
                            <button class="text-red-600 hover:text-red-800" onclick="deleteAccount(${account.account_ID})">
                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Desktop View -->
                <div class="hidden sm:grid grid-cols-12 items-center">
                    <div class="col-span-5 flex items-center gap-3.5 cursor-pointer" onclick="openStaffDetailsModal(${account.account_ID})">
                        <div
                            class="w-12 h-12 rounded-[5px] border border-neutral-200 flex justify-center items-center overflow-hidden">
                            <div
                                class="w-8 h-8 bg-[#F91D7C] flex items-center justify-center text-white font-bold">
                                ${initials}
                            </div>
                        </div>
                        <div class="text-black text-base font-normal font-poppins">${account.first_name} ${account.last_name}</div>
                    </div>
                    <div class="col-span-2 text-black text-base font-normal font-poppins cursor-pointer" onclick="openStaffDetailsModal(${account.account_ID})">
                        ${account.role?.role_name || 'N/A'}
                    </div>
                    <div class="col-span-2 text-black text-base font-normal font-poppins cursor-pointer" onclick="openStaffDetailsModal(${account.account_ID})">
                        ${account.branch?.branch_name || 'N/A'}
                    </div>
                    <div class="col-span-2 flex justify-center cursor-pointer" onclick="openStaffDetailsModal(${account.account_ID})">
                        <div class="w-24 p-2.5 bg-green-500/30 rounded-[5px] text-center">
                            <span
                                class="text-green-700 text-sm font-normal font-poppins">Active</span>
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center gap-3.5">
                        <button class="text-green-600 hover:text-green-800" onclick="openEditStaffModal(${account.account_ID})">
                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                        </button>
                        <button class="text-red-600 hover:text-red-800" onclick="deleteAccount(${account.account_ID})">
                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Render pagination
    function renderPagination(paginationData) {
        const paginationSection = document.getElementById('paginationSection');
        if (!paginationSection) return;

        const pages = generatePageNumbers(paginationData.current_page, paginationData.last_page);
        
        paginationSection.innerHTML = `
            <div class="text-black text-sm font-normal font-poppins text-center sm:text-left">
                Showing ${paginationData.from || 0} to ${paginationData.to || 0} of ${paginationData.total} results
            </div>
            <div class="flex flex-wrap items-center gap-2.5 justify-center">
                <button onclick="fetchAccounts(${paginationData.current_page - 1})"
                    class="w-20 px-2.5 py-[5px] rounded-[5px] border border-neutral-200 text-neutral-500 text-sm font-normal font-poppins"
                    ${paginationData.current_page === 1 ? 'disabled' : ''}>
                    Previous
                </button>
                ${pages}
                <button onclick="fetchAccounts(${paginationData.current_page + 1})"
                    class="w-11 px-2.5 py-[5px] rounded-[5px] border border-neutral-200 text-neutral-500 text-sm font-normal font-poppins"
                    ${paginationData.current_page === paginationData.last_page ? 'disabled' : ''}>
                    Next
                </button>
            </div>
        `;
    }

    // Generate page numbers
    function generatePageNumbers(current, last) {
        let pages = '';
        const start = Math.max(1, current - 1);
        const end = Math.min(last, current + 1);
        
        for (let i = start; i <= end; i++) {
            const activeClass = i === current ? 'bg-[#F91D7C] text-white' : 'bg-white border border-neutral-200 text-neutral-500';
            pages += `
                <button onclick="fetchAccounts(${i})"
                    class="w-7 px-2.5 py-[5px] rounded-[5px] ${activeClass} text-sm font-normal font-poppins">
                    ${i}
                </button>
            `;
        }
        return pages;
    }

    // Get initials from name
    function getInitials(firstName, lastName) {
        const firstInitial = firstName ? firstName.charAt(0).toUpperCase() : '';
        const lastInitial = lastName ? lastName.charAt(0).toUpperCase() : '';
        return firstInitial + lastInitial;
    }

    // Filter and display accounts based on search
    function filterAndDisplayAccounts() {
        const filteredAccounts = accounts.filter(account => {
            const fullName = `${account.first_name} ${account.last_name}`.toLowerCase();
            const roleName = account.role?.role_name?.toLowerCase() || '';
            const branchName = account.branch?.branch_name?.toLowerCase() || '';
            
            return fullName.includes(searchTerm) || 
                   roleName.includes(searchTerm) || 
                   branchName.includes(searchTerm);
        });
        
        renderAccountsTable(filteredAccounts);
    }

    // Delete account
    window.deleteAccount = function(accountId) {
        if (confirm('Are you sure you want to delete this staff member?')) {
            fetch(`${config.apiUrl}/${accountId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccess(data.message);
                    fetchAccounts(currentPage);
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting account:', error);
                showError('Failed to delete staff member');
            });
        }
    };

    // Show error message
    function showError(message) {
        // Implement your error notification here
        alert(message);
    }

    // Show success message
    function showSuccess(message) {
        // Implement your success notification here
        alert(message);
    }

    // Populate dropdowns
    function populateRoleDropdown() {
        const roleSelect = document.getElementById('role');
        if (!roleSelect) return;

        roleSelect.innerHTML = '<option value="" disabled selected>Select Role</option>';
        roles.forEach(role => {
            const option = document.createElement('option');
            option.value = role.role_ID;
            option.textContent = role.role_name;
            roleSelect.appendChild(option);
        });
    }

    function populateBranchDropdown() {
        const branchSelect = document.getElementById('branch');
        if (!branchSelect) return;

        branchSelect.innerHTML = '<option value="" disabled selected>Select Branch</option>';
        branches.forEach(branch => {
            const option = document.createElement('option');
            option.value = branch.branch_ID;
            option.textContent = branch.branch_name;
            branchSelect.appendChild(option);
        });
    }
});
</script>
@endpush