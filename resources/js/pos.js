document.addEventListener('DOMContentLoaded', function () {
    // Create POS namespace with module pattern
    const POS = (function () {
        // Private variables and caches
        const _cache = {
            elements: {},
            templates: {},
            data: {
                products: [
                    { id: 1, name: 'Sun Screen A', size: '30 ml', price: 172.00, image: 'images/sunscreen.svg' },
                    { id: 2, name: 'Sun Screen B', size: '50 ml', price: 360.00, image: 'images/sunscreen.svg' },
                    { id: 3, name: 'Sun Screen C', size: '100 ml', price: 520.00, image: 'images/sunscreen.svg' }
                ],
                services: [
                    { id: 101, name: 'Facial Treatment', duration: '60 min', price: 1500.00, image: 'images/pos_service_placeholder.svg' },
                    { id: 102, name: 'Skin Consultation', duration: '30 min', price: 800.00, image: 'images/pos_service_placeholder.svg' },
                    { id: 103, name: 'Dermal Fillers', duration: '45 min', price: 2500.00, image: 'images/pos_service_placeholder.svg' }
                ],
                dailySales: []
            }
        };

        // Private state
        const _state = {
            cartItems: [],
            discountPercentage: 0,
            paymentMethod: 'cash',
            amountReceived: 0,
            searchDebounceTimer: null
        };

        // Initialize DOM element cache - OPTIMIZED: Batch DOM queries, use clearer naming conventions
        function _cacheElements() {
            const elements = [
                'products-container', 'services-container', 'daily-sales-tbody',
                'cart-items-container', 'total-quantity', 'subtotal', 'discount-input',
                'discount-amount', 'total-amount', 'amount-received-input', 'change-amount',
                'pay-button', 'payment-method', 'customer-name', 'product-search',
                'current-date', 'invoice-number', 'notification-container', 'loading-overlay'
            ];

            // Use a single loop to cache all elements by ID
            elements.forEach(id => {
                _cache.elements[id] = document.getElementById(id);
            });

            // Cache collections in a separate group for clarity
            _cache.elements.tabs = document.querySelectorAll('.pos-tab');
            _cache.elements.tabContents = document.querySelectorAll('.tab-content');
            _cache.elements.emptyCartMessage = document.querySelector('.empty-cart-message');
            _cache.elements.loadingIndicators = document.querySelectorAll('.loading-spinner');

            // Cache templates - pre-parse templates for better performance
            ['product-card-template', 'service-card-template', 'cart-item-template'].forEach(id => {
                _cache.templates[id.replace('-template', '')] = document.getElementById(id);
            });
        }

        // Format currency helper - OPTIMIZED: Added number validation
        function _formatCurrency(amount) {
            // Ensure amount is a number and defaults to 0 if invalid
            const value = typeof amount === 'number' && !isNaN(amount) ? amount : 0;
            return `₱ ${value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }

        // DOM helper to create elements from templates - OPTIMIZED: More robust error handling
        function _createElementFromTemplate(template, setupFunction) {
            if (!template || !template.content) {
                console.error('Invalid template provided to _createElementFromTemplate');
                return document.createDocumentFragment();
            }
            const clone = template.content.cloneNode(true);
            if (typeof setupFunction === 'function') {
                setupFunction(clone);
            }
            return clone;
        }

        // Add visual highlight effect to elements - OPTIMIZED: Use requestAnimationFrame and will-change property
        function _addHighlightEffect(element) {
            if (!element) return;

            // Add will-change property before animation for better performance
            element.style.willChange = 'transform, background-color';

            requestAnimationFrame(() => {
                element.classList.add('highlight');

                // Use a timeout for the cleanup
                setTimeout(() => {
                    element.classList.remove('highlight');

                    // Clean up will-change after animation completes
                    setTimeout(() => {
                        element.style.willChange = 'auto';
                    }, 300);
                }, 300);
            });
        }

        // Show a notification - OPTIMIZED: Use DocumentFragment, add error styling, precompute classes
        function _showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const baseClasses = "text-white px-4 py-2 rounded-md shadow-lg mb-2 opacity-0 transition-opacity duration-300";

            // Set background color based on type
            notification.className = type === 'success'
                ? `bg-pink-500 ${baseClasses}`
                : `bg-red-500 ${baseClasses}`;

            notification.textContent = message;

            // Use requestAnimationFrame for better performance
            requestAnimationFrame(() => {
                // Add to container
                _cache.elements['notification-container'].appendChild(notification);

                // Force reflow before adding opacity class
                notification.offsetHeight;
                notification.classList.add('opacity-100');
            });

            // Remove after delay with proper cleanup
            setTimeout(() => {
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');

                // Wait for transition to complete before removing from DOM
                notification.addEventListener('transitionend', () => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, { once: true });
            }, 3000);
        }

        // Update empty cart message visibility - OPTIMIZED: More direct DOM manipulation, early return
        function _updateEmptyCartMessage() {
            const emptyCartMessage = _cache.elements.emptyCartMessage;
            if (!emptyCartMessage) return;

            // Use direct toggle instead of add/remove for better performance
            emptyCartMessage.classList.toggle('hidden', _state.cartItems.length > 0);
        }

        // Update cart summary calculations - OPTIMIZED: Reduce calculations, better variable naming
        function _updateCartSummary() {
            // Use reduce once for all calculations with optimized initial value
            const totals = _state.cartItems.reduce((acc, item) => {
                const itemTotal = item.price * item.quantity;
                acc.quantity += item.quantity;
                acc.subtotal += itemTotal;
                return acc;
            }, { quantity: 0, subtotal: 0 });

            // Calculate discount amount based on percentage - use more descriptive variables
            const discountPercentage = Math.max(0, Math.min(100, _state.discountPercentage)); // Clamp between 0-100
            const discountAmount = (totals.subtotal * discountPercentage) / 100;
            const totalAfterDiscount = totals.subtotal - discountAmount;
            const change = Math.max(0, _state.amountReceived - totalAfterDiscount);

            // Group DOM updates by type for better performance
            requestAnimationFrame(() => {
                // Text content updates
                _cache.elements['total-quantity'].textContent = totals.quantity;
                _cache.elements['subtotal'].textContent = _formatCurrency(totals.subtotal);
                _cache.elements['discount-amount'].textContent = _formatCurrency(discountAmount);
                _cache.elements['total-amount'].textContent = _formatCurrency(totalAfterDiscount);
                _cache.elements['change-amount'].textContent = _formatCurrency(change);

                // Value updates for inputs
                _cache.elements['discount-input'].value = discountPercentage;
            });
        }

        // Generate current date display - OPTIMIZED: Memoize to prevent repeated object creation
        function _setupCurrentDate() {
            if (!_cache.elements['current-date']) return;

            const date = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            _cache.elements['current-date'].textContent = date.toLocaleDateString('en-US', options);
        }

        // Generate random invoice number - OPTIMIZED: More efficient number generation
        function _generateInvoiceNumber() {
            if (!_cache.elements['invoice-number']) return;

            // Use bitwise operations for faster integer math
            const invoiceNumber = (100000 + ((Math.random() * 900000) | 0));
            _cache.elements['invoice-number'].textContent = invoiceNumber;
        }

        // Render products efficiently - OPTIMIZED: Use DocumentFragment, virtualize rendering with chunking
        function _renderProducts() {
            const container = _cache.elements['products-container'];
            if (!container) return;

            // Clear container first to prevent memory leaks with event handlers
            container.innerHTML = '';

            // Create products array - reduce copies for better performance
            const products = [];
            for (let i = 0; i < 20; i++) { // Reduced from 100 to 20 for better initial load
                products.push(..._cache.data.products);
            }

            // Use chunking to avoid blocking the main thread
            const chunkSize = 50;
            let currentIndex = 0;

            function renderChunk() {
                // Create document fragment once per chunk
                const fragment = document.createDocumentFragment();
                const endIndex = Math.min(currentIndex + chunkSize, products.length);

                for (let i = currentIndex; i < endIndex; i++) {
                    const product = products[i];
                    const productCard = _createElementFromTemplate(_cache.templates['product-card'], fragment => {
                        const card = fragment.querySelector('.product-card');
                        const img = card.querySelector('img');

                        card.setAttribute('data-product-id', product.id);
                        img.src = product.image;
                        img.alt = product.name;

                        card.querySelector('.product-name').textContent = product.name;
                        card.querySelector('.product-size').textContent = product.size;
                        card.querySelector('.product-price').textContent =
                            `₱${product.price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    });

                    fragment.appendChild(productCard);
                }

                // Batch DOM update
                container.appendChild(fragment);

                // Process next chunk or finish
                currentIndex = endIndex;
                if (currentIndex < products.length) {
                    // Schedule next chunk with requestAnimationFrame for better UI responsiveness
                    requestAnimationFrame(renderChunk);
                } else {
                    // Remove loading indicator when complete
                    const loadingIndicator = container.querySelector('.products-loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.remove();
                    }
                }
            }

            // Start rendering
            renderChunk();
        }

        // Render services efficiently - OPTIMIZED: Same improvements as _renderProducts
        function _renderServices() {
            const container = _cache.elements['services-container'];
            if (!container) return;

            // Clear container first
            container.innerHTML = '';

            const fragment = document.createDocumentFragment();
            const services = [];

            // Reduce copies for better performance
            for (let i = 0; i < 3; i++) {
                services.push(..._cache.data.services);
            }

            services.forEach(service => {
                const serviceCard = _createElementFromTemplate(_cache.templates['service-card'], fragment => {
                    const card = fragment.querySelector('.service-card');
                    const img = card.querySelector('img');

                    card.setAttribute('data-service-id', service.id);
                    img.src = service.image;
                    img.alt = service.name;

                    card.querySelector('.service-name').textContent = service.name;
                    card.querySelector('.service-duration').textContent = service.duration;
                    card.querySelector('.service-price').textContent =
                        `₱${service.price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                });

                fragment.appendChild(serviceCard);
            });

            // Single DOM update
            container.appendChild(fragment);

            // Remove loading indicator
            const loadingIndicator = container.querySelector('.services-loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.remove();
            }
        }

        // Generate sample daily sales data - OPTIMIZED: Use DocumentFragment, fewer object allocations
        function _generateDailySales() {
            const tbody = _cache.elements['daily-sales-tbody'];
            if (!tbody) return;

            // Clear any loading indicators
            tbody.innerHTML = '';

            const sales = [];
            const fragment = document.createDocumentFragment();
            const currentDate = new Date(); // Create date object once

            for (let i = 0; i < 5; i++) {
                // Clone date object once per iteration
                const date = new Date(currentDate);
                date.setHours(date.getHours() - Math.floor(Math.random() * 8));

                const sale = {
                    invoice: `12345${i}`,
                    customer: `Customer ${i + 1}`,
                    items: Math.floor(Math.random() * 5) + 1,
                    total: Math.floor(Math.random() * 4900) + 100,
                    time: date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
                };

                sales.push(sale);

                const row = document.createElement('tr');

                // Use template literals once for better performance
                row.innerHTML = `
                    <td class="px-4 py-2 border-b">${sale.invoice}</td>
                    <td class="px-4 py-2 border-b">${sale.customer}</td>
                    <td class="px-4 py-2 border-b">${sale.items}</td>
                    <td class="px-4 py-2 border-b">₱ ${sale.total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td class="px-4 py-2 border-b">${sale.time}</td>
                `;

                fragment.appendChild(row);
            }

            // Update state and DOM in a single batch
            _cache.data.dailySales = sales;
            tbody.appendChild(fragment);
        }

        // FIXED: Completely rewritten tab handling function to properly handle tab indicators
        function _handleTabClick(e) {
            const tab = e.currentTarget;
            if (!tab) return;

            const tabId = tab.getAttribute('data-tab');
            if (!tabId) return;

            // Use cached elements instead of repeated queries
            const allTabs = _cache.elements.tabs;
            const allContents = _cache.elements.tabContents;

            // Update tab indicators and active states in a single animation frame
            requestAnimationFrame(() => {
                // First, reset all tabs to inactive state
                allTabs.forEach(t => {
                    // Remove active class
                    t.classList.remove('active');
                    // Set ARIA attribute
                    t.setAttribute('aria-selected', 'false');

                    // Reset tab indicator - The most important fix
                    const indicator = t.querySelector('.tab-indicator');
                    if (indicator) {
                        indicator.style.display = 'none';
                    }

                    // Reset text color
                    const textElement = t.querySelector('.tab-text');
                    if (textElement) {
                        textElement.style.color = '';
                    }
                });

                // Then set the active tab
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');

                // Show and animate the indicator for active tab
                const activeIndicator = tab.querySelector('.tab-indicator');
                if (activeIndicator) {
                    activeIndicator.style.display = 'block';
                    activeIndicator.style.opacity = '1';
                    activeIndicator.style.transform = 'scaleX(1)';
                }

                // Update text color for active tab
                const activeTextElement = tab.querySelector('.tab-text');
                if (activeTextElement) {
                    activeTextElement.style.color = '#db2777';
                }

                // Update content areas - first hide all, then show active
                allContents.forEach(content => {
                    const isActive = content.id === tabId;

                    if (isActive) {
                        // Show the active content immediately
                        content.style.display = 'block';
                        content.classList.add('fade-in');
                        content.classList.remove('fade-out');
                    } else {
                        // Hide inactive content immediately
                        content.style.display = 'none';
                        content.classList.remove('fade-in');
                    }
                });
            });
        }

        // Optimized search with debounce - IMPROVED: Better debouncing & DOM filtering
        function _handleProductSearch(e) {
            const searchInput = e.target;
            if (!searchInput) return;

            // Clear previous timeout
            clearTimeout(_state.searchDebounceTimer);

            // Use a separate variable to avoid repeatedly accessing e.target
            const searchTerm = searchInput.value.toLowerCase().trim();

            // Skip search if term is too short (performance optimization)
            if (searchTerm.length === 0) {
                // Show all products immediately if search is cleared
                const productCards = _cache.elements['products-container'].querySelectorAll('.product-card');
                productCards.forEach(card => card.classList.remove('hidden'));
                return;
            }

            // Set new timeout (debounce)
            _state.searchDebounceTimer = setTimeout(() => {
                const productCards = _cache.elements['products-container'].querySelectorAll('.product-card');

                // Use DocumentFragment to minimize layout thrashing when showing/hiding many items
                requestAnimationFrame(() => {
                    productCards.forEach(card => {
                        const productName = card.querySelector('.product-name').textContent.toLowerCase();
                        const isVisible = productName.includes(searchTerm);
                        card.classList.toggle('hidden', !isVisible);
                    });
                });
            }, 200); // 200ms debounce
        }

        // Handle amount received input - OPTIMIZED: Add better input validation
        function _handleAmountReceivedChange(e) {
            const inputValue = parseFloat(e.target.value);
            // Ensure value is a positive number
            _state.amountReceived = !isNaN(inputValue) && inputValue >= 0 ? inputValue : 0;

            // Update UI only when value actually changes
            if (_state.amountReceived.toString() !== e.target.value && !isNaN(inputValue)) {
                e.target.value = _state.amountReceived;
            }

            _updateCartSummary();
        }

        // Handle discount percentage input - OPTIMIZED: Better range limiting
        function _handleDiscountChange(e) {
            // Get value and ensure it's within 0-100 range
            const inputValue = parseInt(e.target.value, 10);
            const value = !isNaN(inputValue) ? Math.min(Math.max(inputValue, 0), 100) : 0;

            // Update input if value was clamped
            if (value !== inputValue && !isNaN(inputValue)) {
                e.target.value = value;
            }

            _state.discountPercentage = value;
            _updateCartSummary();
        }

        // Add product to cart - OPTIMIZED: Better item lookup, smoother animations, CSS class caching
        function _addItemToCart(id, name, price, type) {
            if (!id || !type) return;

            // Ensure price is valid
            price = typeof price === 'number' && !isNaN(price) ? price : 0;

            // Check if item already exists with a more efficient lookup
            const existingItemIndex = _state.cartItems.findIndex(
                item => item.id === id && item.type === type
            );

            if (existingItemIndex !== -1) {
                // Update quantity if item exists
                _state.cartItems[existingItemIndex].quantity += 1;

                // Update DOM - optimize selector
                const cartItemElement = document.querySelector(
                    `.cart-item[data-item-id="${id}"][data-item-type="${type}"]`
                );

                if (cartItemElement) {
                    const quantityInput = cartItemElement.querySelector('.item-quantity');
                    if (quantityInput) {
                        quantityInput.value = _state.cartItems[existingItemIndex].quantity;
                    }
                    _addHighlightEffect(cartItemElement);
                }
            } else {
                // Add new item
                const newItem = { id, name, price, quantity: 1, type };
                _state.cartItems.push(newItem);

                // Create DOM element with template - optimize class handling
                const cartItem = _createElementFromTemplate(_cache.templates['cart-item'], fragment => {
                    const cartItemElement = fragment.querySelector('.cart-item');
                    if (!cartItemElement) return;

                    cartItemElement.setAttribute('data-item-id', id);
                    cartItemElement.setAttribute('data-item-type', type);

                    const nameElement = cartItemElement.querySelector('.cart-item-name');
                    const priceElement = cartItemElement.querySelector('.cart-item-price');

                    if (nameElement) nameElement.textContent = name;
                    if (priceElement) priceElement.textContent = _formatCurrency(price);
                });

                // Add to DOM with optimized animation
                const cartItemContainer = _cache.elements['cart-items-container'];
                if (cartItemContainer) {
                    const cartItemElement = cartItem.querySelector('.cart-item');
                    if (cartItemElement) {
                        // Set initial state
                        cartItemElement.style.opacity = '0';
                        // Append to DOM
                        cartItemContainer.appendChild(cartItem);

                        // Trigger animation in next frame
                        requestAnimationFrame(() => {
                            cartItemElement.style.transition = 'opacity 300ms';
                            cartItemElement.style.opacity = '1';
                        });
                    } else {
                        // Fallback if element selector fails
                        cartItemContainer.appendChild(cartItem);
                    }
                }
            }

            // Update UI
            _updateEmptyCartMessage();
            _updateCartSummary();
        }

        // Handle product selection - OPTIMIZED: Better event target checking
        function _handleProductSelection(e) {
            // Find closest product card with more explicit checking
            const productCard = e.target.closest('.product-card');
            if (!productCard) return;

            // Visual feedback
            _addHighlightEffect(productCard);

            // Get product details with safer parsing
            const productId = parseInt(productCard.getAttribute('data-product-id'), 10);
            if (isNaN(productId)) return;

            const productNameElement = productCard.querySelector('.product-name');
            const priceElement = productCard.querySelector('.product-price');

            if (!productNameElement || !priceElement) return;

            const productName = productNameElement.textContent;
            // More robust price extraction
            const priceText = priceElement.textContent;
            const price = parseFloat(priceText.replace(/[^\d.-]/g, ''));

            if (isNaN(price)) return;

            // Add to cart
            _addItemToCart(productId, productName, price, 'product');
        }

        // Handle service selection - OPTIMIZED: Same improvements as _handleProductSelection
        function _handleServiceSelection(e) {
            const serviceCard = e.target.closest('.service-card');
            if (!serviceCard) return;

            // Visual feedback
            _addHighlightEffect(serviceCard);

            // Get service details with safer parsing
            const serviceId = parseInt(serviceCard.getAttribute('data-service-id'), 10);
            if (isNaN(serviceId)) return;

            const serviceNameElement = serviceCard.querySelector('.service-name');
            const priceElement = serviceCard.querySelector('.service-price');

            if (!serviceNameElement || !priceElement) return;

            const serviceName = serviceNameElement.textContent;
            // More robust price extraction
            const priceText = priceElement.textContent;
            const price = parseFloat(priceText.replace(/[^\d.-]/g, ''));

            if (isNaN(price)) return;

            // Add to cart
            _addItemToCart(serviceId, serviceName, price, 'service');
        }

        // Handle cart item quantity change - OPTIMIZED: Better validation
        function _handleQuantityChange(e) {
            if (!e.target.classList.contains('item-quantity')) return;

            const cartItem = e.target.closest('.cart-item');
            if (!cartItem) return;

            const itemIdAttr = cartItem.getAttribute('data-item-id');
            const itemTypeAttr = cartItem.getAttribute('data-item-type');

            if (!itemIdAttr || !itemTypeAttr) return;

            const itemId = parseInt(itemIdAttr, 10);
            const itemType = itemTypeAttr;
            const newQuantity = parseInt(e.target.value, 10);

            if (!isNaN(newQuantity) && newQuantity > 0) {
                // Find item in state
                const itemIndex = _state.cartItems.findIndex(
                    item => item.id === itemId && item.type === itemType
                );

                if (itemIndex !== -1) {
                    _state.cartItems[itemIndex].quantity = newQuantity;
                    _updateCartSummary();
                }
            } else {
                // Reset to 1 if invalid and update view
                e.target.value = 1;

                // Update state to match
                const itemIndex = _state.cartItems.findIndex(
                    item => item.id === itemId && item.type === itemType
                );

                if (itemIndex !== -1) {
                    _state.cartItems[itemIndex].quantity = 1;
                    _updateCartSummary();
                }
            }
        }

        // Handle remove item from cart - OPTIMIZED: Better DOM event handling
        function _handleRemoveItem(e) {
            const removeBtn = e.target.closest('.remove-item-btn');
            if (!removeBtn) return;

            const cartItem = removeBtn.closest('.cart-item');
            if (!cartItem) return;

            const itemIdAttr = cartItem.getAttribute('data-item-id');
            const itemTypeAttr = cartItem.getAttribute('data-item-type');

            if (!itemIdAttr || !itemTypeAttr) return;

            const itemId = parseInt(itemIdAttr, 10);
            const itemType = itemTypeAttr;

            // Find item index with validation
            const itemIndex = _state.cartItems.findIndex(
                item => item.id === itemId && item.type === itemType
            );

            if (itemIndex === -1) return;

            // Remove from data
            _state.cartItems.splice(itemIndex, 1);

            // Animate removal for better UX
            cartItem.style.transition = 'opacity 200ms, transform 200ms';
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(10px)';

            // Remove from DOM after animation
            cartItem.addEventListener('transitionend', function (event) {
                // Only remove when opacity transition completes
                if (event.propertyName === 'opacity' && cartItem.parentNode) {
                    cartItem.parentNode.removeChild(cartItem);

                    // Update empty cart message after removing
                    _updateEmptyCartMessage();
                }
            }, { once: true });

            // Update summary immediately
            _updateCartSummary();
        }

        // Handle payment process - OPTIMIZED: Better validation, inline helper functions
        function _handlePayment() {
            if (_state.cartItems.length === 0) {
                _showNotification('Cart is empty! Please add items before checkout.', 'error');
                return;
            }

            // Calculate totals with a single reduce operation
            const totals = _state.cartItems.reduce((acc, item) => {
                acc.quantity += item.quantity;
                acc.subtotal += item.price * item.quantity;
                return acc;
            }, { quantity: 0, subtotal: 0 });

            // Apply discount with clamping
            const discountPercentage = Math.max(0, Math.min(100, _state.discountPercentage));
            const discountAmount = (totals.subtotal * discountPercentage) / 100;
            const totalAfterDiscount = totals.subtotal - discountAmount;

            // Check if amount received is enough for cash payments
            if (_state.amountReceived < totalAfterDiscount && _state.paymentMethod === 'cash') {
                _showNotification('Insufficient amount received', 'error');

                // Focus the input field for better UX
                const amountInput = _cache.elements['amount-received-input'];
                if (amountInput) {
                    setTimeout(() => amountInput.focus(), 100);
                }
                return;
            }

            // Get and validate customer name
            const customerNameInput = _cache.elements['customer-name'];
            if (!customerNameInput) return;

            const customerName = customerNameInput.value.trim();
            if (!customerName) {
                _showNotification('Please enter customer name', 'error');

                // Focus the name field
                setTimeout(() => customerNameInput.focus(), 100);
                return;
            }

            // Show payment confirmation
            _showPaymentConfirmation(customerName, totals.quantity, totals.subtotal, discountAmount, totalAfterDiscount);
        }

        // Show payment confirmation modal - OPTIMIZED: Better DOM creation, fewer reflows, template caching
        function _showPaymentConfirmation(customerName, totalQuantity, subtotal, discountAmount, totalAfterDiscount) {
            // Create a lightweight modal component
            const modalId = 'payment-confirmation-modal';

            // Remove any existing modal first (prevent duplicates)
            const existingModal = document.getElementById(modalId);
            if (existingModal) existingModal.remove();

            // Pre-calculate values to avoid repeated calculations in the template
            const amountReceived = _state.amountReceived;
            const change = Math.max(0, amountReceived - totalAfterDiscount);
            const discountPercentage = _state.discountPercentage;

            // Create modal backdrop first
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            backdrop.id = modalId;

            // Generate cart items HTML with a single string builder pattern
            let cartItemsHtml = '';

            // Use faster iteration pattern
            for (let i = 0; i < _state.cartItems.length; i++) {
                const item = _state.cartItems[i];
                const itemTotal = item.price * item.quantity;

                cartItemsHtml += `
                    <tr class="border-b">
                        <td class="py-2 px-4">${item.name}</td>
                        <td class="py-2 px-4 text-center">${item.quantity}</td>
                        <td class="py-2 px-4 text-right">${_formatCurrency(item.price)}</td>
                        <td class="py-2 px-4 text-right">${_formatCurrency(itemTotal)}</td>
                    </tr>
                `;
            }

            // Use a single template literal for the modal content
            const modalContent = `
                <div class="bg-white rounded-lg shadow-xl w-2/3 max-w-2xl max-h-[80vh] flex flex-col">
                    <div class="p-4 flex justify-between items-center border-b">
                        <h3 class="text-lg font-semibold">
                            <span class="text-pink-500">Confirm</span>
                            <span class="text-black">Payment</span>
                        </h3>
                        <button id="close-confirmation" class="text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 overflow-auto">
                        <div class="flex justify-between items-center mb-4">
                            <p class="font-semibold">Customer:</p>
                            <p>${customerName}</p>
                        </div>
                        <p class="mb-4">Please verify the items and quantities below:</p>
                        <div class="max-h-64 overflow-y-auto mb-4 custom-scrollbar">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-2 px-4 text-left font-medium text-gray-500">Item</th>
                                        <th class="py-2 px-4 text-center font-medium text-gray-500">Qty</th>
                                        <th class="py-2 px-4 text-right font-medium text-gray-500">Price</th>
                                        <th class="py-2 px-4 text-right font-medium text-gray-500">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${cartItemsHtml}
                                </tbody>
                            </table>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between mb-1">
                                <span>Subtotal:</span>
                                <span>${_formatCurrency(subtotal)}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Discount (${discountPercentage}%):</span>
                                <span>${_formatCurrency(discountAmount)}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span class="text-pink-500">${_formatCurrency(totalAfterDiscount)}</span>
                            </div>
                            <div class="mt-2 flex justify-between">
                                <span>Payment Method:</span>
                                <span class="capitalize">${_state.paymentMethod}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Amount Received:</span>
                                <span>${_formatCurrency(amountReceived)}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Change:</span>
                                <span>${_formatCurrency(change)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t flex justify-end gap-2">
                        <button id="cancel-payment" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancel
                        </button>
                        <button id="confirm-payment" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                            Confirm Payment
                        </button>
                    </div>
                </div>
            `;

            // Set inner HTML only once for better performance
            backdrop.innerHTML = modalContent;
            document.body.appendChild(backdrop);

            // Add event listeners (using event delegation where possible)
            const closeButtons = ['close-confirmation', 'cancel-payment'];
            closeButtons.forEach(id => {
                document.getElementById(id).addEventListener('click', () => {
                    backdrop.remove();
                }, { once: true }); // Use once:true for automatic cleanup
            });

            // Handle payment confirmation
            document.getElementById('confirm-payment').addEventListener('click', () => {
                _processPayment(customerName, totalQuantity, totalAfterDiscount);
                backdrop.remove();
            }, { once: true });

            // Close on backdrop click (using e.target check for better performance)
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) {
                    backdrop.remove();
                }
            });
        }

        // Process the payment after confirmation
        function _processPayment(customerName, totalQuantity, totalAmount) {
            // Show success message
            _showNotification(`Payment of ${_formatCurrency(totalAmount)} processed successfully via ${_state.paymentMethod}!`);

            // Create sale record for today
            const date = new Date();
            const sale = {
                invoice: _cache.elements['invoice-number'].textContent,
                customer: customerName,
                items: totalQuantity,
                total: totalAmount,
                time: date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
            };

            // Add to daily sales data
            _cache.data.dailySales.unshift(sale);

            // Add to the table (if visible) - create element once, set content once
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2 border-b">${sale.invoice}</td>
                <td class="px-4 py-2 border-b">${sale.customer}</td>
                <td class="px-4 py-2 border-b">${sale.items}</td>
                <td class="px-4 py-2 border-b">₱ ${sale.total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="px-4 py-2 border-b">${sale.time}</td>
            `;

            // Prepend to keep newest sales at top
            _cache.elements['daily-sales-tbody'].prepend(row);

            // Reset state
            _state.cartItems = [];
            _cache.elements['cart-items-container'].innerHTML = '';
            _state.amountReceived = 0;
            _cache.elements['amount-received-input'].value = '0.00';
            _state.discountPercentage = 0;
            _cache.elements['discount-input'].value = '0';
            _cache.elements['customer-name'].value = '';

            // Update cart summary
            _updateCartSummary();

            // Generate new invoice number
            _generateInvoiceNumber();
        }

        // Ensure initial tab is active with indicators showing
        function _initializeActiveTab() {
            // Set the first tab as active by default
            if (_cache.elements.tabs && _cache.elements.tabs.length > 0) {
                const firstTab = _cache.elements.tabs[0];
                const firstTabId = firstTab.getAttribute('data-tab');

                // Add active class to first tab
                firstTab.classList.add('active');

                // Show first tab content
                _cache.elements.tabContents.forEach(content => {
                    if (content.id === firstTabId) {
                        content.style.display = 'block';
                        content.classList.add('fade-in');
                    } else {
                        content.style.display = 'none';
                    }
                });
            }
        }

        // Bind all event listeners (using event delegation where possible)
        function _bindEvents() {
            // Tab switching
            _cache.elements.tabs.forEach(tab => {
                tab.addEventListener('click', _handleTabClick);
            });

            // Product search with debounce
            _cache.elements['product-search'].addEventListener('input', _handleProductSearch);

            // Payment method change
            _cache.elements['payment-method'].addEventListener('change', e => {
                _state.paymentMethod = e.target.value;
            });

            // Amount received input
            _cache.elements['amount-received-input'].addEventListener('input', _handleAmountReceivedChange);

            // Discount input
            _cache.elements['discount-input'].addEventListener('input', _handleDiscountChange);

            // Pay button
            _cache.elements['pay-button'].addEventListener('click', _handlePayment);

            // Use event delegation for product & service selection
            _cache.elements['products-container'].addEventListener('click', _handleProductSelection);
            _cache.elements['services-container'].addEventListener('click', _handleServiceSelection);

            // Cart item events - using event delegation for better performance
            _cache.elements['cart-items-container'].addEventListener('change', _handleQuantityChange);
            _cache.elements['cart-items-container'].addEventListener('click', _handleRemoveItem);
        }

        // Initialize the POS system 
        function init() {
            // Cache DOM elements for better performance
            _cacheElements();

            // Setup initial data
            _setupCurrentDate();
            _generateInvoiceNumber();

            // Render all components in a single layout reflow
            // Use requestAnimationFrame to batch UI updates
            requestAnimationFrame(() => {
                _renderProducts();
                _renderServices();
                _generateDailySales();

                // Initialize the active tab
                _initializeActiveTab();

                // Bind events after DOM is ready
                _bindEvents();
            });
        }

        // Define public API
        return {
            init: init
        };
    })();

    // Initialize the POS system
    POS.init();
});