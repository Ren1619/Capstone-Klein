<!-- Service Modal -->
<div id="serviceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-full p-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" data-modal-close="service"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl w-full sm:max-w-md mx-auto z-10 transform transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold">
                    <span class="modal-action text-[#F91D7C]">Add</span> Service
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-close="service"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <form id="serviceForm" class="modal-form" method="POST" action="{{ route('services.store') }}">
                    @csrf
                    <div id="methodField"></div>

                    <!-- Hidden field for storing service ID when editing -->
                    <input type="hidden" name="id" id="serviceId" value="">

                    <!-- Required fields note -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            All fields with <span class="text-[#F91D7C]">*</span> are required.
                        </p>
                    </div>

                    <!-- Service Name Field -->
                    <div class="mb-4">
                        <label for="serviceName" class="block text-sm font-medium text-gray-700 mb-1">
                            Service Name <span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" name="name" id="serviceName"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Service Name" required>
                    </div>

                    <!-- Category and Price Fields -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Category Dropdown -->
                        <div>
                            <label for="serviceCategory" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="relative mt-1">
                                <select id="serviceCategory" name="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent appearance-none"
                                    required>
                                    <option value="" disabled selected>Select a category</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Price Field -->
                        <div>
                            <label for="servicePrice" class="block text-sm font-medium text-gray-700 mb-1">
                                Price <span class="text-[#F91D7C]">*</span>
                            </label>
                            <div class="flex items-center mt-1">
                                <div class="flex items-center justify-center mr-2">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" name="price" id="servicePrice"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                                    placeholder="0.00" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    <!-- Description Field -->
                    <div class="mb-4">
                        <label for="serviceDescription" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea id="serviceDescription" name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Briefly describe what this service is for"></textarea>
                    </div>

                    <!-- Status Field with toggle switch -->
                    <div class="mb-6">
                        <label for="statusToggle" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500">Inactive</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="statusToggle" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#F91D7C]/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#F91D7C]">
                                </div>
                            </label>
                            <span class="text-sm font-medium text-gray-700">Active</span>
                            <input type="hidden" id="statusHidden" name="status" value="active">
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit" id="submitBtn"
                            class="w-36 h-10 flex items-center justify-center bg-[#F91D7C] hover:bg-[#F91D7C]/90 text-white font-medium rounded-md transition-colors save-btn">
                            Save Service
                        </button>
                        <button type="button"
                            class="w-36 h-10 flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors"
                            data-modal-close="service">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Dropdown styling enhancements */
    select {
        appearance: none;
        background-color: white;
    }

    /* Fix for dropdown options displaying properly */
    select option {
        background-color: white;
        color: #333;
        padding: 6px 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize modal elements
        const serviceModal = document.getElementById('serviceModal');
        const serviceForm = document.getElementById('serviceForm');
        const methodField = document.getElementById('methodField');
        const statusToggle = document.getElementById('statusToggle');
        const statusHidden = document.getElementById('statusHidden');

        // Set up status toggle functionality
        if (statusToggle && statusHidden) {
            statusToggle.addEventListener('change', function () {
                statusHidden.value = this.checked ? 'active' : 'inactive';
            });
        }

        // Load service categories on page load
        loadServiceCategories();

        // Add event listeners for all modal close buttons
        document.querySelectorAll('[data-modal-close="service"]').forEach(element => {
            element.addEventListener('click', function () {
                closeServiceModal();
            });
        });

        // Add escape key handler
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !serviceModal.classList.contains('hidden')) {
                closeServiceModal();
            }
        });

        // Expose modal functions to window
        window.openServiceModal = function () {
            openServiceModal('add');
        };

        window.openEditServiceModal = function (serviceId) {
            fetchService(serviceId)
                .then(service => {
                    if (service) {
                        openServiceModal('edit', service);
                    }
                });
        };

        window.closeServiceModal = closeServiceModal;

        // Service modal functions
        function openServiceModal(mode = 'add', data = null) {
            if (!serviceModal) return;

            serviceModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Reset form first
            serviceForm.reset();

            const actionText = serviceModal.querySelector('.modal-action');
            const saveBtn = serviceModal.querySelector('.save-btn');

            if (mode === 'edit' && data) {
                // Set for editing mode
                actionText.textContent = 'Edit';
                saveBtn.textContent = 'Update Service';
                populateServiceForm(data);
            } else {
                // Set for adding mode
                actionText.textContent = 'Add';
                saveBtn.textContent = 'Save Service';

                // Reset form fields
                document.getElementById('serviceId').value = '';
                methodField.innerHTML = '';
                serviceForm.action = "{{ route('services.store') }}";

                // Set default status to active
                statusToggle.checked = true;
                statusHidden.value = 'active';
            }
        }

        function closeServiceModal() {
            if (!serviceModal) return;

            serviceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Reset form and fields
            serviceForm.reset();
            document.getElementById('serviceId').value = '';
            methodField.innerHTML = '';
            serviceForm.action = "{{ route('services.store') }}";

            // Reset modal title and button
            serviceModal.querySelector('.modal-action').textContent = 'Add';
            serviceModal.querySelector('.save-btn').textContent = 'Save Service';
        }

        function populateServiceForm(service) {
            document.getElementById('serviceId').value = service.service_ID;
            document.getElementById('serviceName').value = service.name;
            document.getElementById('serviceCategory').value = service.category_ID;
            document.getElementById('servicePrice').value = service.price;
            document.getElementById('serviceDescription').value = service.description || '';

            // Set status toggle
            statusToggle.checked = service.status === 'active';
            statusHidden.value = service.status;

            // Change form method to PUT
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            serviceForm.action = `/services/${service.service_ID}`;
        }

        // Helper functions
        function loadServiceCategories() {
            fetch('/api/categories/type/service')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(categories => {
                    const categorySelect = document.getElementById('serviceCategory');
                    // Clear existing options except the first one
                    while (categorySelect.options.length > 1) {
                        categorySelect.remove(1);
                    }

                    // Add categories from API
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        // Use the correct property name from your Category model
                        option.value = category.category_ID;  // Changed from category.id
                        option.text = category.category_name;
                        categorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                });
        }

        function fetchService(serviceId) {
            return fetch(`/services/${serviceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('Error fetching service:', error);
                    alert('Error loading service data. Please try again.');
                    return null;
                });
        }
    });
</script>