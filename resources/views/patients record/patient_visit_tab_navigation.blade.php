

<div id="patient-tabs">
    {{-- Tabs Navigation --}}
    <!-- Responsive Tabs with Carousel for Small Devices -->
    <div class="border-b border-gray-200">
        <div class="relative">
            <!-- Tabs Container with Horizontal Scroll -->
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

            <!-- Left Arrow (hidden by default, shown when scrollable) -->
            <button id="scroll-left"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow (hidden by default, shown when scrollable) -->
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



        {{-- Visit Services Content --}}
        <div id="visit-content" class="tab-content">
            <div class="flex justify-end mb-4">
                <button id="availServiceBtn" class="text-[#F91D7C] z-10 flex items-center gap-2"
                    onclick="openAddServiceModal()">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Service">
                </button>
            </div>


              @php
                // Get services dynamically from the visit model
                $visitServices = $visit->services ?? [];
            @endphp

            <!-- Desktop View -->
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
                            <tr class="view-service-btn border-b border-gray-200 hover:bg-[#F91D7C]/5"
                                data-id="{{ $visitService->visit_services_ID }}">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $visitService->service->name ?? 'Unknown Service' }}</span>
                                    @if($visitService->note)
                                        <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitService->note }}</p>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="edit-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitService->visit_services_ID }}"
                                            data-service-id="{{ $visitService->service_ID }}"
                                            data-note="{{ $visitService->note ?? '' }}"
                                            onclick="openEditServiceModal({{ $visitService->visit_services_ID }}, {{ $visitService->service_ID }}, '{{ addslashes($visitService->note ?? '') }}')">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
                                        <button
                                            class="delete-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitService->visit_services_ID }}"
                                            onclick="confirmDeleteService({{ $visitService->visit_services_ID }})">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
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

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse ($visitServices as $index => $visitService)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-normal">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    {{ $visitService->service->name ?? 'Unknown Service' }}
                                </p>
                                @if($visitService->note)
                                    <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitService->note }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="edit-service-btn w-6 h-6" data-id="{{ $visitService->visit_services_ID }}"
                                    data-service-id="{{ $visitService->service_ID }}"
                                    data-note="{{ $visitService->note ?? '' }}"
                                    onclick="openEditServiceModal({{ $visitService->visit_services_ID }}, {{ $visitService->service_ID }}, '{{ addslashes($visitService->note ?? '') }}')">
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
                        No services added to this visit yet. Click the button above to add a service.
                    </div>
                @endforelse
            </div>
        </div>




        {{-- Visit Product Content --}}

        <div id="medical-content" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <button id="addProductBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Product">
                </button>
            </div>

            @php
                // Get products dynamically from the visit model
                $visitProducts = $visit->products ?? [];
            @endphp

            <!-- Desktop View -->
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
                            <tr class="view-product-btn border-b border-gray-200 hover:bg-[#F91D7C]/5"
                                data-id="{{ $visitProduct->visit_products_ID }}">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $visitProduct->product->name ?? 'Unknown Product' }}</span>
                                    @if($visitProduct->note)
                                        <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitProduct->note }}</p>
                                    @endif
                                    @if($visitProduct->quantity)
                                        <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5 ml-2">
                                            Qty: {{ $visitProduct->quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitProduct->visit_products_ID }}">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
                                        <button
                                            class="delete-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $visitProduct->visit_products_ID }}">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
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

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse ($visitProducts as $index => $visitProduct)
                    <div class="view-product-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        data-id="{{ $visitProduct->visit_products_ID }}">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $visitProduct->product->name ?? 'Unknown Product' }}</span>
                                @if($visitProduct->quantity)
                                    <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5 ml-2">
                                        Qty: {{ $visitProduct->quantity }}
                                    </span>
                                @endif
                                @if($visitProduct->note)
                                    <p class="text-xs text-gray-500 mt-1 ml-6">Note: {{ $visitProduct->note }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $visitProduct->visit_products_ID }}">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
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





        {{-- Prescription Content  --}}
        <div id="medications-content" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <button id="addPrescriptionBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Prescription">
                </button>
            </div>

            <!-- Desktop View -->
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
                                        <!-- edit button -->
                                        <button
                                            class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            data-id="{{ $prescription->prescription_ID }}">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
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

            <!-- Mobile View -->
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
                                <!-- edit button -->
                                <button
                                    class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                    data-id="{{ $prescription->prescription_ID }}">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
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


    <!-- JavaScript to handle horizontal scrolling and show/hide arrows -->
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




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete prescription buttons
            const deletePrescriptionBtns = document.querySelectorAll('.delete -prescription - btn');

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








    @include('patients record/modal/add modal/add_services')
    @include('patients record/modal/add modal/add_product')
    @include('patients record/modal/add modal/add_prescription')


    @include('patients record/modal/edit modal/edit_service')
    @include('patients record/modal/edit modal/edit_product')
    @include('patients record/modal/edit modal/edit_prescription')


    @include('patients record/modal/view modal/view_service')
    @include('patients record/modal/view modal/view_product')
    @include('patients record/modal/view modal/view_prescription')