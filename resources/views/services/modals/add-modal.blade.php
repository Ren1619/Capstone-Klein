<!-- Add Services -->
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-full p-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" onclick="closeCategoryModalDirect()"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl w-full sm:max-w-md mx-auto z-10 transform transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold">
                    <span class="modal-action text-[#F91D7C]">Add</span> Category
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeCategoryModalDirect()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <form id="addCategoryForm" class="modal-form">
                    <!-- Hidden field for storing category ID when editing -->
                    <input type="hidden" name="id" id="categoryId" value="">
                    
                    <!-- Required fields note -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            All fields with <span class="text-[#F91D7C]">*</span> are required.
                        </p>
                    </div>

                    <!-- Category Name Field -->
                    <div class="mb-4">
                        <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">
                            Category Name <span class="text-[#F91D7C]">*</span>
                        </label>
                        <input type="text" name="name" id="categoryName"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Category Name" required>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-4">
                        <label for="categoryDescription" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea id="categoryDescription" name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Briefly describe this category"></textarea>
                    </div>

                    <!-- Status Note -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-500">Categories are always active by default.</p>
                    </div>

                    <!-- Button Actions -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit"
                            class="w-36 h-10 flex items-center justify-center bg-[#F91D7C] hover:bg-[#F91D7C]/90 text-white font-medium rounded-md transition-colors save-btn">
                            Save Category
                        </button>
                        <button type="button"
                            class="w-36 h-10 flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors"
                            onclick="closeCategoryModalDirect()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div id="addServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-full p-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" onclick="closeServiceModalDirect()"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl w-full sm:max-w-md mx-auto z-10 transform transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold">
                    <span class="modal-action text-[#F91D7C]">Add</span> Service
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeServiceModalDirect()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <form id="addServiceForm" class="modal-form" method="POST" action="{{ route('services.store') }}">
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
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_ID }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                            onclick="closeServiceModalDirect()">
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
        // Modal elements
        const categoryModal = document.getElementById('addCategoryModal');
        const serviceModal = document.getElementById('addServiceModal');
        const serviceForm = document.getElementById('addServiceForm');
        const categoryForm = document.getElementById('addCategoryForm');
        const methodField = document.getElementById('methodField');
        
        // Status toggle functionality
        const statusToggle = document.getElementById('statusToggle');
        const statusHidden = document.getElementById('statusHidden');
        
        if (statusToggle && statusHidden) {
            statusToggle.addEventListener('change', function() {
                statusHidden.value = this.checked ? 'active' : 'inactive';
            });
        }
        
        // Category form submission
        if (categoryForm) {
            categoryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(categoryForm);
                const categoryId = formData.get('id');
                const url = categoryId ? `/api/service-categories/${categoryId}` : '/api/service-categories';
                const method = categoryId ? 'PUT' : 'POST';
                
                // Show loading state
                const saveBtn = categoryForm.querySelector('.save-btn');
                const originalText = saveBtn.textContent;
                saveBtn.disabled = true;
                saveBtn.textContent = 'Saving...';
                
                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        description: formData.get('description')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Reload the page to show updated data
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.textContent = originalText;
                    closeCategoryModalDirect();
                });
            });
        }
        
        // Function to set form for editing service
        function editServiceForm(service) {
            // Set hidden ID field
            document.getElementById('serviceId').value = service.service_ID;
            
            // Update form fields
            document.getElementById('serviceName').value = service.name;
            document.getElementById('serviceCategory').value = service.category_ID;
            document.getElementById('servicePrice').value = service.price;
            document.getElementById('serviceDescription').value = service.description || '';
            
            // Set status toggle
            const statusToggle = document.getElementById('statusToggle');
            const statusHidden = document.getElementById('statusHidden');
            
            if (statusToggle && statusHidden) {
                statusToggle.checked = service.status === 'active';
                statusHidden.value = service.status;
            }
            
            // Change form method to PUT
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            serviceForm.action = `/services/${service.service_ID}`;
            
            // Update modal title and button text
            document.querySelector('#addServiceModal .modal-action').textContent = 'Edit';
            document.querySelector('#addServiceModal .save-btn').textContent = 'Update Service';
        }
        
        // Global functions for modal handling
        // These are the core opening functions used by the direct functions below
        window.openCategoryModal = function(mode = 'add', data = null) {
            if (categoryModal) {
                categoryModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                const actionText = document.querySelector('#addCategoryModal .modal-action');
                const saveBtn = document.querySelector('#addCategoryModal .save-btn');
                
                if (mode === 'edit' && data) {
                    actionText.textContent = 'Edit';
                    saveBtn.textContent = 'Update Category';
                    
                    // Populate form fields
                    document.getElementById('categoryId').value = data.id;
                    document.getElementById('categoryName').value = data.name;
                    document.getElementById('categoryDescription').value = data.description || '';
                } else {
                    actionText.textContent = 'Add';
                    saveBtn.textContent = 'Save Category';
                    
                    // Reset form
                    categoryForm.reset();
                    document.getElementById('categoryId').value = '';
                }
            }
        };
        
        window.openServiceModal = function(mode = 'add', data = null) {
            if (serviceModal) {
                serviceModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                if (mode === 'edit' && data) {
                    editServiceForm(data);
                } else {
                    // Reset form for adding
                    serviceForm.reset();
                    document.getElementById('serviceId').value = '';
                    methodField.innerHTML = '';
                    serviceForm.action = "{{ route('services.store') }}";
                    
                    // Reset title and button text
                    document.querySelector('#addServiceModal .modal-action').textContent = 'Add';
                    document.querySelector('#addServiceModal .save-btn').textContent = 'Save Service';
                    
                    // Set default status to active
                    statusToggle.checked = true;
                    statusHidden.value = 'active';
                }
            }
        };
        
        // Add escape key handler to close all modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCategoryModalDirect();
                closeServiceModalDirect();
            }
        });
    });
    
    // Direct modal control functions for Service Modal
    window.openServiceModalDirect = function() {
        window.openServiceModal('add');
    };

    window.openEditServiceModalDirect = function(serviceId) {
        fetch(`/services/${serviceId}`)
            .then(response => response.json())
            .then(service => {
                window.openServiceModal('edit', service);
            })
            .catch(error => {
                console.error('Error fetching service:', error);
                alert('Error loading service data. Please try again.');
            });
    };

    window.closeServiceModalDirect = function() {
        const serviceModal = document.getElementById('addServiceModal');
        if (serviceModal) {
            serviceModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset forms
            const serviceForm = document.getElementById('addServiceForm');
            if (serviceForm) serviceForm.reset();
            
            // Reset modal titles and buttons
            document.querySelector('#addServiceModal .modal-action').textContent = 'Add';
            document.querySelector('#addServiceModal .save-btn').textContent = 'Save Service';
            
            // Reset method field
            const methodField = document.getElementById('methodField');
            if (methodField) methodField.innerHTML = '';
            
            // Reset form action
            if (serviceForm) serviceForm.action = "{{ route('services.store') }}";
        }
    };
    
    // Direct modal control functions for Category Modal
    window.openCategoryModalDirect = function() {
        window.openCategoryModal('add');
    };

    window.openEditCategoryModalDirect = function(categoryId) {
        fetch(`/api/service-categories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.openCategoryModal('edit', data.category);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching category:', error);
                alert('Error loading category data. Please try again.');
            });
    };

    window.closeCategoryModalDirect = function() {
        const categoryModal = document.getElementById('addCategoryModal');
        if (categoryModal) {
            categoryModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset forms
            const categoryForm = document.getElementById('addCategoryForm');
            if (categoryForm) categoryForm.reset();
            
            // Reset modal titles and buttons
            document.querySelector('#addCategoryModal .modal-action').textContent = 'Add';
            document.querySelector('#addCategoryModal .save-btn').textContent = 'Save Category';
            
            // Reset ID field
            document.getElementById('categoryId').value = '';
        }
    };
</script>