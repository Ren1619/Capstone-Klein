<div id="patient-tabs">
    {{-- Tabs Navigation --}}
    {{-- Responsive Tabs with Carousel for Small Devices --}}
    <div class="border-b border-gray-200">
        <div class="relative">
            {{-- Tabs Container with Horizontal Scroll --}}
            <div class="flex px-2 overflow-x-auto scrollbar-hide" id="tabs-carousel">
                <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer tab-btn active flex-shrink-0"
                    data-tab="visit">
                    <button class="text-xs sm:text-sm text-[#F91D7C] whitespace-nowrap">Services</button>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                </div>

                <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medical">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Products</button>
                </div>

                <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="allergies">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Diagnosis</button>
                </div>

                <div class="relative px-3 sm:px-4 py-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medications">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Prescription</button>
                </div>
            </div>

            {{-- Left Arrow (hidden by default, shown when scrollable) --}}
            <button id="scroll-left"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Right Arrow (hidden by default, shown when scrollable) --}}
            <button id="scroll-right"
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>




    {{-- Tab Content --}}
    <div class="p-5">


        {{-- Visit Service Content --}}
        <div id="visit-content" class="tab-content"
            data-visit-id="{{ $visit->visit_ID ?? request()->route('visit') ?? request()->input('visit_id') ?? '' }}">

            @php
                // EMERGENCY FIX: Fetch data directly if not provided
                $visitId = $visit->visit_ID ?? request()->route('visit') ?? request()->input('visit_id');

                if (!isset($visit) && $visitId) {
                    $visit = \App\Models\Patients\VisitHistory::find($visitId);
                }

                if (!isset($visitServices) && isset($visit)) {
                    $visitServices = \App\Models\Patients\VisitService::with('service')
                        ->where('visit_ID', $visit->visit_ID)
                        ->get();
                } elseif (!isset($visitServices)) {
                    $visitServices = collect();
                }

                // Get all services for the dropdown
                $allServices = \App\Models\Service::orderBy('name', 'asc')
                    ->get(['service_ID', 'name', 'price', 'description']);
            @endphp


            {{-- Pass all services data to JavaScript through data attribute --}}
            <div id="services-data" class="hidden" data-services="{{ json_encode($allServices ?? []) }}"></div>


            <div class="flex justify-end mb-4">
                <button id="availServiceBtn" class="text-[#F91D7C] z-10 flex items-center gap-2"
                    onclick="openAddServiceModal()">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Service">
                </button>
            </div>



            {{-- Desktop View --}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Service Name
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visitServices as $index => $visitService)
                            <tr class="  border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="view-service-btn border-b py-3 text-black text-sm md:text-base font-normal font-poppins"
                                    data-id="{{ $visitService->visit_services_ID }}">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $visitService->service->name ?? 'Unknown Service' }}</span>
                                    {{-- @if($visitService->note)
                                    <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitService->note }}</p>
                                    @endif --}}
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button
                                            class="edit-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitService->visit_services_ID }}">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>


                                        {{-- delete button --}}
                                        <form method="POST"
                                            action="{{ route('visit-services.destroy', $visitService->visit_services_ID) }}"
                                            class="inline delete-service-form">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" name="visit_ID" value="{{ $visit->visit_ID ?? '' }}">

                                            <button type="button"
                                                class="delete-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                                onclick="confirmDeleteWithSweetAlert(this)">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">
                                    No services added to this visit yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden">
                @forelse ($visitServices as $index => $visitService)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="view-service-btn border-btn" data-id="{{ $visitService->visit_services_ID }}">
                                <p class="text-sm font-normal">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    {{ $visitService->service->name ?? 'Unknown Service' }}
                                </p>
                                {{-- @if($visitService->note)
                                <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitService->note }}</p>
                                @endif --}}
                            </div>
                            <div class="flex items-center gap-3">
                                {{-- edit button --}}
                                <button
                                    class="edit-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $visitService->visit_services_ID }}">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <button class="delete-service-btn w-6 h-6" data-id="{{ $visitService->visit_services_ID }}"
                                    onclick="confirmDeleteService({{ $visitService->visit_services_ID }})">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">
                        No services added to this visit yet. Click the "Add Service" button above to add a service.
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(isset($visitServices) && $visitServices instanceof \Illuminate\Pagination\LengthAwarePaginator && $visitServices->total() > $visitServices->perPage())
                <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center mt-4">
                    <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                        Showing {{ $visitServices->firstItem() ?? 0 }} to {{ $visitServices->lastItem() ?? 0 }} of
                        {{ $visitServices->total() }} results
                    </div>
                    <div class="flex space-x-1">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            {{-- Previous Page Link --}}
                            @if($visitServices->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $visitServices->previousPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}&visit_id={{ $visitId ?? '' }}"
                                    rel="prev"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Previous
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $visitServices->lastPage(); $i++)
                                {{-- "Three Dots" Separator --}}
                                @if ($i == $visitServices->currentPage())
                                    <span aria-current="page"
                                        class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-white bg-[#F91D7C] border border-[#F91D7C] cursor-default leading-5 rounded-md">
                                        {{ $i }}
                                    </span>
                                @else
                                    <a href="{{ $visitServices->url($i) }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}&visit_id={{ $visitId ?? '' }}"
                                        class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if($visitServices->hasMorePages())
                                <a href="{{ $visitServices->nextPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}&visit_id={{ $visitId ?? '' }}"
                                    rel="next"
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Next
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Next
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            @endif
        </div>






        {{-- Visit Product Content --}}
        <div id="medical-content" class="tab-content hidden"
            data-visit-id="{{ $visit->visit_ID ?? request()->route('visit') ?? request()->input('visit_id') ?? '' }}">
            <div class="flex justify-end mb-4">
                <button id="addProductBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Product">
                </button>
            </div>

            @php
                // EMERGENCY FIX: Fetch data directly if not provided
                $visitId = $visit->visit_ID ?? request()->route('visit') ?? request()->input('visit_id');

                if (!isset($visit) && $visitId) {
                    $visit = \App\Models\Patients\VisitHistory::find($visitId);
                }

                if (!isset($visitProducts) && isset($visit)) {
                    $visitProducts = \App\Models\Patients\VisitProduct::with('product')
                        ->where('visit_ID', $visit->visit_ID)
                        ->get();
                } elseif (!isset($visitProducts)) {
                    $visitProducts = collect();
                }

                // Get all products for the dropdown
                $allProducts = \App\Models\Product::orderBy('name', 'asc')
                    ->get(['product_ID', 'name', 'price']);
            @endphp

            {{-- Pass all products data to JavaScript through data attribute --}}
            <div id="products-data" class="hidden" data-products="{{ json_encode($allProducts ?? []) }}"></div>

            {{-- Desktop View --}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Product Name
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visitProducts as $index => $visitProduct)
                            <tr class=" border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="view-product-btn py-3 text-black text-sm md:text-base font-normal font-poppins"
                                    data-id="{{ $visitProduct->visit_products_ID }}">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $visitProduct->product->name ?? 'Unknown Product' }}</span>
                                    <!-- @if($visitProduct->note)
                                        <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitProduct->note }}</p>
                                    @endif
                                    @if($visitProduct->quantity)
                                        <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5 ml-2">
                                            Qty: {{ $visitProduct->quantity }}
                                        </span>
                                    @endif -->
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button
                                            class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitProduct->visit_products_ID }}">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}



                                        <form method="POST"
                                            action="{{ route('visit-products.destroy', $visitProduct->visit_products_ID) }}"
                                            class="inline delete-product-form">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" name="visit_ID" value="{{ $visit->visit_ID ?? '' }}">

                                            <button type="button"
                                                class="delete-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                                onclick="confirmDeleteWithSweetAlert(this)">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">
                                    No products added to this visit yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden">
                @forelse ($visitProducts as $index => $visitProduct)
                    <div class=" border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="view-product-btn text-sm font-poppins"
                                data-id="{{ $visitProduct->visit_products_ID }}">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $visitProduct->product->name ?? 'Unknown Product' }}</span>
                                <!-- @if($visitProduct->quantity)
                                    <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5 ml-2">
                                        Qty: {{ $visitProduct->quantity }}
                                    </span>
                                @endif -->
                                <!-- @if($visitProduct->note)
                                    <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitProduct->note }}</p>
                                @endif -->
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button
                                    class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $visitProduct->visit_products_ID }}">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
                                <button
                                    class="delete-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $visitProduct->visit_products_ID }}">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">
                        No products added to this visit yet.
                    </div>
                @endforelse
            </div>
        </div>





        {{-- Diagnosis Content --}}
        <div id="allergies-content" class="tab-content hidden">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Notes
                </label>
                <textarea id="productNotes" name="productNotes" rows="8"
                    class="w-full h-80 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                    placeholder="Write down the diagnosis"></textarea>
                <div id="saveStatus" class="text-xs text-gray-500 mt-1">
                    <span id="saveStatusText">Ready to save</span>
                </div>
            </div>


        </div>





        {{-- Prescription Content --}}
        <div id="medications-content" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <button id="addPrescriptionBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Prescription">
                </button>
            </div>

            {{-- Desktop View --}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Prescription
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitRecord->prescriptions as $index => $prescription)
                            <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="view-prescription-btn py-3 text-black text-sm md:text-base font-normal font-poppins"
                                    data-id="{{ $prescription->prescription_ID }}">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $prescription->medication_name }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button
                                            class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $prescription->prescription_ID }}">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}
                                        <form class="delete-prescription-form"
                                            action="{{ route('prescriptions.destroy', $prescription->prescription_ID) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">
                                    No prescriptions added to this visit yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden">
                @forelse($visitRecord->prescriptions as $index => $prescription)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="view-prescription-btn flex justify-between items-center"
                            data-id="{{ $prescription->prescription_ID }}">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $prescription->medication_name }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button
                                    class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $prescription->prescription_ID }}">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
                                <form class="delete-prescription-form"
                                    action="{{ route('prescriptions.destroy', $prescription->prescription_ID) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">
                        No prescriptions added to this visit yet.
                    </div>
                @endforelse
            </div>
        </div>

    </div>






    {{-- for tab functionality --}}
    <script>


        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            const paginationSection = document.querySelector('.flex.flex-col.sm\\:flex-row.justify-between.items-center');

            // Function to toggle pagination visibility
            function togglePagination(tabId) {
                if (tabId === 'allergies') {
                    // Hide pagination for the Diagnosis tab
                    if (paginationSection) {
                        paginationSection.classList.add('hidden');
                    }
                } else {
                    // Show pagination for other tabs
                    if (paginationSection) {
                        paginationSection.classList.remove('hidden');
                    }
                }
            }

            // Set initial active tab (first tab)
            const firstTabBtn = tabBtns[0];
            if (firstTabBtn) {
                firstTabBtn.classList.add('active');
                const button = firstTabBtn.querySelector('button');
                if (button) button.classList.add('text-[#F91D7C]');

                // Add pink underline to initial active tab
                const underline = document.createElement('div');
                underline.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                firstTabBtn.appendChild(underline);

                // Set initial pagination state
                const initialTabId = firstTabBtn.getAttribute('data-tab');
                togglePagination(initialTabId);
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabBtns.forEach(b => {
                        b.classList.remove('active');
                        const button = b.querySelector('button');
                        if (button) button.classList.remove('text-[#F91D7C]');

                        // Remove pink underline if it exists
                        const underline = b.querySelector('div.absolute');
                        if (underline) {
                            underline.remove();
                        }
                    });

                    // Add active class to clicked button
                    btn.classList.add('active');

                    // Add pink text color
                    const button = btn.querySelector('button');
                    if (button) button.classList.add('text-[#F91D7C]');

                    // Add pink underline to active tab
                    const underline = document.createElement('div');
                    underline.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                    btn.appendChild(underline);

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show the selected tab content
                    const tabId = btn.getAttribute('data-tab');
                    const selectedTab = document.getElementById(`${tabId}-content`);
                    if (selectedTab) selectedTab.classList.remove('hidden');

                    // Toggle pagination visibility based on the selected tab
                    togglePagination(tabId);
                });
            });
        });
    </script>


    {{-- JavaScript to handle horizontal scrolling and show/hide arrows --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabsContainer = document.getElementById('tabs-carousel');
            const scrollLeftBtn = document.getElementById('scroll-left');
            const scrollRightBtn = document.getElementById('scroll-right');

            // Check if scrolling is needed
            function checkScroll() {
                if (tabsContainer.scrollWidth > tabsContainer.clientWidth) {
                    // Content is wider than container, show arrows
                    scrollRightBtn.classList.remove('hidden');

                    // Only show left arrow if not at the beginning
                    if (tabsContainer.scrollLeft > 0) {
                        scrollLeftBtn.classList.remove('hidden');
                    } else {
                        scrollLeftBtn.classList.add('hidden');
                    }

                    // Only show right arrow if not at the end
                    if (tabsContainer.scrollLeft + tabsContainer.clientWidth < tabsContainer.scrollWidth) {
                        scrollRightBtn.classList.remove('hidden');
                    } else {
                        scrollRightBtn.classList.add('hidden');
                    }
                } else {
                    // Content fits, hide arrows
                    scrollLeftBtn.classList.add('hidden');
                    scrollRightBtn.classList.add('hidden');
                }
            }

            // Scroll left when left arrow is clicked
            scrollLeftBtn.addEventListener('click', function () {
                tabsContainer.scrollBy({ left: -100, behavior: 'smooth' });
            });

            // Scroll right when right arrow is clicked
            scrollRightBtn.addEventListener('click', function () {
                tabsContainer.scrollBy({ left: 100, behavior: 'smooth' });
            });

            // Check scroll position on scroll
            tabsContainer.addEventListener('scroll', checkScroll);

            // Check on resize
            window.addEventListener('resize', checkScroll);

            // Initial check
            checkScroll();

            // Handle tab switching
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Remove active class from all tabs
                    tabBtns.forEach(tab => {
                        tab.classList.remove('active');
                        tab.querySelector('button').classList.remove('text-[#F91D7C]');
                        const indicator = tab.querySelector('div');
                        if (indicator) indicator.remove();
                    });

                    // Add active class to clicked tab
                    this.classList.add('active');
                    this.querySelector('button').classList.add('text-[#F91D7C]');

                    // Add indicator line
                    const indicator = document.createElement('div');
                    indicator.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                    this.appendChild(indicator);

                    // Scroll to make the active tab visible if needed
                    const tabLeft = this.offsetLeft;
                    const tabWidth = this.offsetWidth;
                    const containerWidth = tabsContainer.clientWidth;
                    const containerScrollLeft = tabsContainer.scrollLeft;

                    if (tabLeft < containerScrollLeft) {
                        // Tab is to the left of the visible area
                        tabsContainer.scrollTo({ left: tabLeft, behavior: 'smooth' });
                    } else if (tabLeft + tabWidth > containerScrollLeft + containerWidth) {
                        // Tab is to the right of the visible area
                        tabsContainer.scrollTo({ left: tabLeft + tabWidth - containerWidth, behavior: 'smooth' });
                    }
                });
            });
        });
    </script>




    {{-- diagnosis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const diagnosisTextarea = document.getElementById('productNotes');
            const saveStatus = document.getElementById('saveStatus');
            const saveStatusText = document.getElementById('saveStatusText');
            const debugOutput = document.getElementById('debugOutput');
            const debugContent = document.getElementById('debugContent');

            // Enable debug mode during development (set to false in production)
            const debugMode = false; // Can be toggled to false in production

            // Make sure debug elements exist even if not visible
            if (debugMode && debugOutput) {
                debugOutput.classList.remove('hidden');
            } else if (debugOutput) {
                debugOutput.classList.add('hidden');
            }

            // Extract visit ID from URL path
            const visitId = window.location.pathname.split('/').pop();

            // Silent debug in production mode
            function debug(message, data = null) {
                // Always log to console in both debug and production modes
                if (data) {
                    console.log(message, data);
                } else {
                    console.log(message);
                }

                // Only update the UI in debug mode
                if (debugMode && debugContent) {
                    const timestamp = new Date().toLocaleTimeString();
                    let debugMessage = `[${timestamp}] ${message}`;

                    if (data) {
                        const jsonStr = JSON.stringify(data, null, 2);
                        debugMessage += '\n' + jsonStr;
                    }

                    debugContent.textContent = debugMessage + '\n\n' + debugContent.textContent;
                }
            }

            debug('Initial setup', { visitId, urlPath: window.location.pathname });

            if (!visitId) {
                debug('ERROR: No visit ID found');
                return;
            }

            // State variables
            let lastSavedContent = diagnosisTextarea ? diagnosisTextarea.value : '';
            let saveTimeout = null;
            let isSaving = false;
            let diagnosisId = null;
            let loadAttempted = false;

            /**
             * Update the save status display - only show for active operations
             */
            function updateSaveStatus(status) {
                if (!saveStatus || !saveStatusText) return; // Guard clause

                if (status === 'idle' || status === 'done') {
                    // Hide status completely when idle or done
                    saveStatus.classList.add('hidden');
                    saveStatusText.textContent = '';
                } else if (status === 'saving') {
                    saveStatus.classList.remove('hidden');
                    saveStatusText.textContent = 'Saving';
                    saveStatusText.className = 'text-blue-500';
                } else if (status === 'saved') {
                    saveStatus.classList.remove('hidden');
                    saveStatusText.textContent = 'Saved';
                    saveStatusText.className = 'text-green-500';

                    // Automatically hide "Saved" message after 1.5 seconds
                    setTimeout(() => {
                        saveStatus.classList.add('hidden');
                    }, 1500);
                } else if (status === 'loading') {
                    saveStatus.classList.remove('hidden');
                    saveStatusText.textContent = 'Loading';
                    saveStatusText.className = 'text-blue-500';
                } else if (status === 'error') {
                    saveStatus.classList.remove('hidden');
                    saveStatusText.textContent = 'Error';
                    saveStatusText.className = 'text-red-500';

                    // Hide error message after 3 seconds
                    setTimeout(() => {
                        saveStatus.classList.add('hidden');
                    }, 3000);
                }
            }

            /**
             * Check if content has changed
             */
            function hasChanged() {
                return diagnosisTextarea && diagnosisTextarea.value !== lastSavedContent;
            }

            /**
             * Primary function to load diagnosis data
             */
            function loadDiagnosis() {
                if (!diagnosisTextarea) {
                    console.error('Diagnosis textarea not found');
                    return; // Early return if no textarea
                }

                debug('Loading diagnosis for visit', { visitId });
                updateSaveStatus('loading');
                loadAttempted = true;

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="_token"]')?.value || '';

                // Use index route with visit_ID filter
                fetch(`/diagnosis?visit_ID=${visitId}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        debug('Response received', {
                            status: response.status,
                            ok: response.ok
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error: ${response.status}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        debug('Diagnosis data received', data);

                        if (data.success && data.data && data.data.length > 0) {
                            // Use the first diagnosis found for this visit
                            const diagnosis = data.data[0];
                            diagnosisId = diagnosis.diagnosis_ID;

                            // Update the textarea with the diagnosis note
                            diagnosisTextarea.value = diagnosis.note || '';
                            lastSavedContent = diagnosisTextarea.value;

                            // Hide status once loading is complete
                            updateSaveStatus('done');

                            debug('Diagnosis loaded successfully', {
                                diagnosis_ID: diagnosis.diagnosis_ID,
                                note_length: diagnosis.note ? diagnosis.note.length : 0
                            });
                        } else {
                            // No diagnosis found for this visit
                            diagnosisId = null;
                            diagnosisTextarea.value = '';
                            lastSavedContent = '';

                            // Hide status when done
                            updateSaveStatus('done');

                            debug('No diagnosis found for this visit');
                        }
                    })
                    .catch(error => {
                        debug('Error loading diagnosis', { error: error.message });
                        updateSaveStatus('error');
                    });
            }

            /**
             * Save diagnosis data
             */
            function saveDiagnosis() {
                if (!diagnosisTextarea || isSaving || !hasChanged()) {
                    return;
                }

                const currentContent = diagnosisTextarea.value;

                debug('Saving diagnosis', {
                    visitId,
                    diagnosisId,
                    contentLength: currentContent.length
                });

                isSaving = true;
                updateSaveStatus('saving');

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="_token"]')?.value || '';

                // Prepare diagnosis data
                const diagnosisData = {
                    visit_ID: visitId,
                    note: currentContent
                };

                // Determine if this is a create or update operation
                const url = diagnosisId ? `/diagnosis/${diagnosisId}` : '/diagnosis';
                const method = diagnosisId ? 'PUT' : 'POST';

                // Make the request
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(diagnosisData)
                })
                    .then(response => {
                        debug('Save response received', {
                            status: response.status,
                            ok: response.ok
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error: ${response.status}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        isSaving = false;

                        debug('Save response data', data);

                        if (data.success) {
                            diagnosisId = data.data.diagnosis_ID;
                            lastSavedContent = currentContent;
                            updateSaveStatus('saved'); // Will auto-hide after 1.5 seconds
                        } else {
                            updateSaveStatus('error');

                            // Schedule retry
                            setTimeout(() => {
                                if (hasChanged()) {
                                    saveDiagnosis();
                                }
                            }, 5000);
                        }
                    })
                    .catch(error => {
                        isSaving = false;
                        debug('Save request failed', { error: error.message });
                        updateSaveStatus('error');

                        // Schedule retry
                        setTimeout(() => {
                            if (hasChanged()) {
                                saveDiagnosis();
                            }
                        }, 5000);
                    });
            }

            /**
             * Check if the diagnosis tab is currently active/visible
             */
            function checkAndLoadDiagnosis() {
                const diagnosisTab = document.getElementById('allergies-content');
                const diagnosisTabButton = document.querySelector('[data-tab-target="allergies-content"]');

                debug('Checking if diagnosis tab is active', {
                    tabExists: !!diagnosisTab,
                    tabIsHidden: diagnosisTab ? diagnosisTab.classList.contains('hidden') : null,
                    tabHasActiveClass: diagnosisTab ? diagnosisTab.classList.contains('active') : null
                });

                // Different ways to check if the tab is active
                const isVisible = diagnosisTab && !diagnosisTab.classList.contains('hidden');
                const hasActiveClass = diagnosisTab && diagnosisTab.classList.contains('active');
                const tabButtonActive = diagnosisTabButton && diagnosisTabButton.classList.contains('active');

                if (isVisible || hasActiveClass || tabButtonActive) {
                    debug('Diagnosis tab appears to be active or visible');
                    loadDiagnosis();
                    return true;
                }

                debug('Diagnosis tab is not active');
                return false;
            }

            // Setup event listeners if textarea exists
            if (diagnosisTextarea) {
                // Auto-save on input with debounce
                diagnosisTextarea.addEventListener('input', function () {
                    updateSaveStatus('saving');

                    // Clear existing timeout
                    if (saveTimeout) {
                        clearTimeout(saveTimeout);
                    }

                    // Set new timeout
                    saveTimeout = setTimeout(function () {
                        saveDiagnosis();
                    }, 1000);
                });

                // Save on blur
                diagnosisTextarea.addEventListener('blur', function () {
                    if (saveTimeout) {
                        clearTimeout(saveTimeout);
                        saveTimeout = null;
                    }

                    if (hasChanged()) {
                        saveDiagnosis();
                    }
                });
            }

            // MULTIPLE TAB DETECTION APPROACHES

            // 1. Tab buttons with data-tab-target
            document.querySelectorAll('[data-tab-target]').forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-tab-target');
                    debug('Tab clicked via data-tab-target', { target });

                    if (target === 'allergies-content') {
                        // Force diagnosis load after tab switch
                        setTimeout(() => {
                            loadDiagnosis();
                        }, 100);
                    }
                });
            });

            // 2. MutationObserver for class changes
            const diagnosisTab = document.getElementById('allergies-content');
            if (diagnosisTab) {
                try {
                    const observer = new MutationObserver((mutations) => {
                        mutations.forEach((mutation) => {
                            if (mutation.attributeName === 'class') {
                                const isNowVisible = !diagnosisTab.classList.contains('hidden');
                                const wasHidden = mutation.oldValue && mutation.oldValue.includes('hidden');

                                if (isNowVisible && wasHidden) {
                                    debug('Diagnosis tab became visible (mutation observer)');
                                    loadDiagnosis();
                                }
                            }
                        });
                    });

                    observer.observe(diagnosisTab, {
                        attributes: true,
                        attributeFilter: ['class'],
                        attributeOldValue: true
                    });
                } catch (e) {
                    console.error('MutationObserver error:', e);
                }
            }

            // Try multiple approaches to ensure content loads

            // Approach 1: Immediate check
            checkAndLoadDiagnosis();

            // Approach 2: Short delay check (for async tab initialization)
            setTimeout(() => {
                if (!loadAttempted) {
                    debug('Checking tab status after short delay');
                    checkAndLoadDiagnosis();
                }
            }, 300);

            // Approach 3: Longer delay as fallback
            setTimeout(() => {
                if (!loadAttempted) {
                    debug('Fallback: Loading diagnosis data regardless of tab state');
                    loadDiagnosis();
                }
            }, 1000);

            // Add debug buttons only if in debug mode
            if (debugMode && debugOutput) {
                const testSaveBtn = document.createElement('button');
                testSaveBtn.textContent = 'Test Save';
                testSaveBtn.className = 'px-3 py-1 mt-2 bg-blue-500 text-white rounded';
                testSaveBtn.onclick = function () {
                    saveDiagnosis();
                };

                const testLoadBtn = document.createElement('button');
                testLoadBtn.textContent = 'Test Load';
                testLoadBtn.className = 'px-3 py-1 mt-2 ml-2 bg-green-500 text-white rounded';
                testLoadBtn.onclick = function () {
                    loadDiagnosis();
                };

                debugOutput.appendChild(testSaveBtn);
                debugOutput.appendChild(testLoadBtn);
            }

            // Initially hide the save status
            if (saveStatus) {
                saveStatus.classList.add('hidden');
            }

            console.log('Diagnosis auto-save script initialized');
        });
    </script>



    {{-- delete prescription --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete prescription buttons
            const deletePrescriptionBtns = document.querySelectorAll('.delete-prescription-btn');

            // Add click event listener to each delete button
            deletePrescriptionBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Get the parent form
                    const form = this.closest('.delete-prescription-form');

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Delete Prescription',
                        text: 'Are you sure you want to delete this prescription?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#F91D7C',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form using fetch API
                            const formData = new FormData(form);

                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            })
                                .then(response => response.json())
                                .then(data => {
                                    // Show success message
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Prescription has been deleted successfully.',
                                        icon: 'success',
                                        confirmButtonColor: '#F91D7C'
                                    }).then(() => {
                                        // Reload the page to refresh the list
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    // Show error message
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to delete prescription. Please try again.',
                                        icon: 'error',
                                        confirmButtonColor: '#F91D7C'
                                    });
                                    console.error('Error:', error);
                                });
                        }
                    });
                });
            });

            // Check for flash messages on page load (for regular form submissions)

            if (typeof successMessage !== 'undefined' && successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonColor: '#F91D7C'
                });
            }
        });
    </script>


    {{-- visit service --}}
    <script>
        // Visit Services Management JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Elements
            const availServiceModal = document.getElementById('availServiceModal');
            const modalOverlay = document.getElementById('modalOverlay');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const availServiceForm = document.getElementById('availServiceForm');
            const availServiceBtn = document.getElementById('availServiceBtn');

            // Open Modal Function
            function openModal() {
                // Get the visit ID from the page
                const visitId = getVisitIdFromPage();

                // Set the visit ID in the form
                document.getElementById('visit_ID').value = visitId;

                // Populate services dropdown from pre-loaded data
                populateServicesDropdown();

                // Show the modal
                availServiceModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent body scrolling
            }

            // Helper function to get the visit ID from the current page
            function getVisitIdFromPage() {
                // Try to get it from a data attribute on a common element
                const visitIdElement = document.querySelector('[data-visit-id]');
                if (visitIdElement && visitIdElement.dataset.visitId) {
                    return visitIdElement.dataset.visitId;
                }

                // Alternatively, extract from URL if following a pattern like /visits/{id}
                const urlParts = window.location.pathname.split('/');
                const visitIdIndex = urlParts.indexOf('visits') + 1;
                if (visitIdIndex > 0 && visitIdIndex < urlParts.length) {
                    return urlParts[visitIdIndex];
                }

                return '';
            }

            // Close Modal Function
            function closeModal() {
                availServiceModal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Restore body scrolling

                // Reset form
                if (availServiceForm) {
                    availServiceForm.reset();
                }
            }

            // Function to populate services dropdown from pre-loaded data
            function populateServicesDropdown() {
                // Get the select element
                const serviceSelect = document.getElementById('service_ID');

                // Clear existing options
                serviceSelect.innerHTML = '<option value="" disabled selected>Select Service</option>';

                try {
                    // Get services data from data attribute
                    const servicesDataElement = document.getElementById('services-data');
                    if (!servicesDataElement) {
                        throw new Error('Services data element not found');
                    }

                    const servicesData = JSON.parse(servicesDataElement.dataset.services || '[]');

                    if (!Array.isArray(servicesData) || servicesData.length === 0) {
                        throw new Error('No services data available');
                    }

                    // Add services to dropdown
                    servicesData.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.service_ID;

                        // Format price to 2 decimal places
                        const formattedPrice = parseFloat(service.price).toFixed(2);

                        // Create option text with service name and price
                        option.textContent = `${service.name} - ₱${formattedPrice}`;

                        // Add option to select element
                        serviceSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error loading services:', error);
                    serviceSelect.innerHTML = '<option value="" disabled selected>Error loading services</option>';

                    // Show error using SweetAlert if available, otherwise use alert
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load services. Please try again.',
                            confirmButtonColor: '#F91D7C'
                        });
                    } else {
                        alert('Failed to load services. Please try again.');
                    }
                }
            }

            // Event Listeners for opening modal
            if (availServiceBtn) {
                availServiceBtn.addEventListener('click', openModal);
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

            // Close modal on Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !availServiceModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Form submission handler
            if (availServiceForm) {
                availServiceForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validate form
                    if (!validateForm()) {
                        return;
                    }

                    // Get form data
                    const formData = new FormData(availServiceForm);

                    // Convert FormData to JSON object
                    const visitServiceData = {};
                    formData.forEach((value, key) => {
                        visitServiceData[key] = value;
                    });

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Show loading state
                    const submitBtn = availServiceForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.textContent;
                    submitBtn.textContent = 'Adding...';
                    submitBtn.disabled = true;

                    // Debug - log data before sending
                    console.log("Form data before sending:", visitServiceData);

                    // Send AJAX request using the existing controller with the correct route
                    fetch('/visit-services', {  // Corrected route path
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(visitServiceData)
                    })
                        .then(response => {
                            console.log("Response status:", response.status);
                            if (!response.ok) {
                                return response.json().then(data => {
                                    console.error("Error response:", data);
                                    throw new Error(data.message || 'Server error occurred');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Success response:", data);
                            if (data.success) {
                                // Show success message
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Service added successfully!',
                                        confirmButtonColor: '#F91D7C'
                                    }).then(() => {
                                        // Reload the page to refresh the services list
                                        window.location.reload();
                                    });
                                } else {
                                    alert('Service added successfully!');
                                    // Reload the page to refresh the services list
                                    window.location.reload();
                                }

                                // Close modal
                                closeModal();
                            } else {
                                // Show error message
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message || 'Failed to add service',
                                        confirmButtonColor: '#F91D7C'
                                    });
                                } else {
                                    alert(data.message || 'Failed to add service');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Show error message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'An error occurred while processing your request',
                                    confirmButtonColor: '#F91D7C'
                                });
                            } else {
                                alert(error.message || 'An error occurred while processing your request');
                            }
                        })
                        .finally(() => {
                            // Reset button state
                            submitBtn.textContent = originalBtnText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Form validation function
            function validateForm() {
                const serviceId = document.getElementById('service_ID').value;

                if (!serviceId) {
                    // Show validation error using SweetAlert if available, otherwise use alert
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please select a service',
                            confirmButtonColor: '#F91D7C'
                        });
                    } else {
                        alert('Please select a service');
                    }
                    return false;
                }

                return true;
            }

            // Define global functions for edit and delete operations
            window.openEditServiceModal = function (visitServiceId, serviceId, note) {
                // This function will be implemented later
                console.log(`Edit service: ${visitServiceId}, Service ID: ${serviceId}, Note: ${note}`);
                alert("Edit functionality will be implemented soon!");
            };

            window.confirmDeleteService = function (visitServiceId) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#F91D7C',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteVisitService(visitServiceId);
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this service?')) {
                        deleteVisitService(visitServiceId);
                    }
                }
            };


        });
    </script>

    {{-- delete service --}}
    <script>
        // SweetAlert confirmation for service deletion
        function confirmDeleteWithSweetAlert(buttonElement) {
            const form = buttonElement.closest('form');

            Swal.fire({
                title: 'Delete Service?',
                text: 'Are you sure you want to delete this service?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F91D7C',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    submitDeleteForm(form);
                }
            });
        }

        // Function to submit the delete form using AJAX
        function submitDeleteForm(form) {
            // Create a FormData object from the form
            const formData = new FormData(form);

            // Add method and CSRF token
            formData.append('_method', 'DELETE');

            // Create fetch options
            const options = {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };

            // Submit the form using fetch
            fetch(form.action, options)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The service has been deleted successfully.',
                            icon: 'success',
                            confirmButtonColor: '#F91D7C'
                        }).then(() => {
                            // Reload the page or update the UI
                            location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Something went wrong.',
                            icon: 'error',
                            confirmButtonColor: '#F91D7C'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong while deleting the service.',
                        icon: 'error',
                        confirmButtonColor: '#F91D7C'
                    });
                });
        }
    </script>


    {{-- visit product --}}
    <script>
        // Visit Products Management JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Visit products script loaded");

            // Modal Elements
            const addProductModal = document.getElementById('addProductModal');
            const modalOverlay = document.getElementById('modalOverlay');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const productForm = document.getElementById('productForm');
            const addProductBtn = document.getElementById('addProductBtn');

            // Open Modal Function
            function openModal() {
                // Get the visit ID from the page
                const visitId = getVisitIdFromPage();
                console.log("Opening modal with visit ID:", visitId);

                // Set the visit ID in the form
                if (document.getElementById('visit_ID')) {
                    document.getElementById('visit_ID').value = visitId;
                }

                // Populate products dropdown from pre-loaded data
                populateProductsDropdown();

                // Show the modal
                addProductModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent body scrolling
            }

            // Helper function to get the visit ID from the current page
            function getVisitIdFromPage() {
                // Try to get it from a data attribute on specific containers
                const medicalContent = document.getElementById('medical-content');
                if (medicalContent && medicalContent.dataset.visitId) {
                    console.log("Found visit ID from medical-content:", medicalContent.dataset.visitId);
                    return medicalContent.dataset.visitId;
                }

                const visitContent = document.getElementById('visit-content');
                if (visitContent && visitContent.dataset.visitId) {
                    console.log("Found visit ID from visit-content:", visitContent.dataset.visitId);
                    return visitContent.dataset.visitId;
                }

                // Try to get it from any element with data-visit-id
                const visitIdElement = document.querySelector('[data-visit-id]');
                if (visitIdElement && visitIdElement.dataset.visitId) {
                    console.log("Found visit ID from generic element:", visitIdElement.dataset.visitId);
                    return visitIdElement.dataset.visitId;
                }

                // Alternatively, extract from URL if following a pattern like /visits/{id}
                const urlParts = window.location.pathname.split('/');
                const visitIdIndex = urlParts.indexOf('visits') + 1;
                if (visitIdIndex > 0 && visitIdIndex < urlParts.length) {
                    console.log("Extracted visit ID from URL:", urlParts[visitIdIndex]);
                    return urlParts[visitIdIndex];
                }

                console.warn("Could not find visit ID");
                return '';
            }

            // Close Modal Function
            function closeModal() {
                addProductModal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Restore body scrolling

                // Reset form
                if (productForm) {
                    productForm.reset();

                    // Reset form title and button text if editing
                    const modalHeader = document.querySelector('#addProductModal h3');
                    if (modalHeader) {
                        modalHeader.innerHTML = '<span class="text-[#F91D7C]">Add</span> Product';
                    }

                    const submitButton = productForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.textContent = 'Add';
                    }
                }
            }

            // Function to populate products dropdown from pre-loaded data
            function populateProductsDropdown() {
                // Get the select element
                const productSelect = document.getElementById('product_ID');
                if (!productSelect) {
                    console.error("Product select element not found");
                    return;
                }

                // Clear existing options except the first one
                const firstOption = productSelect.querySelector('option[value=""]');
                productSelect.innerHTML = '';
                if (firstOption) {
                    productSelect.appendChild(firstOption);
                } else {
                    productSelect.innerHTML = '<option value="" disabled selected>Select Product</option>';
                }

                try {
                    // Get products data from data attribute
                    const productsDataElement = document.getElementById('products-data');
                    if (!productsDataElement) {
                        console.warn('Products data element not found');
                        return;
                    }

                    const productsData = JSON.parse(productsDataElement.dataset.products || '[]');
                    console.log("Products data loaded:", productsData.length, "products");

                    if (!Array.isArray(productsData) || productsData.length === 0) {
                        console.warn('No products data available');
                        return;
                    }

                    // Add products to dropdown
                    productsData.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.product_ID;

                        // Format price to 2 decimal places
                        const formattedPrice = parseFloat(product.price).toFixed(2);

                        // Create option text with product name and price
                        option.textContent = `${product.name} - ₱${formattedPrice}`;

                        // Add option to select element
                        productSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error loading products:', error);
                    productSelect.innerHTML = '<option value="" disabled selected>Error loading products</option>';

                    // Show error using SweetAlert if available, otherwise use alert
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load products. Please try again.',
                            confirmButtonColor: '#F91D7C'
                        });
                    } else {
                        alert('Failed to load products. Please try again.');
                    }
                }
            }

            // Event Listeners for opening modal
            if (addProductBtn) {
                console.log("Found addProductBtn, adding click listener");
                addProductBtn.addEventListener('click', openModal);
            } else {
                console.warn("addProductBtn not found");
            }

            // Make the openModal function available globally to be called from other places
            window.openAddProductModal = function (visitId, isEdit = false) {
                console.log("Global openAddProductModal called with visitId:", visitId, "isEdit:", isEdit);

                if (visitId) {
                    const visitIdInput = document.getElementById('visit_ID');
                    if (visitIdInput) {
                        visitIdInput.value = visitId;
                        console.log("Set visit_ID input value to:", visitId);
                    }
                }

                if (!isEdit) {
                    // Reset the form for adding a new product
                    if (productForm) {
                        productForm.reset();

                        // Reset the form title
                        const modalHeader = document.querySelector('#addProductModal h3');
                        if (modalHeader) {
                            modalHeader.innerHTML = '<span class="text-[#F91D7C]">Add</span> Product';
                        }

                        // Reset the submit button
                        const submitButton = productForm.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.textContent = 'Add';
                        }
                    }
                }

                // Populate products dropdown
                populateProductsDropdown();

                // Show the modal
                if (addProductModal) {
                    addProductModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            };

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

            // Close modal on Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !addProductModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Form Validation Function
            function validateForm() {
                const productId = document.getElementById('product_ID').value;

                if (!productId) {
                    // Show validation error using SweetAlert if available, otherwise use alert
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please select a product',
                            confirmButtonColor: '#F91D7C'
                        });
                    } else {
                        alert('Please select a product');
                    }
                    return false;
                }

                return true;
            }

            // Form submission handler
            if (productForm) {
                productForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validate form
                    if (!validateForm()) {
                        return;
                    }

                    // Get form data
                    const formData = new FormData(productForm);

                    // Convert FormData to JSON object
                    const visitProductData = {};
                    formData.forEach((value, key) => {
                        visitProductData[key] = value;
                    });

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Show loading state
                    const submitBtn = productForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.textContent;
                    // submitBtn.textContent = 'Adding...';
                    submitBtn.disabled = true;

                    // Debug - log data before sending
                    console.log("Form data before sending:", visitProductData);

                    // Determine if this is an edit or add operation
                    const isEdit = productForm.dataset.productId ? true : false;
                    const url = isEdit
                        ? `/visit-products/${productForm.dataset.productId}`
                        : '/visit-products';
                    const method = isEdit ? 'PUT' : 'POST';

                    // Send AJAX request
                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(visitProductData)
                    })
                        .then(response => {
                            console.log("Response status:", response.status);
                            if (!response.ok) {
                                return response.json().then(data => {
                                    console.error("Error response:", data);
                                    throw new Error(data.message || 'Server error occurred');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Success response:", data);
                            if (data.success) {
                                // Show success message
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: isEdit ? 'Product updated successfully!' : 'Product added successfully!',
                                        confirmButtonColor: '#F91D7C'
                                    }).then(() => {
                                        // Reload the page to refresh the products list
                                        window.location.reload();
                                    });
                                } else {
                                    alert(isEdit ? 'Product updated successfully!' : 'Product added successfully!');
                                    // Reload the page to refresh the products list
                                    window.location.reload();
                                }

                                // Close modal
                                closeModal();
                            } else {
                                // Show error message
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message || (isEdit ? 'Failed to update product' : 'Failed to add product'),
                                        confirmButtonColor: '#F91D7C'
                                    });
                                } else {
                                    alert(data.message || (isEdit ? 'Failed to update product' : 'Failed to add product'));
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Show error message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'An error occurred while processing your request',
                                    confirmButtonColor: '#F91D7C'
                                });
                            } else {
                                alert(error.message || 'An error occurred while processing your request');
                            }
                        })
                        .finally(() => {
                            // Reset button state
                            submitBtn.textContent = originalBtnText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Initialize edit product functionality
            initializeEditProductButtons();



            /**
             * Initialize edit buttons for products
             */
            function initializeEditProductButtons() {
                const editButtons = document.querySelectorAll('.edit-product-btn');
                console.log("Found edit buttons:", editButtons.length);

                editButtons.forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        const productId = this.dataset.id;
                        console.log("Edit button clicked for product ID:", productId);

                        // Fetch product details for editing
                        fetch(`/visit-products/${productId}/edit`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log("Product data received:", data.data);
                                    populateEditForm(data.data);
                                } else {
                                    showError(data.message || 'Failed to load product details');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showError('An error occurred while retrieving product details');
                            });
                    });
                });
            }


            /**
             * Populate the edit form with product data
             */
            function populateEditForm(visitProduct) {
                console.log("Populating edit form with product data:", visitProduct);

                // Check if form exists
                if (!productForm) {
                    console.error("Product form not found");
                    return;
                }

                // Set form values
                document.getElementById('visit_ID').value = visitProduct.visit_ID;
                console.log("Set visit_ID to:", visitProduct.visit_ID);

                // Store the product ID for update
                productForm.dataset.productId = visitProduct.visit_products_ID;
                console.log("Set form product ID to:", visitProduct.visit_products_ID);

                // Update the form title to indicate editing
                const modalHeader = document.querySelector('#addProductModal h3');
                if (modalHeader) {
                    modalHeader.innerHTML = '<span class="text-[#F91D7C]">Edit</span> Product';
                }

                // Populate products dropdown first
                populateProductsDropdown();

                // Set product selection after dropdown is populated
                setTimeout(() => {
                    const productSelect = document.getElementById('product_ID');
                    if (productSelect && visitProduct.product_ID) {
                        const options = Array.from(productSelect.options);
                        const foundOption = options.find(option => option.value == visitProduct.product_ID);
                        if (foundOption) {
                            foundOption.selected = true;
                            console.log("Selected existing option:", foundOption.textContent);
                        } else {
                            // If product option doesn't exist in dropdown, create a temporary option
                            const newOption = document.createElement('option');
                            newOption.value = visitProduct.product_ID;
                            newOption.textContent = visitProduct.product.name + ' - ₱' + parseFloat(visitProduct.product.price).toFixed(2);
                            newOption.selected = true;
                            productSelect.appendChild(newOption);
                            console.log("Created and selected new option:", newOption.textContent);
                        }
                    }

                    // Set quantity if it exists
                    const quantityInput = document.getElementById('quantity');
                    if (quantityInput) {
                        quantityInput.value = visitProduct.quantity || 1;
                        console.log("Set quantity to:", quantityInput.value);
                    }

                    // Set note
                    const noteInput = document.getElementById('note');
                    if (noteInput) {
                        noteInput.value = visitProduct.note || '';
                        console.log("Set note to:", noteInput.value);
                    }

                    // Change submit button text
                    const submitButton = productForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.textContent = 'Update';
                    }
                }, 100);

                // Show the modal
                addProductModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }




            // delete

            // Find all delete product forms
            const deleteForms = document.querySelectorAll('.delete-product-form');

            // Add submit event listener to each form
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    // Create FormData object from the form
                    const formData = new FormData(this);

                    // Send form using fetch
                    fetch(this.action, {
                        method: 'POST', // Always POST because method spoofing is handled by Laravel
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Add this for better Laravel compatibility
                        }
                    })
                        .then(response => {
                            // Log the raw response for debugging
                            console.log("Response status:", response.status);
                            console.log("Response headers:", [...response.headers.entries()]);

                            // Check if the response can be parsed as JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json().then(data => {
                                    // Even if response.ok is false, we return the parsed data
                                    // to handle it in the next .then block
                                    return {
                                        ok: response.ok,
                                        status: response.status,
                                        data: data
                                    };
                                });
                            } else {
                                // For non-JSON responses
                                return response.text().then(text => {
                                    return {
                                        ok: response.ok,
                                        status: response.status,
                                        text: text
                                    };
                                });
                            }
                        })
                        .then(result => {
                            // Log the processed result for debugging
                            console.log("Processed result:", result);

                            // Handle success even if the response doesn't have a success property
                            // Some Laravel responses may just return a 200 OK without a specific success flag
                            if (result.ok || (result.data && result.data.success)) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Product deleted successfully!',
                                        confirmButtonColor: '#F91D7C'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    alert('Product deleted successfully!');
                                    window.location.reload();
                                }
                            } else {
                                // Handle error responses
                                const errorMessage = result.data && result.data.message
                                    ? result.data.message
                                    : 'Failed to delete product';

                                console.error('Error response:', result);
                                showError(errorMessage);
                            }
                        })
                        .catch(error => {
                            console.error('Network or parsing error:', error);
                            showError('An error occurred while deleting the product');
                        });
                });
            });

            // Make sure the showError function exists
            function showError(message) {
                console.error("Error message:", message);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                        confirmButtonColor: '#F91D7C'
                    });
                } else {
                    alert(message);
                }
            }

            // Add click event listener to each button to trigger form submission
            document.querySelectorAll('.delete-product-btn').forEach(button => {
                button.addEventListener('click', function () {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#F91D7C',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('.delete-product-form').dispatchEvent(new Event('submit'));
                            }
                        });
                    } else {
                        if (confirm('Are you sure you want to delete this product?')) {
                            this.closest('.delete-product-form').dispatchEvent(new Event('submit'));
                        }
                    }
                });
            });

            /**
             * Show error message
             */
            function showError(message) {
                console.error("Error:", message);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                        confirmButtonColor: '#F91D7C'
                    });
                } else {
                    alert(message);
                }
            }

        });
    </script>












    @include('patients record/modal/add modal/add_services')
    @include('patients record/modal/add modal/add_product')
    @include('patients record/modal/add modal/add_prescription')


    @include('patients record/modal/edit modal/edit_service')
    {{-- @include('patients record/modal/edit modal/edit_product') --}}
    @include('patients record/modal/edit modal/edit_prescription')


    @include('patients record/modal/view modal/view_service')
    @include('patients record/modal/view modal/view_product')
    @include('patients record/modal/view modal/view_prescription')