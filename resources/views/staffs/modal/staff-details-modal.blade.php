{{-- components/staff-details-modal.blade.php --}}

<!-- Staff Details Modal -->
<div id="staffDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Light overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-10 transition-opacity" id="detailsModalOverlay"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-auto z-10 px-4 sm:px-8 py-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl sm:text-2xl font-bold">
                    Staff <span class="text-[#F91D7C]">Details</span>
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeDetailsModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Staff Profile -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start mb-6">
                <!-- Profile Picture -->
                <div
                    class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border border-gray-200 flex justify-center items-center overflow-hidden bg-gray-100 mb-4 sm:mb-0 sm:mr-6">
                    <div id="details-profile-image" class="w-full h-full flex items-center justify-center">
                        <div id="details-initials"
                            class="w-20 h-20 bg-[#F91D7C] flex items-center justify-center text-white text-2xl font-bold">
                            --
                        </div>
                    </div>
                </div>

                <!-- Basic Details -->
                <div class="text-center sm:text-left">
                    <h4 id="details-name" class="text-xl font-semibold mb-2">Loading...</h4>
                    <div class="flex flex-col sm:flex-row sm:items-center text-gray-600 mb-1">
                        <span id="details-role" class="font-medium">Loading...</span>
                        <span class="hidden sm:inline mx-2">•</span>
                        <span id="details-branch">Loading...</span>
                    </div>
                    <div class="mb-4">
                        <span id="details-status"
                            class="inline-block px-3 py-1 bg-green-500/30 rounded-[5px] text-center text-green-700 text-sm">
                            Active
                        </span>
                    </div>
                    <button id="details-edit-btn" class="px-4 py-1.5 bg-[#F91D7C] text-white rounded text-sm">
                        Edit Staff
                    </button>
                </div>
            </div>

            <!-- Staff Details Sections -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium mb-4">Personal Information</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-fullname" class="font-medium">Loading...</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-email" class="font-medium">Loading...</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-contact" class="font-medium">Loading...</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Join Date</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-join-date" class="font-medium">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium mb-4">Work Information</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Branch</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-branch-info" class="font-medium">Loading...</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-role-info" class="font-medium">Loading...</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Account ID</p>
                        <div class="border border-gray-300 rounded px-3 py-2 mt-1">
                            <p id="details-account-id" class="font-medium">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const elements = {
            modal: document.getElementById('staffDetailsModal'),
            overlay: document.getElementById('detailsModalOverlay'),
            closeBtn: document.getElementById('closeDetailsModalBtn'),
            editBtn: document.getElementById('details-edit-btn')
        };

        // API endpoints
        const apiEndpoints = {
            accounts: '/api/accounts'
        };

        // Open modal for showing staff details
        window.openStaffDetailsModal = function (staffId) {
            elements.modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Reset to loading state
            resetModalContent();

            // Fetch account data from API
            fetch(`${apiEndpoints.accounts}/${staffId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        populateDetailsModal(data.data);

                        // Update edit button
                        elements.editBtn.onclick = function () {
                            closeDetailsModal();
                            openEditStaffModal(staffId);
                        };
                    } else {
                        showError('Failed to load staff details');
                    }
                })
                .catch(error => {
                    console.error('Error fetching account details:', error);
                    showError('Failed to load staff details');
                });
        };

        // Function to close the details modal
        function closeDetailsModal() {
            elements.modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal event listeners
        [elements.closeBtn, elements.overlay].forEach(el => {
            if (el) el.addEventListener('click', closeDetailsModal);
        });

        // Prevent modal close when clicking inside modal content
        elements.modal.querySelector('.relative.bg-white').addEventListener('click', e => e.stopPropagation());

        // Reset modal content to loading state
        function resetModalContent() {
            document.getElementById('details-name').textContent = 'Loading...';
            document.getElementById('details-role').textContent = 'Loading...';
            document.getElementById('details-branch').textContent = 'Loading...';
            document.getElementById('details-fullname').textContent = 'Loading...';
            document.getElementById('details-email').textContent = 'Loading...';
            document.getElementById('details-contact').textContent = 'Loading...';
            document.getElementById('details-join-date').textContent = 'Loading...';
            document.getElementById('details-branch-info').textContent = 'Loading...';
            document.getElementById('details-role-info').textContent = 'Loading...';
            document.getElementById('details-account-id').textContent = 'Loading...';
            document.getElementById('details-initials').textContent = '--';
        }

        // Function to populate details modal with staff data
        function populateDetailsModal(data) {
            // Get initials
            const firstInitial = data.first_name ? data.first_name.charAt(0).toUpperCase() : '';
            const lastInitial = data.last_name ? data.last_name.charAt(0).toUpperCase() : '';
            const initials = firstInitial + lastInitial;

            // Set text content for each field
            const fullName = `${data.first_name || ''} ${data.last_name || ''}`.trim();
            document.getElementById('details-name').textContent = fullName;
            document.getElementById('details-fullname').textContent = fullName;
            document.getElementById('details-role').textContent = data.role?.role_name || 'N/A';
            document.getElementById('details-branch').textContent = data.branch?.branch_name || 'N/A';
            document.getElementById('details-role-info').textContent = data.role?.role_name || 'N/A';
            document.getElementById('details-branch-info').textContent = data.branch?.branch_name || 'N/A';
            document.getElementById('details-email').textContent = data.email || 'N/A';
            document.getElementById('details-contact').textContent = data.contact_number || 'N/A';
            document.getElementById('details-account-id').textContent = `ACC-${data.account_ID}`;

            // Format join date (created_at)
            const joinDate = data.created_at ? new Date(data.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : 'N/A';
            document.getElementById('details-join-date').textContent = joinDate;

            // Update initials
            document.getElementById('details-initials').textContent = initials;

            // Status is always active for this prototype
            const statusElement = document.getElementById('details-status');
            statusElement.textContent = 'Active';
            statusElement.className = 'inline-block px-3 py-1 bg-green-500/30 rounded-[5px] text-center text-green-700 text-sm';
        }

        // Close modal on escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !elements.modal.classList.contains('hidden')) {
                closeDetailsModal();
            }
        });

        // Utility function
        function showError(message) {
            alert(message);
        }
    });
</script>