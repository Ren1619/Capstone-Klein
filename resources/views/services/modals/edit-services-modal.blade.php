<!-- Edit Service Modal -->
<div id="editServiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg w-full max-w-md mx-auto">
        <form id="editServiceForm" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-xl font-semibold">Edit Service</h5>
                    <button type="button" onclick="closeEditServiceModal()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <input type="hidden" name="service_ID" id="edit-service-id">
                <div class="mb-4">
                    <label for="edit-service-name" class="block text-gray-700 text-sm font-bold mb-2">Service
                        Name</label>
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
                        id="edit-service-name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="edit-service-category"
                        class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
                        id="edit-service-category" name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_ID }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit-service-description"
                        class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
                        id="edit-service-description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit-service-price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                    <input type="number"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
                        id="edit-service-price" name="price" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label for="edit-service-status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
                        id="edit-service-status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 rounded-b-lg flex justify-end">
                <button type="button" onclick="closeEditServiceModal()"
                    class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-[#F91D7C] text-white rounded hover:bg-[#F91D7C]/90 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditServiceModal(serviceId) {
        // Fetch service data using AJAX
        fetch(`/services/${serviceId}`)
            .then(response => response.json())
            .then(service => {
                // Populate the form with service data
                document.getElementById('edit-service-id').value = service.service_ID;
                document.getElementById('edit-service-name').value = service.name;
                document.getElementById('edit-service-description').value = service.description;
                document.getElementById('edit-service-price').value = service.price;

                // Set the correct category option
                const categorySelect = document.getElementById('edit-service-category');
                for (let i = 0; i < categorySelect.options.length; i++) {
                    if (categorySelect.options[i].value == service.category_ID) {
                        categorySelect.options[i].selected = true;
                        break;
                    }
                }

                // Set the correct status option
                const statusSelect = document.getElementById('edit-service-status');
                for (let i = 0; i < statusSelect.options.length; i++) {
                    if (statusSelect.options[i].value == service.status) {
                        statusSelect.options[i].selected = true;
                        break;
                    }
                }

                // Set the form action
                document.getElementById('editServiceForm').action = `/services/${service.service_ID}`;

                // Show the modal
                document.getElementById('editServiceModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching service data:', error);
                alert('Failed to load service data. Please try again.');
            });
    }

    function closeEditServiceModal() {
        document.getElementById('editServiceModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function (event) {
        const modal = document.getElementById('editServiceModal');
        const modalContent = modal.querySelector('.bg-white');

        if (!modal.classList.contains('hidden') && !modalContent.contains(event.target) && event.target !== modalContent) {
            closeEditServiceModal();
        }
    });
</script>