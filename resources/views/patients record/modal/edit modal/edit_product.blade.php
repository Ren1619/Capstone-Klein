{{-- Edit Product Modal --}}
<div id="editProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="editModalOverlay"></div>

        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Edit</span> Product
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeEditModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <form id="editProductForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    {{-- Product Selection Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Product<span class="text-red-500">*</span>
                        </label>
                        <select id="editSelectedProduct" name="selectedProduct"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            required>
                            <option value="" disabled selected>Select Product</option>
                            @foreach($allProducts ?? [] as $product)
                                <option value="{{ $product->product_ID }}">{{ $product->name }} -
                                    ₱{{ number_format($product->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Notes Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="editProductNotes" name="productNotes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add any notes about this product">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</textarea>
                    </div>

                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Update
                        </button>
                        <button type="button" id="cancelEditBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const editProductModal = document.getElementById('editProductModal');
        const editModalOverlay = document.getElementById('editModalOverlay');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editProductForm = document.getElementById('editProductForm');
        
        // Find all edit buttons with the class
        const editProductButtons = document.querySelectorAll('.edit-product-btn');
        
        // Quantity Control Elements
        const decreaseQuantityBtn = document.getElementById('decreaseQuantityBtn');
        const increaseQuantityBtn = document.getElementById('increaseQuantityBtn');
        const editProductQuantity = document.getElementById('editProductQuantity');
        
        // Show notification function
        function showNotification(message, type = 'info') {
            // Toast notification implementation
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} text-white`;
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
            const requiredFields = editProductForm.querySelectorAll('[required]');
            
            // Clear all previous error states
            const allFields = editProductForm.querySelectorAll('input, select, textarea');
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
            
            return isValid === true;
        }
        
        // Quantity control event listeners
        if (decreaseQuantityBtn && editProductQuantity) {
            decreaseQuantityBtn.addEventListener('click', function() {
                if (parseInt(editProductQuantity.value) > 1) {
                    editProductQuantity.value = parseInt(editProductQuantity.value) - 1;
                }
            });
        }
        
        if (increaseQuantityBtn && editProductQuantity) {
            increaseQuantityBtn.addEventListener('click', function() {
                editProductQuantity.value = parseInt(editProductQuantity.value) + 1;
            });
        }
        
        // Input validation for quantity field - ensure positive value
        if (editProductQuantity) {
            editProductQuantity.addEventListener('input', function() {
                if (this.value < 1) this.value = 1;
            });
        }
        
        // Open Modal Function
        function openModal(productId, quantity, notes) {
            console.log('Opening product edit modal');
            
            // Set form values if data is provided
            if (productId) {
                const productSelect = document.getElementById('editSelectedProduct');
                if (productSelect) {
                    // Find the option with matching value
                    const option = Array.from(productSelect.options).find(opt => opt.value === productId);
                    if (option) option.selected = true;
                }
            }
            
            if (quantity) {
                document.getElementById('editProductQuantity').value = quantity;
            }
            
            if (notes) {
                document.getElementById('editProductNotes').value = notes;
            }
            
            // Show the modal
            editProductModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            editProductModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Clear any validation errors
            const errorMessages = editProductForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());
            
            const errorFields = editProductForm.querySelectorAll('.border-red-500');
            errorFields.forEach(field => field.classList.remove('border-red-500'));
        }
        
        // Handle form submission
        if (editProductForm) {
            editProductForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    showNotification('Please check the form for errors', 'error');
                    return;
                }
                
                // Collect product data
                const productData = {
                    productId: document.getElementById('editSelectedProduct').value,
                    quantity: document.getElementById('editProductQuantity').value,
                    notes: document.getElementById('editProductNotes').value
                };
                
                console.log('Product Data:', productData);
                
                // Show success and close modal
                showNotification('Product updated successfully!', 'success');
                closeModal();
                
                // Here you might want to update the UI with the new product data
                // location.reload(); // or update specific UI elements
            });
        }
        
        // Add click event to each edit button
        editProductButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const productId = this.getAttribute('data-product-id');
                const quantity = this.getAttribute('data-product-quantity');
                const notes = this.getAttribute('data-product-notes');
                
                // Open the modal with this product's data
                openModal(productId, quantity, notes);
                
                console.log('Opening modal for product ID:', productId);
            });
        });
        
        // Event Listeners for modal controls
        if (closeEditModalBtn) {
            closeEditModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeModal);
        }
        
        if (editModalOverlay) {
            editModalOverlay.addEventListener('click', function(e) {
                if (e.target === editModalOverlay) {
                    closeModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editProductModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Example function to programmatically open the modal (for testing)
        window.openEditProductModal = function(productId, quantity, notes) {
            openModal(productId, quantity, notes);
        };
    });
</script> -->