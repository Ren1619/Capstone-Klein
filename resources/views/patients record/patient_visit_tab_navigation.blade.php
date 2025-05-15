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




        {{-- Services Content --}}
        <div id="visit-content" class="tab-content">

            <div class="flex justify-end mb-4">
                <button id="availServiceBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Appointment">
                </button>
            </div>
            @php
                $services = [
                    ['name' => 'Dandruff and Scalp Treatment'],
                    ['name' => 'Wart and Skin Tag Removal'],
                    ['name' => 'Acne Treatment']
                ];
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
                        @foreach ($services as $index => $service)
                            <tr class="view-service-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $service['name'] }}</span>

                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="edit-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">

                @foreach ($services as $index => $service)
                    <div class="view-service-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $service['name'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="edit-service-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>



        {{-- Products Content --}}
        <div id="medical-content" class="tab-content hidden">

            <div class="flex justify-end mb-4">
                <button id="addProductBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Appointment">
                </button>
            </div>
            @php
                $products = [
                    ['name' => 'CeraVe Foaming Cleanser Normal to Oily Skin'],
                    ['name' => 'Paula\'s Choice C5 Super Boost Moisturizer 15ml / 50ml'],
                    ['name' => 'Collagen Tone-Up Booster Cream']
                ];
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
                        @foreach ($products as $index => $product)
                            <tr class="view-product-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $product['name'] }}</span>

                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">


                @foreach ($products as $index => $product)
                    <div class="view-product-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $product['name'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="edit-product-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
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
            </div>
        </div>




        {{-- Prescription Content --}}
        <div id="medications-content" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <button id="addPrescriptionBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Appointment">
                </button>
            </div>
            @php
                $prescriptions = [
                    ['name' => 'Lisinopril'],
                    ['name' => 'Metformin'],
                    ['name' => 'Albuterol']
                ];
            @endphp

            <!-- Desktop View -->
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>

                        <tr class="border-b border-gray-200 ">
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
                        @foreach ($prescriptions as $index => $prescription)
                            <tr class="view-prescription-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $prescription['name'] }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">

                @foreach ($prescriptions as $index => $prescription)
                    <div class="view-prescription-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $prescription['name'] }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="edit-prescription-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
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

    <!-- CSS to hide scrollbar but keep functionality -->
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }
    </style>


    @include('patients record/modal/add modal/add_services')
    @include('patients record/modal/add modal/add_product')
    @include('patients record/modal/add modal/add_prescription')


    @include('patients record/modal/edit modal/edit_service')
    @include('patients record/modal/edit modal/edit_product')
    @include('patients record/modal/edit modal/edit_prescription')


    @include('patients record/modal/view modal/view_service')
    @include('patients record/modal/view modal/view_product')
    @include('patients record/modal/view modal/view_prescription')