@extends('layouts.app')

@section('title', 'Point of Sale')
@section('header', 'Point of Sale')
@vite('resources/js/pos.js')

@push('styles')
    <style>
        /* Custom scrollbar styles */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c4c4c4;
            border-radius: 4px;
            transition: background-color 0.2s;
            will-change: background-color;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover,
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: #ec4899;
        }

        /* Tab indicator animations */
        .pos-tab .tab-indicator {
            display: none;
            opacity: 0;
            transform: scaleX(0.9);
            transition: opacity 0.2s, transform 0.2s;
            will-change: opacity, transform;
        }

        .pos-tab:hover,
        .pos-tab.active {
            background-color: rgba(249, 29, 124, 0.05);
        }

        .pos-tab:hover .tab-text {
            color: #db2777;
        }

        .pos-tab.active .tab-text {
            color: #db2777;
        }

        .pos-tab.active .tab-indicator {
            display: block;
            opacity: 1;
            transform: scaleX(1);
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px) translate3d(0, 0, 0);
            }

            to {
                opacity: 1;
                transform: translateY(0) translate3d(0, 0, 0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0) translate3d(0, 0, 0);
            }

            to {
                opacity: 0;
                transform: translateY(5px) translate3d(0, 0, 0);
            }
        }

        .fade-in,
        .fade-out {
            will-change: opacity, transform;
        }

        .fade-in {
            animation: fadeIn 0.25s ease forwards;
        }

        .fade-out {
            animation: fadeOut 0.25s ease forwards;
        }

        /* Product highlight effect */
        .highlight {
            transform: scale(0.97) translate3d(0, 0, 0);
            background-color: rgba(249, 29, 124, 0.08);
            transition: all 0.2s ease;
            will-change: transform, background-color;
        }

        .product-card,
        .service-card {
            contain: layout style paint;
            will-change: transform, box-shadow;
            transition: transform 0.2s, box-shadow 0.2s;
            min-height: 8rem;
        }

        .product-card:hover,
        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .cart-item {
            transition: opacity 0.2s, background-color 0.2s;
            will-change: opacity, background-color;
        }

        .product-img-placeholder,
        .service-img-placeholder {
            aspect-ratio: 16/9;
            background-color: #f9f9f9;
        }

        @media (prefers-reduced-motion: no-preference) {

            .fade-in,
            .fade-out {
                transition-duration: 0.25s;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .fade-in,
            .fade-out {
                animation: none !important;
                transition: none !important;
            }

            .highlight {
                transition: none !important;
            }
        }

        /* Loading indicator styles */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
            will-change: transform;
        }

        /* Status badge styles */
        .status-badge {
            padding: 2px 6px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 500;
            min-width: 60%;
            display: inline-block;
            text-transform: capitalize;
        }

        .status-in-stock {
            background-color: rgba(16, 185, 129, 0.2);
            color: rgb(6, 95, 70);
        }

        .status-low-stock {
            background-color: rgba(245, 158, 11, 0.2);
            color: rgb(146, 64, 14);
        }

        .status-out-of-stock,
        .status-out.of.stock {
            background-color: rgba(239, 68, 68, 0.2);
            color: rgb(153, 27, 27);
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.2);
            color: rgb(6, 95, 70);
        }

        .status-inactive {
            background-color: rgba(156, 163, 175, 0.2);
            color: rgb(55, 65, 81);
        }

        /* POS specific styles */
        .pos-disabled {
            opacity: 0.6;
            cursor: not-allowed;
            filter: grayscale(0.5);
        }

        .pos-disabled:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        .pos-highlight {
            animation: highlightPulse 0.3s ease-in-out;
        }

        @keyframes highlightPulse {
            0% {
                transform: scale(1);
                background-color: rgba(249, 29, 124, 0.1);
            }

            50% {
                transform: scale(1.05);
                background-color: rgba(249, 29, 124, 0.2);
            }

            100% {
                transform: scale(1);
                background-color: rgba(249, 29, 124, 0.1);
            }
        }

        .pos-removing {
            opacity: 0;
            transform: translateX(100px);
            transition: all 0.3s ease;
        }

        /* Notification styles */
        .pos-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            min-width: 250px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .pos-notification-show {
            transform: translateX(0);
            opacity: 1;
        }

        .pos-notification-hide {
            transform: translateX(100%);
            opacity: 0;
        }

        .pos-notification-success {
            background-color: #10b981;
            color: white;
        }

        .pos-notification-error {
            background-color: #ef4444;
            color: white;
        }

        .pos-notification-warning {
            background-color: #f59e0b;
            color: white;
        }

        /* Modal styles */
        .pos-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 16px;
        }

        .pos-modal-content {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .pos-modal-header {
            padding: 20px 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }

        .pos-modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .pos-modal-close {
            padding: 4px;
            color: #6b7280;
            hover: #374151;
            transition: color 0.2s;
        }

        .pos-modal-body {
            padding: 20px 24px;
        }

        .pos-modal-footer {
            padding: 0 24px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .pos-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .pos-btn-primary {
            background-color: #ec4899;
            color: white;
        }

        .pos-btn-primary:hover {
            background-color: #db2777;
        }

        .pos-btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .pos-btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .pos-confirmation-info {
            margin-bottom: 16px;
        }

        .pos-customer-info {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background-color: #f9fafb;
            border-radius: 8px;
        }

        .pos-label {
            font-weight: 500;
            color: #374151;
        }

        .pos-value {
            color: #111827;
        }

        .pos-confirmation-table-container {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .pos-confirmation-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pos-confirmation-table th {
            background-color: #f9fafb;
            padding: 8px 12px;
            text-align: left;
            font-weight: 500;
            font-size: 12px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .pos-confirmation-table td {
            padding: 8px 12px;
            font-size: 14px;
            color: #111827;
        }

        .pos-confirmation-summary {
            border-top: 2px solid #e5e7eb;
            padding-top: 16px;
        }

        .pos-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .pos-summary-total {
            font-weight: 600;
            font-size: 16px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            margin-top: 8px;
        }

        .pos-capitalize {
            text-transform: capitalize;
        }
    </style>
@endpush

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <!-- Pass products and services data to JavaScript -->
    <script>
        window.posData = {
            products: @json($products),
            services: @json($services)
        };
    </script>

    <div id="pos-module-container" class="flex flex-col h-full min-h-0 overflow-hidden">
        <div class="flex flex-col bg-gray-100 h-full rounded-lg overflow-hidden">
            <!-- POS Content Container -->
            <div class="flex flex-col md:flex-row gap-2 h-full p-2 overflow-auto">
                <!-- Left Side - Products Display -->
                <div class="w-full md:w-3/5 bg-white rounded-lg shadow flex flex-col h-full overflow-hidden">
                    <!-- Search and Categories Bar -->
                    <div class="p-2 border-b flex items-center justify-between sticky top-0 bg-white z-10">
                        <div class="relative w-full md:w-60 flex items-center">
                            <span class="absolute left-2 top-1/2 transform -translate-y-1/2">
                                <img src="{{ asset('icons/search_icon.svg') }}" alt="Search" class="w-4 h-4"
                                    role="presentation" fetchpriority="high">
                            </span>
                            <input type="text" id="product-search"
                                class="pl-8 p-1.5 w-full bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-transparent text-sm"
                                placeholder="Search Products..." aria-label="Search Products">
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="border-b border-neutral-200 sticky top-12 bg-white z-10">
                        <div class="px-1">
                            <div class="flex overflow-x-auto" role="tablist" aria-label="Point of Sale Categories">
                                <div class="px-3 py-2 relative flex flex-col items-center pos-tab active cursor-pointer"
                                    data-tab="products" role="tab" aria-controls="products" aria-selected="true"
                                    tabindex="0">
                                    <div
                                        class="text-xs font-medium tab-text text-black hover:text-pink-500 transition duration-200">
                                        Products</div>
                                    <div class="w-full h-[2px] absolute bottom-0 bg-pink-600 tab-indicator"></div>
                                </div>
                                <div class="px-3 py-2 relative flex flex-col items-center pos-tab cursor-pointer"
                                    data-tab="services" role="tab" aria-controls="services" aria-selected="false"
                                    tabindex="0">
                                    <div
                                        class="text-xs font-medium tab-text text-black hover:text-pink-500 transition duration-200">
                                        Services</div>
                                    <div class="w-full h-[2px] absolute bottom-0 bg-pink-600 tab-indicator hidden"></div>
                                </div>
                                <div class="px-3 py-2 relative flex flex-col items-center pos-tab cursor-pointer"
                                    data-tab="daily-sales" role="tab" aria-controls="daily-sales" aria-selected="false"
                                    tabindex="0">
                                    <div
                                        class="text-xs font-medium tab-text text-black hover:text-pink-500 transition duration-200">
                                        Daily Sales</div>
                                    <div class="w-full h-[2px] absolute bottom-0 bg-pink-600 tab-indicator hidden"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div id="products" class="tab-content flex-1 flex flex-col" style="display:block;" role="tabpanel"
                        aria-labelledby="products-tab">
                        <!-- Scrollable container for products -->
                        <div id="products-container"
                            class="flex flex-wrap gap-2 p-2 overflow-y-auto overflow-x-hidden custom-scrollbar flex-1">
                            <!-- Products will be loaded here via JavaScript -->
                        </div>
                    </div>

                    <div id="services" class="tab-content flex-1 flex flex-col" style="display:none;" role="tabpanel"
                        aria-labelledby="services-tab">
                        <!-- Services content -->
                        <div id="services-container"
                            class="flex flex-wrap gap-2 p-2 overflow-y-auto overflow-x-hidden custom-scrollbar flex-1">
                            <!-- Services will be loaded here via JavaScript -->
                        </div>
                    </div>

                    <div id="daily-sales" class="tab-content flex-1 flex flex-col" style="display:none;" role="tabpanel"
                        aria-labelledby="daily-sales-tab">
                        <!-- Daily Sales content -->
                        <div class="p-2 flex-1 overflow-y-auto overflow-x-auto custom-scrollbar">
                            <h2 class="text-sm font-semibold mb-2">Daily Sales Summary</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
                                    <thead class="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th
                                                class="px-2 py-1.5 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Invoice #</th>
                                            <th
                                                class="px-2 py-1.5 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Customer</th>
                                            <th
                                                class="px-2 py-1.5 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Items</th>
                                            <th
                                                class="px-2 py-1.5 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Total</th>
                                            <th
                                                class="px-2 py-1.5 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="daily-sales-tbody" class="divide-y divide-gray-200 overflow-y-auto">
                                        @if(isset($dailySales) && count($dailySales) > 0)
                                            @foreach($dailySales as $sale)
                                                <tr>
                                                    <td class="px-4 py-2 border-b">{{ $sale->sale_ID }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $sale->customer_name }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $sale->total_items ?? 0 }}</td>
                                                    <td class="px-4 py-2 border-b">₱ {{ number_format($sale->total_cost, 2) }}</td>
                                                    <td class="px-4 py-2 border-b">
                                                        {{ \Carbon\Carbon::parse($sale->created_at)->format('h:i A') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="py-4 text-center text-gray-500">
                                                    <p>No sales recorded today</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Cart/Invoice Panel -->
                <div class="w-full md:w-2/5 bg-white rounded-lg shadow flex flex-col h-full overflow-hidden">
                    <!-- Cart Header -->
                    <div class="p-2 border-b sticky top-0 bg-white z-10">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-600">Invoice No.</p>
                                <p class="text-sm font-semibold" id="invoice-number" aria-live="polite">123456</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-600 mb-1" id="current-date" aria-live="polite">
                                    <!-- Populated by JS -->
                                </p>
                                <div class="relative">
                                    <input type="text" id="customer-name"
                                        class="text-sm w-full text-left p-1 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-transparent"
                                        placeholder="Customer Name" aria-label="Customer Name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Items -->
                    <div id="cart-items-container" class="p-2 flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar"
                        aria-live="polite" aria-label="Shopping Cart Items">
                        <!-- Cart items will be added here via JavaScript -->
                        <div class="text-center text-gray-500 py-4 empty-cart-message">
                            <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <p class="mt-1 text-sm">Cart is empty</p>
                            <p class="text-xs">Add products or services to begin</p>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="border-t p-2 bg-gray-50">
                        <div class="grid grid-cols-2 gap-1 mb-2 text-sm">
                            <div>
                                <p class="text-gray-600 text-xs">Quantity</p>
                                <p class="font-semibold" id="total-quantity" aria-live="polite">0</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Subtotal</p>
                                <p class="font-semibold" id="subtotal" aria-live="polite">₱0.00</p>
                            </div>
                            <div class="col-span-2">
                                <div class="flex justify-between items-center">
                                    <label for="discount-input" class="text-gray-600 text-xs">Discount</label>
                                    <div class="flex items-center">
                                        <input type="number" id="discount-input"
                                            class="w-14 text-right border border-gray-300 rounded py-0.5 px-1 focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-transparent text-sm"
                                            placeholder="0" min="0" max="100" step="1" aria-label="Discount Percentage">
                                        <span class="ml-1 text-xs text-gray-600">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-600 text-xs">Discount Amount</p>
                                    <p class="font-semibold text-sm" id="discount-amount" aria-live="polite">₱0.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-2 pt-1 border-t border-gray-200">
                            <p class="text-gray-700 font-semibold text-sm">Total</p>
                            <p class="text-pink-500 font-bold text-base" id="total-amount" aria-live="polite">₱0.00</p>
                        </div>

                        <div class="bg-white p-2 rounded-lg shadow-sm mb-2 text-sm">
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="payment-method" class="text-gray-600 text-xs">Payment Option</label>
                                <div class="flex items-center bg-gray-50 px-2 py-1 rounded-md border border-gray-200">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-1" aria-hidden="true"></div>
                                    <select id="payment-method" class="bg-transparent focus:outline-none text-sm">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="ewallet">E-Wallet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="amount-received-input" class="text-gray-600 text-xs">Received</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-0 top-1/2 transform -translate-y-1/2 ml-1.5 text-gray-600 text-xs"
                                        aria-hidden="true">₱</span>
                                    <input type="number" id="amount-received-input"
                                        class="w-24 text-right font-semibold pl-5 py-1 px-1.5 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-transparent text-sm"
                                        placeholder="0.00" min="0" step="1.00" aria-label="Amount Received">
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-600 text-xs">Change</p>
                                <p class="font-semibold text-green-600 text-sm" id="change-amount" aria-live="polite">₱0.00
                                </p>
                            </div>
                        </div>

                        <button id="pay-button"
                            class="bg-pink-500 hover:bg-pink-600 text-white w-full py-2 rounded-md font-semibold transition-colors flex items-center justify-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Pay Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $activePage = 'pos';
    @endphp

    <!-- Templates -->
    <template id="product-card-template">
        <div class="product-card p-2 bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col justify-between items-center w-24 h-32 cursor-pointer border border-gray-200"
            data-product-id="" tabindex="0" role="button">
            <div class="flex flex-col w-full">
                <!-- Status badge positioned at the top -->
                <div class="status-badge self-end mb-1 product-status text-center text-xs"></div>

                <!-- Image container -->
                <div class="w-full flex justify-center">
                    <img class="h-10 object-contain mb-1 product-img" src="" alt="" loading="lazy">
                </div>
            </div>
            <div class="text-center w-full flex flex-col justify-between flex-grow">
                <p class="font-semibold text-[10px] leading-tight line-clamp-2 product-name"></p>
                <div>
                    <p class="text-[10px] text-gray-600 truncate w-full product-size"></p>
                    <p class="text-pink-500 font-bold text-[10px] mt-0.5 product-price"></p>
                </div>
            </div>
        </div>
    </template>

    <template id="service-card-template">
        <div class="service-card p-2 bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col justify-between items-center w-24 h-32 cursor-pointer border border-gray-200"
            data-service-id="" tabindex="0" role="button">
            <div class="flex flex-col w-full">
                <!-- Status badge positioned at the top -->
                <div class="status-badge self-end mb-1 service-status text-center text-xs"></div>

                <!-- Image container -->
                <div class="w-full flex justify-center">
                    <img class="h-10 object-contain mb-1 service-img"
                        src="{{ asset('images/pos_service_placeholder.svg') }}" alt="" loading="lazy">
                </div>
            </div>
            <div class="text-center w-full flex flex-col justify-between flex-grow">
                <p class="font-semibold text-[10px] leading-tight line-clamp-2 service-name"></p>
                <div>
                    <p class="text-[10px] text-gray-600 truncate w-full service-duration"></p>
                    <p class="text-pink-500 font-bold text-[10px] mt-0.5 service-price"></p>
                </div>
            </div>
        </div>
    </template>

    <template id="cart-item-template">
        <div class="mb-2 p-1.5 flex justify-between items-center cart-item bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
            data-item-id="" data-item-type="">
            <div class="flex-grow pr-1">
                <p class="font-medium text-xs cart-item-name"></p>
                <p class="text-pink-500 font-semibold text-xs cart-item-price"></p>
            </div>
            <div class="flex items-center">
                <button class="text-gray-500 hover:text-gray-700 quantity-btn decrement-btn p-0.5"
                    aria-label="Decrease quantity">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>
                <input type="number" value="1" min="1"
                    class="w-11 text-center mx-0.5 item-quantity bg-white border border-gray-200 rounded py-0.5 text-xs"
                    aria-label="Item quantity">
                <button class="text-gray-500 hover:text-gray-700 quantity-btn increment-btn p-0.5"
                    aria-label="Increase quantity">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <button class="text-red-500 hover:text-red-700 remove-item-btn ml-1 p-0.5" aria-label="Remove item">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>

    <!-- Empty state template -->
    <template id="empty-state-template">
        <div class="empty-state w-full flex-1 flex flex-col items-center justify-center py-8">
            <div class="text-gray-300 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <h3 class="empty-state-title text-lg font-medium text-gray-900 mb-2"></h3>
            <p class="empty-state-subtitle text-gray-600 text-center"></p>
        </div>
    </template>

    <!-- Loading indicator template -->
    <template id="loading-indicator-template">
        <div class="w-full flex-1 flex items-center justify-center py-8">
            <div class="loading-spinner rounded-full h-8 w-8 border-3 border-pink-500 border-t-transparent"></div>
            <p class="loading-message ml-3 text-gray-600"></p>
        </div>
    </template>

    <!-- Notification container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50" aria-live="polite" aria-atomic="true"></div>

    <!-- Loading overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden"
        role="dialog" aria-modal="true" aria-labelledby="loading-message">
        <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
            <div class="loading-spinner rounded-full h-8 w-8 border-3 border-pink-500 border-t-transparent"></div>
            <p id="loading-message" class="mt-2 text-gray-700 text-sm">Processing payment...</p>
        </div>
    </div>

    <!-- Keyboard shortcuts helper -->
    <div
        class="hidden md:block fixed bottom-2 left-2 text-xs text-gray-500 bg-white px-2 py-1 rounded-md shadow-sm opacity-70 hover:opacity-100 transition-opacity">
        <p>Shortcuts: <kbd class="px-1 py-0.5 bg-gray-100 rounded">Alt+P</kbd> Pay | <kbd
                class="px-1 py-0.5 bg-gray-100 rounded">Alt+S</kbd> Search</p>
    </div>
@endsection