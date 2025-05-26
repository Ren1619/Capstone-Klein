<div id="branch-dashboard">
    <div class="bg-white p-4 rounded-lg shadow mb-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-normal">Sales History</h3>
            <button id="exportSalesBtn" class="text-[#F91D7C] z-10 flex items-center hover:text-[#D91A60]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
        </div>

        <!-- Branch Navigation Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <div class="relative">
                    <!-- Tabs Container with Horizontal Scroll -->
                    <div class="flex px-2 overflow-x-auto scrollbar-hide" id="branch-tabs">
                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 branch-tab flex-shrink-0 active"
                            data-branch="valencia">
                            <button class="text-xs sm:text-sm text-[#F91D7C] whitespace-nowrap">Valencia Branch</button>
                            <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 branch-tab flex-shrink-0"
                            data-branch="malaybalay">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Malaybalay Branch</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 branch-tab flex-shrink-0"
                            data-branch="maramag">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Maramag Branch</button>
                        </div>
                    </div>

                    <!-- Scroll Arrows -->
                    <button id="scroll-left"
                        class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="scroll-right"
                        class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Branch Content Panels -->
        <div id="branch-content-panels">
            <!-- Valencia Branch Content -->
            <div id="valencia-content" class="branch-content">
                <div class="px-3 mb-6">
                    <!-- Desktop View Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Invoice No.</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Date</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Time</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 30%;">Customer</th>
                                    <th class="pb-3 pt-3 text-right text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="sales-data" id="valencia-sales-data">
                                <!-- Sales data will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden" id="valencia-mobile-data">
                        <!-- Mobile sales data will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Malaybalay Branch Content -->
            <div id="malaybalay-content" class="branch-content hidden">
                <div class="px-3 mb-6">
                    <!-- Desktop View Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Invoice No.</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Date</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Time</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 30%;">Customer</th>
                                    <th class="pb-3 pt-3 text-right text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="sales-data" id="malaybalay-sales-data">
                                <!-- Sales data will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden" id="malaybalay-mobile-data">
                        <!-- Mobile sales data will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Maramag Branch Content -->
            <div id="maramag-content" class="branch-content hidden">
                <div class="px-3 mb-6">
                    <!-- Desktop View Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Invoice No.</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Date</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 15%;">Time</th>
                                    <th class="pb-3 pt-3 text-left text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 30%;">Customer</th>
                                    <th class="pb-3 pt-3 text-right text-neutral-500 text-base font-normal whitespace-nowrap"
                                        style="width: 20%;">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="sales-data" id="maramag-sales-data">
                                <!-- Sales data will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden" id="maramag-mobile-data">
                        <!-- Mobile sales data will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Section -->
        <div id="pagination-controls" class="w-full flex flex-col sm:flex-row justify-between items-center mt-5">
            <div class="text-sm text-gray-600 mb-3 sm:mb-0" id="pagination-info">Showing 0 to 0 of 0 results</div>
            <div class="flex space-x-1" id="pagination-buttons">
                <!-- Pagination buttons will be generated here -->
            </div>
        </div>
    </div>

    <!-- No Data Message -->
    <div id="no-data-message" class="bg-white p-8 rounded-lg shadow text-center hidden">
        <div class="text-gray-400 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No Sales Data</h3>
        <p class="text-gray-600">No sales records found for the selected branch.</p>
    </div>
