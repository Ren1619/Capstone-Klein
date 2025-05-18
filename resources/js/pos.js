document.addEventListener('DOMContentLoaded', function () {
    // Simple POS System
    const POS = {
        // State
        cart: [],
        discount: 0,
        amountReceived: 0,
        products: window.posData?.products || [],
        services: window.posData?.services || [],

        // DOM Elements
        elements: {},

        // Initialize
        init() {
            this.cacheElements();
            this.renderProducts();
            this.renderServices();
            this.setupEventListeners();
            this.updateDateTime();
            this.loadDailySales();
        },

        // Cache DOM elements
        cacheElements() {
            this.elements = {
                productsContainer: document.getElementById('products-container'),
                servicesContainer: document.getElementById('services-container'),
                cartContainer: document.getElementById('cart-items-container'),
                totalQuantity: document.getElementById('total-quantity'),
                subtotal: document.getElementById('subtotal'),
                discountInput: document.getElementById('discount-input'),
                discountAmount: document.getElementById('discount-amount'),
                totalAmount: document.getElementById('total-amount'),
                amountReceived: document.getElementById('amount-received-input'),
                changeAmount: document.getElementById('change-amount'),
                customerName: document.getElementById('customer-name'),
                payButton: document.getElementById('pay-button'),
                currentDate: document.getElementById('current-date'),
                invoiceNumber: document.getElementById('invoice-number'),
                dailySalesTable: document.getElementById('daily-sales-tbody'),
                tabs: document.querySelectorAll('.pos-tab'),
                tabContents: document.querySelectorAll('.tab-content')
            };
        },

        // Render products
        renderProducts() {
            if (!this.elements.productsContainer) return;

            this.elements.productsContainer.innerHTML = '';

            this.products.forEach(product => {
                const productCard = this.createProductCard(product);
                this.elements.productsContainer.appendChild(productCard);
            });
        },

        // Create product card
        createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card p-2 bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col justify-between items-center w-24 h-32 cursor-pointer border border-gray-200';
            card.dataset.productId = product.id;

            const isOutOfStock = product.quantity === 0;
            if (isOutOfStock) {
                card.classList.add('opacity-60', 'pos-disabled');
                card.style.pointerEvents = 'none';
            }

            card.innerHTML = `
                <div class="flex flex-col w-full">
                    <div class="status-badge self-end mb-1 text-center text-xs ${this.getStatusClass(product.status)}">${product.status}</div>
                    <div class="w-full flex justify-center">
                        <img class="h-10 object-contain mb-1" src="${product.image || 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMiA4VjE2TTggMTJIMTYiIHN0cm9rZT0iIzlDQTNBRiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPC9zdmc+'}" alt="${product.name}">
                    </div>
                </div>
                <div class="text-center w-full flex flex-col justify-between flex-grow">
                    <p class="font-semibold text-[10px] leading-tight line-clamp-2">${product.name}</p>
                    <div>
                        <p class="text-[10px] text-gray-600 truncate w-full">${product.size}</p>
                        <p class="text-pink-500 font-bold text-[10px] mt-0.5">${this.formatCurrency(product.price)}</p>
                    </div>
                </div>
            `;

            if (!isOutOfStock) {
                card.addEventListener('click', () => this.addToCart('product', product));
            }
            return card;
        },

        // Render services
        renderServices() {
            if (!this.elements.servicesContainer) return;

            this.elements.servicesContainer.innerHTML = '';

            this.services.forEach(service => {
                const serviceCard = this.createServiceCard(service);
                this.elements.servicesContainer.appendChild(serviceCard);
            });
        },

        // Create service card
        createServiceCard(service) {
            const card = document.createElement('div');
            card.className = 'service-card p-2 bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col justify-between items-center w-24 h-32 cursor-pointer border border-gray-200';
            card.dataset.serviceId = service.id;

            const isInactive = service.status !== 'active';
            if (isInactive) {
                card.classList.add('opacity-60', 'pos-disabled');
                card.style.pointerEvents = 'none';
            }

            card.innerHTML = `
                <div class="flex flex-col w-full">
                    <div class="status-badge self-end mb-1 text-center text-xs ${this.getStatusClass(service.status)}">${service.status}</div>
                    <div class="w-full flex justify-center">
                        <img class="h-10 object-contain mb-1" src="${service.image || 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik04IDZMOCA2SDhTOSAxNSAxMCAxNkgxNFMxNSAxNSAxNiA2SDE2SDgiIHN0cm9rZT0iIzlDQTNBRiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+'}" alt="${service.name}">
                    </div>
                </div>
                <div class="text-center w-full flex flex-col justify-between flex-grow">
                    <p class="font-semibold text-[10px] leading-tight line-clamp-2">${service.name}</p>
                    <div>
                        <p class="text-[10px] text-gray-600 truncate w-full">${service.duration || '30 min'}</p>
                        <p class="text-pink-500 font-bold text-[10px] mt-0.5">${this.formatCurrency(service.price)}</p>
                    </div>
                </div>
            `;

            if (!isInactive) {
                card.addEventListener('click', () => this.addToCart('service', service));
            }
            return card;
        },

        // Add item to cart
        addToCart(type, item) {
            const existingItem = this.cart.find(cartItem =>
                cartItem.type === type && cartItem.id === item.id
            );

            if (existingItem) {
                // Check stock for products
                if (type === 'product' && existingItem.quantity >= item.quantity) {
                    this.showNotification('Not enough stock available', 'error');
                    return;
                }
                existingItem.quantity++;
            } else {
                this.cart.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: 1,
                    type: type,
                    maxQuantity: type === 'product' ? item.quantity : null
                });
            }

            this.renderCart();
            this.updateSummary();
        },

        // Render cart
        renderCart() {
            this.elements.cartContainer.innerHTML = '';

            if (this.cart.length === 0) {
                this.elements.cartContainer.innerHTML = `
                    <div class="text-center text-gray-500 py-4">
                        <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="mt-1 text-sm">Cart is empty</p>
                        <p class="text-xs">Add products or services to begin</p>
                    </div>
                `;
                return;
            }

            this.cart.forEach((item, index) => {
                const cartItem = this.createCartItem(item, index);
                this.elements.cartContainer.appendChild(cartItem);
            });
        },

        // Create cart item
        createCartItem(item, index) {
            const div = document.createElement('div');
            div.className = 'mb-2 p-1.5 flex justify-between items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors';

            div.innerHTML = `
                <div class="flex-grow pr-1">
                    <p class="font-medium text-xs">${item.name}</p>
                    <p class="text-pink-500 font-semibold text-xs">${this.formatCurrency(item.price)}</p>
                </div>
                <div class="flex items-center">
                    <button class="text-gray-500 hover:text-gray-700 p-0.5 decrement-btn" data-index="${index}">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <input type="number" value="${item.quantity}" min="1" class="w-11 text-center mx-0.5 bg-white border border-gray-200 rounded py-0.5 text-xs quantity-input" data-index="${index}">
                    <button class="text-gray-500 hover:text-gray-700 p-0.5 increment-btn" data-index="${index}">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button class="text-red-500 hover:text-red-700 ml-1 p-0.5 remove-btn" data-index="${index}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;

            return div;
        },

        // Update cart summary
        updateSummary() {
            const totalQuantity = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountAmount = (subtotal * this.discount) / 100;
            const total = subtotal - discountAmount;
            const change = Math.max(0, this.amountReceived - total);

            this.elements.totalQuantity.textContent = totalQuantity;
            this.elements.subtotal.textContent = this.formatCurrency(subtotal);
            this.elements.discountAmount.textContent = this.formatCurrency(discountAmount);
            this.elements.totalAmount.textContent = this.formatCurrency(total);
            this.elements.changeAmount.textContent = this.formatCurrency(change);
        },

        // Setup event listeners
        setupEventListeners() {
            // Tab switching
            this.elements.tabs.forEach(tab => {
                tab.addEventListener('click', (e) => this.switchTab(e.target.closest('.pos-tab')));
            });

            // Cart interactions
            this.elements.cartContainer.addEventListener('click', (e) => {
                const button = e.target.closest('button');
                if (!button) return;

                const index = parseInt(button.dataset.index);
                if (isNaN(index)) return;

                if (button.classList.contains('increment-btn')) {
                    this.incrementItem(index);
                } else if (button.classList.contains('decrement-btn')) {
                    this.decrementItem(index);
                } else if (button.classList.contains('remove-btn')) {
                    this.removeItem(index);
                }
            });

            this.elements.cartContainer.addEventListener('change', (e) => {
                if (e.target.classList.contains('quantity-input')) {
                    const index = parseInt(e.target.dataset.index);
                    this.updateItemQuantity(index, parseInt(e.target.value));
                }
            });

            // Discount input
            this.elements.discountInput.addEventListener('input', (e) => {
                this.discount = Math.max(0, Math.min(100, parseInt(e.target.value) || 0));
                this.updateSummary();
            });

            // Amount received input
            this.elements.amountReceived.addEventListener('input', (e) => {
                this.amountReceived = parseFloat(e.target.value) || 0;
                this.updateSummary();
            });

            // Pay button
            this.elements.payButton.addEventListener('click', () => this.processPayment());
        },

        // Cart item methods
        incrementItem(index) {
            const item = this.cart[index];
            if (item.type === 'product' && item.maxQuantity && item.quantity >= item.maxQuantity) {
                this.showNotification('Not enough stock available', 'error');
                return;
            }
            item.quantity++;
            this.renderCart();
            this.updateSummary();
        },

        decrementItem(index) {
            const item = this.cart[index];
            if (item.quantity > 1) {
                item.quantity--;
                this.renderCart();
                this.updateSummary();
            }
        },

        removeItem(index) {
            this.cart.splice(index, 1);
            this.renderCart();
            this.updateSummary();
        },

        updateItemQuantity(index, quantity) {
            const item = this.cart[index];
            if (quantity < 1) return;

            if (item.type === 'product' && item.maxQuantity && quantity > item.maxQuantity) {
                this.showNotification('Not enough stock available', 'error');
                return;
            }

            item.quantity = quantity;
            this.updateSummary();
        },

        // Process payment
        async processPayment() {
            if (this.cart.length === 0) {
                this.showNotification('Cart is empty!', 'error');
                return;
            }

            const customerName = this.elements.customerName.value.trim();
            if (!customerName) {
                this.showNotification('Please enter customer name', 'error');
                this.elements.customerName.focus();
                return;
            }

            const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal - (subtotal * this.discount / 100);

            if (this.amountReceived < total) {
                this.showNotification('Insufficient amount received', 'error');
                this.elements.amountReceived.focus();
                return;
            }

            // Show loading
            this.elements.payButton.disabled = true;
            this.elements.payButton.textContent = 'Processing...';

            try {
                const response = await fetch('/api/sales', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        customer_name: customerName,
                        subtotal_cost: subtotal,
                        discount_perc: this.discount,
                        total_cost: total,
                        branch: 'valencia', // Default branch, you can make this dynamic
                        product_items: this.cart.filter(item => item.type === 'product').map(item => ({
                            id: item.id,
                            quantity: item.quantity
                        })),
                        service_items: this.cart.filter(item => item.type === 'service').map(item => ({
                            id: item.id,
                            quantity: item.quantity
                        }))
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showNotification('Payment processed successfully!', 'success');
                    this.resetPOS();
                    this.loadDailySales();
                    this.updateProductInventory();
                } else {
                    this.showNotification(data.message || 'Payment failed', 'error');
                }
            } catch (error) {
                console.error('Payment error:', error);
                this.showNotification('Payment failed. Please try again.', 'error');
            } finally {
                this.elements.payButton.disabled = false;
                this.elements.payButton.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Pay Now
                `;
            }
        },

        // Reset POS after successful sale
        resetPOS() {
            this.cart = [];
            this.discount = 0;
            this.amountReceived = 0;

            this.elements.customerName.value = '';
            this.elements.discountInput.value = '0';
            this.elements.amountReceived.value = '0';

            this.renderCart();
            this.updateSummary();
            this.generateInvoiceNumber();
        },

        // Update product inventory after sale
        updateProductInventory() {
            this.cart.forEach(item => {
                if (item.type === 'product') {
                    const product = this.products.find(p => p.id === item.id);
                    if (product) {
                        product.quantity -= item.quantity;
                        product.status = product.quantity === 0 ? 'out of stock' :
                            product.quantity < 10 ? 'low stock' : 'in stock';
                    }
                }
            });
            this.renderProducts();
        },

        // Load daily sales
        async loadDailySales() {
            try {
                const response = await fetch('/api/sales/daily');
                const sales = await response.json();

                this.elements.dailySalesTable.innerHTML = '';

                if (sales.length === 0) {
                    this.elements.dailySalesTable.innerHTML = `
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">No sales recorded today</td>
                        </tr>
                    `;
                    return;
                }

                sales.forEach(sale => {
                    const row = document.createElement('tr');
                    const time = new Date(sale.created_at).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    row.innerHTML = `
                        <td class="px-4 py-2 border-b text-sm">${sale.sale_ID}</td>
                        <td class="px-4 py-2 border-b text-sm">${sale.customer_name}</td>
                        <td class="px-4 py-2 border-b text-sm">${sale.total_items || 0}</td>
                        <td class="px-4 py-2 border-b text-sm">${this.formatCurrency(sale.total_cost)}</td>
                        <td class="px-4 py-2 border-b text-sm">${time}</td>
                    `;

                    this.elements.dailySalesTable.appendChild(row);
                });
            } catch (error) {
                console.error('Error loading daily sales:', error);
                this.elements.dailySalesTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-4 text-center text-red-500">Error loading sales data</td>
                    </tr>
                `;
            }
        },

        // Switch tabs
        switchTab(clickedTab) {
            const tabId = clickedTab.dataset.tab;

            // Update tab indicators
            this.elements.tabs.forEach(tab => {
                const isActive = tab === clickedTab;
                tab.classList.toggle('active', isActive);

                const indicator = tab.querySelector('.tab-indicator');
                if (indicator) {
                    indicator.style.display = isActive ? 'block' : 'none';
                }

                const text = tab.querySelector('.tab-text');
                if (text) {
                    text.style.color = isActive ? '#db2777' : '';
                }
            });

            // Update content visibility
            this.elements.tabContents.forEach(content => {
                content.style.display = content.id === tabId ? 'block' : 'none';
            });

            // Load daily sales when tab is selected
            if (tabId === 'daily-sales') {
                this.loadDailySales();
            }
        },

        // Utility methods
        formatCurrency(amount) {
            return `₱ ${parseFloat(amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        },

        getStatusClass(status) {
            const statusClasses = {
                'in stock': 'status-in-stock',
                'low stock': 'status-low-stock',
                'out of stock': 'status-out-of-stock',
                'active': 'status-active',
                'inactive': 'status-inactive'
            };
            return statusClasses[status] || '';
        },

        updateDateTime() {
            const date = new Date();
            this.elements.currentDate.textContent = date.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            this.generateInvoiceNumber();
        },

        generateInvoiceNumber() {
            const invoiceNumber = 100000 + Math.floor(Math.random() * 900000);
            this.elements.invoiceNumber.textContent = invoiceNumber;
        },

        showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 p-3 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    };

    // Initialize POS
    POS.init();
});