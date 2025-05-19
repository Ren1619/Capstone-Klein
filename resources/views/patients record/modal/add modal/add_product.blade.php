{{-- Button to open modal --}}
{{-- <button id="addProductBtn" class="bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
    Add Product
</button> --}}

<!-- {{-- Add Product Modal --}}
<div id="addProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
        
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Product
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6">
                <form id="productForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>
                    
                    {{-- Product Selection Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Product<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="selectedProduct" name="selectedProduct" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                            <option value="" disabled selected>Select Product</option>
                            <option value="1">CeraVe Foaming Cleanser Normal to Oily Skin - ₱900.00</option>
                            <option value="2">Paula\'s Choice C5 Super Boost Moisturizer 15ml / 50ml - ₱700.00</option>
                            <option value="3">Collagen Tone-Up Booster Cream - ₱690.99</option>

                        </select>
                    </div>
                    
                    {{-- Quantity Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Quantity<span class="text-[#F91D7C]">*</span>
                        </label>
                        <div class="flex items-center">
                            <button type="button" id="decreaseQuantityBtn" class="px-3 py-2 border border-gray-300 rounded-l-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="productQuantity" name="productQuantity" class="w-full text-center px-3 py-2 border-t border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" value="1" min="1" required>
                            <button type="button" id="increaseQuantityBtn" class="px-3 py-2 border border-gray-300 rounded-r-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Discount Field --}}
                    {{-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Discount (%)
                        </label>
                        <input type="number" id="productDiscount" name="productDiscount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="0" min="0" max="100" value="0">
                    </div> --}}
                    
                    {{-- Payment Status Field --}}
                    {{-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Payment Status
                        </label>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="paymentStatus" value="paid" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                                <span class="ml-2 text-sm text-gray-700">Paid</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="paymentStatus" value="unpaid" class="form-radio h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]" checked>
                                <span class="ml-2 text-sm text-gray-700">Unpaid</span>
                            </label>
                        </div>
                    </div> --}}
                    
                    {{-- Notes Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="productNotes" name="productNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Add any notes about this product"></textarea>
                    </div>
                    
                    {{-- Button Actions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal JavaScript - Directly embedded within the component --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const addProductModal = document.getElementById('addProductModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const productForm = document.getElementById('productForm');
        const addProductBtn = document.getElementById('addProductBtn');
        
        // Quantity Control Elements
        const decreaseQuantityBtn = document.getElementById('decreaseQuantityBtn');
        const increaseQuantityBtn = document.getElementById('increaseQuantityBtn');
        const productQuantity = document.getElementById('productQuantity');
        
        // Open Modal Function
        function openModal() {
            addProductModal.classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            addProductModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            // Reset form
            if (productForm) {
                productForm.reset();
                if (productQuantity) {
                    productQuantity.value = 1;
                }
            }
        }
        
        // Event Listeners for opening modal
        if (addProductBtn) {
            addProductBtn.addEventListener('click', openModal);
        }
        
        // Event Listeners for closing modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
        
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }
        
        // Quantity control event listeners
        if (decreaseQuantityBtn && productQuantity) {
            decreaseQuantityBtn.addEventListener('click', function() {
                if (parseInt(productQuantity.value) > 1) {
                    productQuantity.value = parseInt(productQuantity.value) - 1;
                }
            });
        }
        
        if (increaseQuantityBtn && productQuantity) {
            increaseQuantityBtn.addEventListener('click', function() {
                productQuantity.value = parseInt(productQuantity.value) + 1;
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !addProductModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Form Submission
        if (productForm) {
            productForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically send the form data to your server
                // using fetch or axios
                
                // Example of collecting form data
                const formData = new FormData(productForm);
                const productData = {};
                
                for (const [key, value] of formData.entries()) {
                    productData[key] = value;
                }
                
                console.log('Product Data:', productData);
                
                // Show success message or redirect
                // alert('Product added successfully!');
                closeModal();
                
                // Optionally refresh the product list
                // location.reload();
            });
        }
        
        // Input validation for quantity field - ensure positive value
        if (productQuantity) {
            productQuantity.addEventListener('input', function() {
                if (this.value < 1) this.value = 1;
            });
        }
        
        // Input validation for discount field - ensure between 0 and 100
        const discountInput = document.getElementById('productDiscount');
        if (discountInput) {
            discountInput.addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
                if (this.value > 100) this.value = 100;
            });
        }
    });
</script> -->









{{-- Add Product Modal --}}
<div id="addProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Add</span> Product
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="productForm">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-red-500">*</span> are required.
                        </p>
                    </div>

                    <!-- Hidden Visit ID Field -->
                    <input type="hidden" id="visit_ID" name="visit_ID"
                        value="{{ $visit->visit_ID ?? request()->route('visit') ?? request()->input('visit_id') ?? '' }}">
                        
                    <!-- Hidden Quantity Field (default to 1) -->
                    <input type="hidden" id="quantity" name="quantity" value="1">

                    <!-- Product Selection Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Product<span class="text-[#F91D7C]">*</span>
                        </label>
                        <select id="product_ID" name="product_ID"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            required>
                            <option value="" disabled selected>Select Product</option>
                            @foreach($allProducts ?? [] as $product)
                                <option value="{{ $product->product_ID }}">{{ $product->name }} -
                                    ₱{{ number_format($product->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea id="note" name="note" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            placeholder="Add any notes about this product"></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Add
                        </button>
                        <button type="button" id="cancelBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