</div>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .branch-tab.active button {
        color: #F91D7C;
    }

    .loading-row {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .loading-cell {
        background-color: #f3f4f6;
        height: 20px;
        border-radius: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Element references
        const branchTabs = document.querySelectorAll('.branch-tab');
        const branchContents = document.querySelectorAll('.branch-content');
        const paginationControls = document.getElementById('pagination-controls');
        const tabsContainer = document.getElementById('branch-tabs');
        const scrollLeftBtn = document.getElementById('scroll-left');
        const scrollRightBtn = document.getElementById('scroll-right');
        const exportBtn = document.getElementById('exportSalesBtn');

        // Current state
        let currentBranch = 'valencia';
        let currentPage = 1;
        let totalPages = 1;
        let salesData = {};

        // Initialize tabs functionality
        initBranchTabs();
        initScrollNavigation();

        // Load initial data
        loadBranchSales(currentBranch, currentPage);

        // Export functionality
        exportBtn.addEventListener('click', exportSales);

        function initBranchTabs() {
            branchTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Remove active state from all tabs
                    branchTabs.forEach(t => {
                        t.classList.remove('active');
                        const button = t.querySelector('button');
                        if (button) button.classList.remove('text-[#F91D7C]');
                        const indicator = t.querySelector('div.absolute');
                        if (indicator) indicator.remove();
                    });

                    // Add active state to clicked tab
                    this.classList.add('active');
                    const button = this.querySelector('button');
                    if (button) button.classList.add('text-[#F91D7C]');
                    const indicator = document.createElement('div');
                    indicator.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                    this.appendChild(indicator);

                    // Show corresponding content
                    const branchId = this.getAttribute('data-branch');
                    branchContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    const selectedContent = document.getElementById(`${branchId}-content`);
                    if (selectedContent) selectedContent.classList.remove('hidden');

                    // Update current branch and load data
                    currentBranch = branchId;
                    currentPage = 1;
                    loadBranchSales(currentBranch, currentPage);

                    // Ensure the tab is visible in the scroll area
                    scrollTabIntoView(this);
                });
            });
        }

        function initScrollNavigation() {
            function checkScroll() {
                const hasOverflow = tabsContainer.scrollWidth > tabsContainer.clientWidth;
                const atStart = tabsContainer.scrollLeft <= 0;
                const atEnd = tabsContainer.scrollLeft + tabsContainer.clientWidth >= tabsContainer.scrollWidth - 1;

                scrollLeftBtn.classList.toggle('hidden', atStart || !hasOverflow);
                scrollRightBtn.classList.toggle('hidden', atEnd || !hasOverflow);
            }

            scrollLeftBtn.addEventListener('click', () => tabsContainer.scrollBy({ left: -100, behavior: 'smooth' }));
            scrollRightBtn.addEventListener('click', () => tabsContainer.scrollBy({ left: 100, behavior: 'smooth' }));

            tabsContainer.addEventListener('scroll', checkScroll);
            window.addEventListener('resize', checkScroll);
            checkScroll();
        }

        function scrollTabIntoView(tab) {
            const tabLeft = tab.offsetLeft;
            const tabWidth = tab.offsetWidth;
            const containerWidth = tabsContainer.clientWidth;
            const containerScrollLeft = tabsContainer.scrollLeft;

            if (tabLeft < containerScrollLeft) {
                tabsContainer.scrollTo({ left: tabLeft, behavior: 'smooth' });
            } else if (tabLeft + tabWidth > containerScrollLeft + containerWidth) {
                tabsContainer.scrollTo({ left: tabLeft + tabWidth - containerWidth, behavior: 'smooth' });
            }
        }

        // Load branch sales data
        async function loadBranchSales(branch, page = 1) {
            if (window.showLoading) window.showLoading();

            try {
                const response = await fetch(`/api/sales?branch=${branch}&page=${page}`);
                const data = await response.json();

                salesData[branch] = data.data;
                updateSalesDisplay(branch, data);
                updatePagination(data);

                // Hide no data message if we have data
                document.getElementById('no-data-message').classList.add('hidden');
                paginationControls.classList.remove('hidden');

            } catch (error) {
                console.error('Error loading branch sales:', error);
                showNoDataMessage();
            } finally {
                if (window.hideLoading) window.hideLoading();
            }
        }

        // Update sales display
        function updateSalesDisplay(branch, responseData) {
            const salesDataElement = document.getElementById(`${branch}-sales-data`);
            const mobileDataElement = document.getElementById(`${branch}-mobile-data`);
            const sales = responseData.data;

            if (!sales || sales.length === 0) {
                showNoDataMessage();
                return;
            }

            // Clear existing data
            salesDataElement.innerHTML = '';
            mobileDataElement.innerHTML = '';

            // Populate desktop table
            sales.forEach(sale => {
                const row = createDesktopSaleRow(sale);
                salesDataElement.appendChild(row);
            });

            // Populate mobile cards
            sales.forEach(sale => {
                const card = createMobileSaleCard(sale);
                mobileDataElement.appendChild(card);
            });
        }

        // Create desktop table row
        function createDesktopSaleRow(sale) {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-[#F91D7C]/5 cursor-pointer';
            row.onclick = () => viewSaleDetails(sale.sale_ID);

            const date = new Date(sale.date);
            const time = new Date(sale.created_at);

            row.innerHTML = `
                <td class="py-3 text-black text-base font-normal">${sale.sale_ID}</td>
                <td class="py-3 text-black text-base font-normal">${date.toLocaleDateString()}</td>
                <td class="py-3 text-black text-base font-normal">${time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</td>
                <td class="py-3 text-black text-base font-normal">${sale.customer_name}</td>
                <td class="py-3 text-black text-base font-normal text-right">${window.formatCurrency ? window.formatCurrency(sale.total_cost) : '₱' + parseFloat(sale.total_cost).toLocaleString()}</td>
            `;

            return row;
        }

        // Create mobile card
        function createMobileSaleCard(sale) {
            const card = document.createElement('div');
            card.className = 'invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5 cursor-pointer';
            card.onclick = () => viewSaleDetails(sale.sale_ID);

            const date = new Date(sale.date);
            const time = new Date(sale.created_at);

            card.innerHTML = `
                <div class="flex justify-between items-center">
                    <div class="text-sm">
                        <p class="font-medium">Invoice No. ${sale.sale_ID}</p>
                        <p class="text-neutral-500">${date.toLocaleDateString()} - ${time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                        <p>${sale.customer_name}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">${window.formatCurrency ? window.formatCurrency(sale.total_cost) : '₱' + parseFloat(sale.total_cost).toLocaleString()}</p>
                    </div>
                </div>
            `;

            return card;
        }

        // Update pagination
        function updatePagination(data) {
            const { current_page, last_page, from, to, total } = data;

            totalPages = last_page;
            currentPage = current_page;

            // Update pagination info
            document.getElementById('pagination-info').textContent =
                `Showing ${from || 0} to ${to || 0} of ${total} results`;

            // Generate pagination buttons
            const paginationButtons = document.getElementById('pagination-buttons');
            paginationButtons.innerHTML = '';

            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.className = `px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${current_page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}`;
            prevBtn.textContent = 'Previous';
            prevBtn.disabled = current_page === 1;
            prevBtn.onclick = () => {
                if (current_page > 1) {
                    loadBranchSales(currentBranch, current_page - 1);
                }
            };
            paginationButtons.appendChild(prevBtn);

            // Page number buttons
            const startPage = Math.max(1, current_page - 2);
            const endPage = Math.min(last_page, startPage + 4);

            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `w-8 h-8 flex items-center justify-center text-sm rounded ${i === current_page
                        ? 'bg-[#F91D7C] text-white'
                        : 'border border-gray-200 hover:bg-gray-50'
                    }`;
                pageBtn.textContent = i;
                pageBtn.onclick = () => loadBranchSales(currentBranch, i);
                paginationButtons.appendChild(pageBtn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = `px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${current_page === last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}`;
            nextBtn.textContent = 'Next';
            nextBtn.disabled = current_page === last_page;
            nextBtn.onclick = () => {
                if (current_page < last_page) {
                    loadBranchSales(currentBranch, current_page + 1);
                }
            };
            paginationButtons.appendChild(nextBtn);
        }

        // Show no data message
        function showNoDataMessage() {
            document.getElementById('no-data-message').classList.remove('hidden');
            paginationControls.classList.add('hidden');

            // Clear existing data in all tables
            ['valencia', 'malaybalay', 'maramag'].forEach(branch => {
                document.getElementById(`${branch}-sales-data`).innerHTML = '';
                document.getElementById(`${branch}-mobile-data`).innerHTML = '';
            });
        }

        // View sale details
        function viewSaleDetails(saleId) {
            // Implement sale details view - could open a modal or navigate to details page
            console.log('View sale details for:', saleId);
            // You can implement this based on your requirements
            // For example: window.location.href = `/sales/${saleId}`;
        }

        // Export sales data
        async function exportSales() {
            try {
                const params = new URLSearchParams({
                    branch: currentBranch,
                    format: 'csv'
                });

                // Create a temporary link to download the file
                const link = document.createElement('a');
                link.href = `/api/sales/export?${params.toString()}`;
                link.download = `${currentBranch}-sales-${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Error exporting sales:', error);
                alert('Failed to export sales data. Please try again.');
            }
        }

        // Make functions globally available if needed
        window.loadBranchSales = loadBranchSales;
        window.viewSaleDetails = viewSaleDetails;
    });
</script>