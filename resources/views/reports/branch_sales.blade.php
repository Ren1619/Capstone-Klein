<div id="branch-dashboard">
    <div class="bg-white p-4 rounded-lg shadow mb-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-normal">Sales History</h3>
            <button id="exportSalesBtn" class="text-[#F91D7C] z-10 flex items-center">
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
                            <tbody class="sales-data">
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123987</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">01:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Earl Francis M. Amoy</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 300,000.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123986</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">12:09 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Klein M. Allen</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 3,920.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123985</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">10:45 am</td>
                                    <td class="py-3 text-black text-base font-normal">Van Kendrick O. Caseres</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 8,750.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123984</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">4:30 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Melbert A. Buligan</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 12,450.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123983</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">3:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Ralph C. Jumao-as</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 5,680.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden">
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123987</p>
                                    <p class="text-neutral-500">4/7/2025 - 01:15 pm</p>
                                    <p>Earl Francis M. Amoy</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 300,000.00</p>
                                </div>
                            </div>
                        </div>
                        <!-- Additional mobile invoice entries -->
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123986</p>
                                    <p class="text-neutral-500">4/7/2025 - 12:09 pm</p>
                                    <p>Klein M. Allen</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 3,920.00</p>
                                </div>
                            </div>
                        </div>
                        <!-- More mobile entries (abbreviated for clarity) -->
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123985</p>
                                    <p class="text-neutral-500">4/7/2025 - 10:45 am</p>
                                    <p>Van Kendrick O. Caseres</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 8,750.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Malaybalay Branch Content -->
            <div id="malaybalay-content" class="branch-content hidden">
                <div class="px-3 mb-6">
                    <!-- Desktop View Table - Structured the same as Valencia for consistency -->
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
                            <tbody class="sales-data">
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123987</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">01:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Earl Francis M. Amoy</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 300,000.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123986</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">12:09 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Klein M. Allen</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 3,920.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123985</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">10:45 am</td>
                                    <td class="py-3 text-black text-base font-normal">Van Kendrick O. Caseres</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 8,750.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123984</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">4:30 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Melbert A. Buligan</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 12,450.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123983</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">3:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Ralph C. Jumao-as</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 5,680.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden">
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123987</p>
                                    <p class="text-neutral-500">4/7/2025 - 01:15 pm</p>
                                    <p>Earl Francis M. Amoy</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 300,000.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123986</p>
                                    <p class="text-neutral-500">4/7/2025 - 12:09 pm</p>
                                    <p>Klein M. Allen</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 3,920.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123985</p>
                                    <p class="text-neutral-500">4/7/2025 - 10:45 am</p>
                                    <p>Van Kendrick O. Caseres</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 8,750.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123984</p>
                                    <p class="text-neutral-500">4/6/2025 - 4:30 pm</p>
                                    <p>Melbert A. Buligan</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 12,450.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123983</p>
                                    <p class="text-neutral-500">4/6/2025 - 3:15 pm</p>
                                    <p>Ralph C. Jumao-as</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 5,680.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maramag Branch Content -->
            <div id="maramag-content" class="branch-content hidden">
                <div class="px-3 mb-6">
                    <!-- Same table structure as other branches -->
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
                            <tbody class="sales-data">
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123987</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">01:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Earl Francis M. Amoy</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 300,000.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123986</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">12:09 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Klein M. Allen</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 3,920.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123985</td>
                                    <td class="py-3 text-black text-base font-normal">4/7/2025</td>
                                    <td class="py-3 text-black text-base font-normal">10:45 am</td>
                                    <td class="py-3 text-black text-base font-normal">Van Kendrick O. Caseres</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 8,750.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123984</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">4:30 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Melbert A. Buligan</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 12,450.00</td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                    <td class="py-3 text-black text-base font-normal">123983</td>
                                    <td class="py-3 text-black text-base font-normal">4/6/2025</td>
                                    <td class="py-3 text-black text-base font-normal">3:15 pm</td>
                                    <td class="py-3 text-black text-base font-normal">Ralph C. Jumao-as</td>
                                    <td class="py-3 text-black text-base font-normal text-right">₱ 5,680.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden">
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123987</p>
                                    <p class="text-neutral-500">4/7/2025 - 01:15 pm</p>
                                    <p>Earl Francis M. Amoy</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 300,000.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123986</p>
                                    <p class="text-neutral-500">4/7/2025 - 12:09 pm</p>
                                    <p>Klein M. Allen</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 3,920.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123985</p>
                                    <p class="text-neutral-500">4/7/2025 - 10:45 am</p>
                                    <p>Van Kendrick O. Caseres</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 8,750.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123984</p>
                                    <p class="text-neutral-500">4/6/2025 - 4:30 pm</p>
                                    <p>Melbert A. Buligan</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 12,450.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-entry border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <p class="font-medium">Invoice No. 123983</p>
                                    <p class="text-neutral-500">4/6/2025 - 3:15 pm</p>
                                    <p>Ralph C. Jumao-as</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱ 5,680.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Section - Now included inside branch tab content -->
        <div id="pagination-controls" class="w-full flex flex-col sm:flex-row justify-between items-center mt-5">
            <div class="text-sm text-gray-600 mb-3 sm:mb-0">Showing 1 to 5 of 9 results</div>
            <div class="flex space-x-1">
                <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500">Previous</button>
                <button
                    class="w-8 h-8 flex items-center justify-center bg-[#F91D7C] text-white rounded text-sm">1</button>
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-sm">2</button>
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-sm">3</button>
                <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500">Next</button>
            </div>
        </div>
    </div>

    <!-- Combined Overall Sales Reports -->
    <div class="mb-8">
        <!-- <h2 class="text-xl font-semibold text-black mb-4">Overall Sales Reports</h2>
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-black">Overall Sales Reports</h2>
        </div> -->

        <!-- Side-by-side reports -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Daily Report -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-normal mb-3">Daily Report</h3>
                <div class="h-56">
                    <canvas class="daily-chart"></canvas>
                </div>
            </div>

            <!-- Weekly Report -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-normal mb-3">Weekly Report</h3>
                <div class="h-56">
                    <canvas class="weekly-chart"></canvas>
                </div>
            </div>

            <!-- Monthly Report -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-normal mb-3">Monthly Report</h3>
                <div class="h-56">
                    <canvas class="monthly-chart"></canvas>
                </div>
            </div>
        </div>
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

        // Initialize tabs functionality
        initBranchTabs();

        // Initialize horizontal scrolling
        initScrollNavigation();

        // Handle pagination visibility - now showing for all branches
        function togglePagination(branchId) {
            // Show pagination for all branches including Maramag
            paginationControls.classList.remove('hidden');
        }

        function initBranchTabs() {
            // Set initial tab state
            const initialTab = branchTabs[0];
            const initialBranchId = initialTab.getAttribute('data-branch');
            togglePagination(initialBranchId);

            // Add click handlers to all tabs
            branchTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Remove active state from all tabs
                    branchTabs.forEach(t => {
                        t.classList.remove('active');

                        // Remove text color
                        const button = t.querySelector('button');
                        if (button) button.classList.remove('text-[#F91D7C]');

                        // Remove indicator
                        const indicator = t.querySelector('div.absolute');
                        if (indicator) indicator.remove();
                    });

                    // Add active state to clicked tab
                    this.classList.add('active');

                    // Add colored text
                    const button = this.querySelector('button');
                    if (button) button.classList.add('text-[#F91D7C]');

                    // Add indicator line
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

                    // Toggle pagination based on selected branch
                    togglePagination(branchId);

                    // Ensure the tab is visible in the scroll area
                    scrollTabIntoView(this);
                });
            });
        }

        function initScrollNavigation() {
            // Check if scrolling is needed
            function checkScroll() {
                const hasOverflow = tabsContainer.scrollWidth > tabsContainer.clientWidth;
                const atStart = tabsContainer.scrollLeft <= 0;
                const atEnd = tabsContainer.scrollLeft + tabsContainer.clientWidth >= tabsContainer.scrollWidth - 1;

                scrollLeftBtn.classList.toggle('hidden', atStart || !hasOverflow);
                scrollRightBtn.classList.toggle('hidden', atEnd || !hasOverflow);
            }

            // Scroll handling
            scrollLeftBtn.addEventListener('click', () => tabsContainer.scrollBy({ left: -100, behavior: 'smooth' }));
            scrollRightBtn.addEventListener('click', () => tabsContainer.scrollBy({ left: 100, behavior: 'smooth' }));

            // Monitor scrolling
            tabsContainer.addEventListener('scroll', checkScroll);
            window.addEventListener('resize', checkScroll);

            // Initial check
            checkScroll();
        }

        function scrollTabIntoView(tab) {
            const tabLeft = tab.offsetLeft;
            const tabWidth = tab.offsetWidth;
            const containerWidth = tabsContainer.clientWidth;
            const containerScrollLeft = tabsContainer.scrollLeft;

            if (tabLeft < containerScrollLeft) {
                // Tab is to the left of the visible area
                tabsContainer.scrollTo({ left: tabLeft, behavior: 'smooth' });
            } else if (tabLeft + tabWidth > containerScrollLeft + containerWidth) {
                // Tab is to the right of the visible area
                tabsContainer.scrollTo({ left: tabLeft + tabWidth - containerWidth, behavior: 'smooth' });
            }
        }

        // Initialize charts (placeholder for actual chart initialization)
        document.querySelectorAll('.branch-chart').forEach(chart => {
            const type = chart.getAttribute('data-type');
            // Placeholder for actual chart initialization
            console.log(`Initialize ${type} chart`);
        });

        // Event delegation for invoice entries
        document.addEventListener('click', function (e) {
            if (e.target.closest('.invoice-entry')) {
                console.log('Invoice clicked');
                // Handle invoice click
            }

            if (e.target.closest('#exportSalesBtn')) {
                console.log('Export clicked');
                // Handle export button click
            }
        });
    });
</script>