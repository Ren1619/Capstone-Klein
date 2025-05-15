@extends('layouts.app')

@section('title', 'Inventory')
@section('header', 'Inventory')

@section('content')
    <div class="p-3 sm:p-5 bg-neutral-100 min-h-screen">
        <!-- Stats Cards -->
        <div class="self-stretch flex flex-col sm:flex-row justify-start items-center gap-3 sm:gap-5 overflow-x-auto">
            <div class="w-full sm:w-48 h-24 bg-white rounded-lg p-3 sm:p-3.5 flex items-center gap-2.5 shadow-sm">
                <div class="flex-1 flex flex-col gap-1 sm:gap-2.5">
                    <div class="text-gray-500 text-xs sm:text-sm">Total Products</div>
                    <div class="text-black text-2xl sm:text-3xl font-medium">{{ $totalProducts }}</div>
                </div>
                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-blue-600/30 rounded flex items-center justify-center">
                    <img src="{{ asset('icons/total_products_icon.svg') }}" alt="Total Product Icon">
                </div>
            </div>

            <div class="w-full sm:w-48 h-24 bg-white rounded-lg p-3 sm:p-3.5 flex items-center gap-2.5 shadow-sm">
                <div class="flex-1 flex flex-col gap-1 sm:gap-2.5">
                    <div class="text-gray-500 text-xs sm:text-sm">Low Stock</div>
                    <div class="text-black text-2xl sm:text-3xl font-medium">{{ $lowStockCount }}</div>
                </div>
                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-amber-500/30 rounded flex items-center justify-center">
                    <img src="{{ asset('icons/pending_icon.svg') }}" alt="Low Stock Icon">
                </div>
            </div>

            <div class="w-full sm:w-48 h-24 bg-white rounded-lg p-3 sm:p-3.5 flex items-center gap-2.5 shadow-sm">
                <div class="flex-1 flex flex-col gap-1 sm:gap-2.5">
                    <div class="text-gray-500 text-xs sm:text-sm">Out of Stock</div>
                    <div class="text-black text-2xl sm:text-3xl font-medium">{{ $outOfStockCount }}</div>
                </div>
                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-red-700/30 rounded flex items-center justify-center">
                    <img src="{{ asset('icons/out_of_stock_icon.svg') }}" alt="Out of Stock Icon">
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mt-5 bg-white rounded-lg shadow-sm">
            <!-- Search and Add Buttons -->
            <div class="px-3 sm:px-7 py-3 sm:py-3.5 flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
                <div class="w-full sm:w-52 px-2.5 py-2 rounded border border-gray-200 flex items-center gap-2">
                    <img src="{{ asset('icons/search_icon.svg') }}" alt="Search Icon">
                    <input type="text" id="productSearchInput" placeholder="Search Products..."
                        class="text-sm text-gray-500 focus:outline-none w-full">
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <button onclick="window.openCategoryModal()"
                        class="w-full sm:w-auto px-4 py-2 bg-[#F91D7C] text-white rounded flex items-center justify-center gap-2 hover:bg-[#F91D7C]/90 transition-colors">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Category Icon">
                        <span class="text-sm font-semibold">Category</span>
                    </button>
                    <button onclick="window.openProductModalDirect()"
                        class="w-full sm:w-auto px-4 py-2 bg-[#F91D7C] text-white rounded flex items-center justify-center gap-2 hover:bg-[#F91D7C]/90 transition-colors">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Product Icon">
                        <span class="text-sm font-semibold">Product</span>
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="px-3 sm:px-7 pt-3">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stock Status Tabs -->
            <div class="border-b border-gray-200">
                <div class="px-3 sm:px-7 flex gap-3 sm:gap-5 overflow-x-auto">
                    @foreach(['instock' => 'In Stock', 'lowstock' => 'Low Stock', 'outofstock' => 'Out of Stock'] as $tabId => $tabName)
                        <a href="{{ request()->url() }}?tab={{ $tabId }}"
                            class="relative px-2 sm:px-2.5 pt-2.5 pb-2 {{ $currentTab == $tabId ? 'text-[#F91D7C]' : 'text-black hover:text-[#F91D7C]' }} text-xs sm:text-sm whitespace-nowrap">
                            {{ $tabName }}
                            @if($currentTab == $tabId)
                                <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#F91D7C]"></div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Product Listing -->
            <div>
                <!-- Desktop Table -->
                <div class="hidden md:block px-3 sm:px-7 py-3.5 overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 text-gray-500 font-normal text-base">Product</th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base">Category</th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base">Stock</th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base">Price</th>
                                <th class="text-center py-3 text-gray-500 font-normal text-base">Status</th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paginatedProducts as $product)
                                <tr class="border-b border-gray-200">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3.5">
                                            <img src="{{ asset('placeholder.png') }}" alt="{{ $product->name }}"
                                                class="w-12 h-12 rounded border border-gray-200 object-cover">
                                            <span class="text-black text-base">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-black text-base">{{ $product->category->name }}</td>
                                    <td class="py-4 text-black text-base">{{ $product->quantity }}</td>
                                    <td class="py-4 text-black text-base">₱ {{ number_format($product->price, 2) }}</td>
                                    <td class="py-4 text-center">
                                        <span
                                            class="px-3 py-2 {{ $product->status_color }} text-sm rounded">{{ $product->status }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-3.5">
                                            <button onclick="window.openEditProductModalDirect('{{ $product->product_ID }}')"
                                                class="text-green-600 hover:text-green-700">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit Icon">
                                            </button>
                                            <form action="{{ route('inventory.destroy', $product->product_ID) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700">
                                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete Icon">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden p-3">
                    @forelse($paginatedProducts as $product)
                        <div class="bg-white rounded-lg shadow-sm mb-3 p-4 border border-gray-100">
                            <div class="flex items-start gap-3">
                                <img src="{{ asset('placeholder.png') }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 rounded border border-gray-200 object-cover">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-black">{{ $product->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $product->category->name }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-sm font-semibold text-black">₱
                                            {{ number_format($product->price, 2) }}</span>
                                        <span class="text-xs text-gray-600">Stock: {{ $product->quantity }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                <span
                                    class="px-2 py-1 {{ $product->status_color }} text-xs rounded">{{ $product->status }}</span>
                                <div class="flex items-center gap-3">
                                    <button onclick="window.openEditProductModalDirect('{{ $product->product_ID }}')"
                                        class="text-green-600 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('inventory.destroy', $product->product_ID) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-gray-500">No products found.</div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($totalItemsForTab > 0)
                    <div
                        class="px-3 sm:px-7 py-3.5 flex flex-col sm:flex-row justify-between items-center gap-3 border-t border-gray-200">
                        <div class="text-black text-xs sm:text-sm">
                            Showing {{ $startingItem }} to {{ $endingItem }} of {{ $totalItemsForTab }} results
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2.5">
                            <a href="{{ request()->url() }}?tab={{ $currentTab }}&page={{ max(1, $currentPage - 1) }}"
                                class="px-2 sm:px-2.5 py-1.5 rounded border border-gray-200 text-gray-500 text-xs sm:text-sm hover:bg-gray-50 {{ $currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                Previous
                            </a>

                            @for ($i = 1; $i <= min(3, $totalPages); $i++)
                                <a href="{{ request()->url() }}?tab={{ $currentTab }}&page={{ $i }}"
                                    class="w-7 px-2 py-1.5 {{ $currentPage == $i ? 'bg-[#F91D7C] text-white' : 'border border-gray-200 text-gray-500 hover:bg-[#F91D7C]/10' }} rounded text-xs sm:text-sm">
                                    {{ $i }}
                                </a>
                            @endfor

                            <a href="{{ request()->url() }}?tab={{ $currentTab }}&page={{ min($totalPages, $currentPage + 1) }}"
                                class="px-2 sm:px-2.5 py-1.5 rounded border border-gray-200 text-gray-500 text-xs sm:text-sm hover:bg-gray-50 {{ $currentPage >= $totalPages ? 'opacity-50 cursor-not-allowed' : '' }}">
                                Next
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('inventory.modals.addProduct')
    @include('inventory.modals.addCategory')
@endsection

@push('scripts')
    <script src="{{ asset('js/product-search.js') }}"></script>
@endpush

@php
    $activePage = 'inventory'; // Set the active page for this specific view
@endphp