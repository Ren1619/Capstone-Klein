<!-- {{-- View Product Modal --}}
<div id="viewProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        {{-- Modal Background Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewModalOverlay"></div>
        
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Product
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewModalBtn" onclick="closeProductModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6">
                {{-- Product Information Display --}}
                <div class="space-y-6">
                    {{-- Product Selection Field --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Product</h4>
                        <p id="viewSelectedProduct" class="text-base font-medium text-gray-900">CeraVe Foaming Cleanser Normal to Oily Skin - ₱900.00</p>
                    </div>
                    
                    {{-- Quantity Field --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Quantity</h4>
                        <p id="viewProductQuantity" class="text-base font-medium text-gray-900">1</p>
                    </div>
                    
                    {{-- Notes Field --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="viewProductNotes" class="text-base text-black whitespace-pre-wrap">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const viewProductModal = document.getElementById('viewProductModal');
        const viewModalOverlay = document.getElementById('viewModalOverlay');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');
        
        // Find all view buttons with the class
        const viewProductButtons = document.querySelectorAll('.view-product-btn');
        
        // Product options mapping (for displaying product name based on ID)
        const productOptions = {
            "1": "CeraVe Foaming Cleanser Normal to Oily Skin - ₱900.00",
            "2": "Paula's Choice C5 Super Boost Moisturizer 15ml / 50ml - ₱700.00",
            "3": "Collagen Tone-Up Booster Cream - ₱690.99"
        };
        
        // Open Modal Function
        function openModal(productId, quantity, notes) {
            console.log('Opening product view modal');
            
            // Set display values
            if (productId) {
                const productName = productOptions[productId] || 'Unknown Product';
                document.getElementById('viewSelectedProduct').textContent = productName;
            }
            
            if (quantity) {
                document.getElementById('viewProductQuantity').textContent = quantity;
            }
            
            if (notes) {
                document.getElementById('viewProductNotes').textContent = notes || 'No notes available';
            }
            
            // Show the modal
            viewProductModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Close Modal Function
        function closeModal() {
            console.log('Closing product view modal');
            viewProductModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Create global close function for inline onclick
        window.closeProductModal = function() {
            closeModal();
            console.log('Modal closed via inline onclick handler');
        };
        
        // Add click event to each view button
        viewProductButtons.forEach(button => {
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
        if (closeViewModalBtn) {
            closeViewModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }
        
        if (viewModalOverlay) {
            viewModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewProductModal.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Example function to programmatically open the modal (for testing)
        window.openViewProductModal = function(productId, quantity, notes) {
            openModal(productId, quantity, notes);
        };
    });
</script> -->



<!-- View Product Modal -->
<div id="viewProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="viewModalOverlay"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Product
                </h3>
                
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <!-- Product Information Display -->
                <div class="space-y-6">
                    <!-- Product Selection Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Product</h4>
                        <p id="viewSelectedProduct" class="text-base font-medium text-gray-900">Loading product...</p>
                    </div>
                    
                    <!-- Price Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Price</h4>
                        <p id="viewProductPrice" class="text-base font-medium text-gray-900">Loading price...</p>
                    </div>
                    
                    <!-- Quantity Field -->
                    <!-- <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Quantity</h4>
                        <p id="viewProductQuantity" class="text-base font-medium text-gray-900">Loading quantity...</p>
                    </div>
                     -->
                    <!-- Notes Field -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="viewProductNotes" class="text-base text-black whitespace-pre-wrap">Loading notes...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const viewProductModal = document.getElementById('viewProductModal');
        const viewModalOverlay = document.getElementById('viewModalOverlay');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');
        
        // Find all view buttons with the class
        const viewProductButtons = document.querySelectorAll('.view-product-btn');
        console.log('Found view product buttons:', viewProductButtons.length);
        
        // Function to open view modal and load product data
        function openProductModal(visitProductId) {
            console.log('Opening view modal for visit product ID:', visitProductId);
            
            // Show loading state
            viewProductModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Set loading state for fields
            document.getElementById('viewSelectedProduct').textContent = 'Loading product...';
            document.getElementById('viewProductPrice').textContent = 'Loading price...';
            // document.getElementById('viewProductQuantity').textContent = 'Loading quantity...';
            document.getElementById('viewProductNotes').textContent = 'Loading notes...';
            
            // Fetch product data using the existing edit endpoint
            fetch(`/visit-products/${visitProductId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('View API Response Status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response Error Text:', text);
                        throw new Error(`Failed to fetch product details (Status: ${response.status})`);
                    });
                }
                return response.json();
            })
            .then(response => {
                if (response.success) {
                    const visitProduct = response.data;
                    console.log('Visit product data received:', visitProduct);
                    
                    // First try to get the product name from the product relationship
                    if (visitProduct.product) {
                        // Format price
                        const price = visitProduct.product.price 
                            ? parseFloat(visitProduct.product.price).toFixed(2) 
                            : '0.00';
                        
                        // Set product name
                        document.getElementById('viewSelectedProduct').textContent = 
                            visitProduct.product.name || 'Unknown Product';
                            
                        // Set product price
                        document.getElementById('viewProductPrice').textContent = `₱${price}`;
                    } else {
                        // If no product relationship, try to get product name from the products-data element
                        const productsDataElement = document.getElementById('products-data');
                        
                        if (productsDataElement && productsDataElement.dataset.products) {
                            try {
                                const productsData = JSON.parse(productsDataElement.dataset.products);
                                const product = productsData.find(p => p.product_ID == visitProduct.product_ID);
                                
                                if (product) {
                                    const price = product.price 
                                        ? parseFloat(product.price).toFixed(2) 
                                        : '0.00';
                                    
                                    document.getElementById('viewSelectedProduct').textContent = product.name;
                                    document.getElementById('viewProductPrice').textContent = `₱${price}`;
                                } else {
                                    document.getElementById('viewSelectedProduct').textContent = 
                                        `Product ID: ${visitProduct.product_ID}`;
                                    document.getElementById('viewProductPrice').textContent = 'Price not available';
                                }
                            } catch (e) {
                                console.error('Error parsing products data:', e);
                                document.getElementById('viewSelectedProduct').textContent = 
                                    `Product ID: ${visitProduct.product_ID}`;
                                document.getElementById('viewProductPrice').textContent = 'Price not available';
                            }
                        } else {
                            document.getElementById('viewSelectedProduct').textContent = 
                                `Product ID: ${visitProduct.product_ID}`;
                            document.getElementById('viewProductPrice').textContent = 'Price not available';
                        }
                    }
                    
                    // Set quantity
                    // document.getElementById('viewProductQuantity').textContent = 
                    //     visitProduct.quantity || '1';
                    
                    // // Debug: Log all possible note field names
                    // console.log('Note field check:', {
                    //     notes: visitProduct.note,
                    //     note: visitProduct.note,
                    //     comment: visitProduct.comment,
                    //     comments: visitProduct.comments,
                    //     description: visitProduct.description
                    // });
                    
                    // Try different possible field names for notes
                    const noteContent = 
                        visitProduct.note || // Check "notes" field
                      
                        'No notes provided';    // Default value
                    
                    // Display notes or placeholder
                    document.getElementById('viewProductNotes').textContent = noteContent;
                    
                } else {
                    throw new Error(response.message || 'Failed to load product details');
                }
            })
            .catch(error => {
                console.error('Error loading product:', error);
                
                // Show error in the modal
                document.getElementById('viewSelectedProduct').textContent = 'Error loading product';
                document.getElementById('viewProductPrice').textContent = 'Error';
                // document.getElementById('viewProductQuantity').textContent = 'Error';
                document.getElementById('viewProductNotes').textContent = error.message;
                
                // Optionally show error message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                }
            });
        }
        
        // Function to close modal
        function closeProductModal() {
            viewProductModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Make the close function available globally
        window.closeProductModal = closeProductModal;
        
        // Make the open function available globally with ID parameter
        window.openViewProductModal = openProductModal;
        
        // Add click event to each view button
        viewProductButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const visitProductId = this.getAttribute('data-id');
                if (!visitProductId) {
                    console.error('No data-id attribute found on view button');
                    return;
                }
                
                console.log('View button clicked for ID:', visitProductId);
                openProductModal(visitProductId);
            });
        });
        
        // Close modal with X button
        if (closeViewModalBtn) {
            closeViewModalBtn.addEventListener('click', closeProductModal);
        }
        
        // Close modal with overlay click
        if (viewModalOverlay) {
            viewModalOverlay.addEventListener('click', function(e) {
                if (e.target === viewModalOverlay) {
                    closeProductModal();
                }
            });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewProductModal.classList.contains('hidden')) {
                closeProductModal();
            }
        });
    });
</script>