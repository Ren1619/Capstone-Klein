<!-- <div id="patient-tabs">
    {{-- Tabs Navigation --}}
    {{-- Responsive Tabs Navigation --}}
     
    <div class="border-b border-gray-200">
        <div class="relative">
            {{--Tabs Container with Horizontal Scroll --}}
            <div class="flex px-1 sm:px-2 overflow-x-auto scrollbar-hide" id="tabs-carousel">
                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer tab-btn active flex-shrink-0"
                    data-tab="visit">
                    <button class="text-xs sm:text-sm text-[#F91D7C] whitespace-nowrap">Visit History</button>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                </div>

                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medical">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Medical Condition</button>
                </div>

                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="allergies">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Allergies</button>
                </div>

                <div class="relative px-2 sm:px-4 py-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medications">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Medications</button>
                </div>
            </div>

            {{-- Left Arrow (hidden by default, shown when scrollable) --}}
            <button id="scroll-left"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Right Arrow (hidden by default, shown when scrollable) --}}
            <button id="scroll-right"
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>




    {{-- Tab Content --}}
    <div class="p-5">

        {{-- Visit History Content --}}
        <div id="visit-content" class="tab-content">

            <div id="newVisitBtn" class="flex justify-end mb-4 relative group">
                <button id="newVisitBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Visit">
                </button>
                {{-- Tooltip --}}
                <span
                    class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute bottom-full right-0 mb-2 px-3 py-1 bg-black/70 text-white text-sm rounded whitespace-nowrap">
                    Add Visit
                </span>
            </div>
            {{-- Desktop View--}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>


                        <tr class="border-b border-gray-200">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Date
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins"
                                    onclick="window.location.href='{{ url('/patientsVisits') }}';" style="cursor: pointer;">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $i + 1 }}.</span>March
                                    25, 2025
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden">
                {{-- <div id="newVisitBtn" class="flex justify-end mb-4">
                    <button id="newVisitBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Visit">
                    </button>

                </div> --}}
                @for ($i = 0; $i < 9; $i++)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        onclick="window.location.href='{{ url('/patientsVisits') }}';" style="cursor: pointer;">
                        <div class="flex justify-between items-center ">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $i + 1 }}.</span>March 25,
                                2025
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>


        {{-- Medical Conditions Content --}}
        <div id="medical-content" class="tab-content hidden">
        {{-- id="medicalConditionBtn"  --}}
            <div class="flex justify-end mb-4">
                <button id="medicalConditionBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medical Condition">
                </button>
            </div>
            @php
                $conditions = [
                    ['name' => 'Hypertension'],
                    ['name' => 'Type 2 Diabetes'],
                    ['name' => 'Asthma']
                ];
            @endphp

            {{-- Desktop View --}}
            <div class="hidden md:block">

                <table class="w-full min-w-full table-auto">
                    <thead>

                        <tr class="border-b border-gray-200">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Condition
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($conditions as $index => $condition)
                            <tr class="view-medical-condition-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $condition['name'] }}</span>

                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        {{-- id="editMedicalConditionBtn"  --}}
                                        <button class=" edit-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}
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

            {{-- Mobile View --}}
            <div class="md:hidden">
                @foreach ($conditions as $index => $condition)
                    <div class="view-medical-condition-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $condition['name'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button class="edit-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- Allergies Content --}}
        <div id="allergies-content" class="tab-content hidden">

            <div class="flex justify-end mb-4">
                <button id="addAllergiesBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Allergies">
                </button>
            </div>
            @php
                $allergies = [
                    ['allergen' => 'Penicillin'],
                    ['allergen' => 'Peanuts'],
                    ['allergen' => 'Latex']
                ];
            @endphp

            {{-- Desktop View --}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>

                        <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Allergies
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allergies as $index => $allergy)
                            <tr class="view-allergy-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $allergy['allergen'] }}</span>

                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button class="edit-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}
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

            {{-- Mobile View --}}
            <div class="md:hidden">
                {{-- <div id="addAllergiesBtn" class="flex justify-end mb-4">
                    <button id="addAllergiesBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Allergies">
                    </button>
                </div> --}}
                @foreach ($allergies as $index => $allergy)
                    <div class="view-allergy-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $allergy['allergen'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button class="edit-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- Medications Content --}}
        <div id="medications-content" class="tab-content hidden">

            <div class="flex justify-end mb-4">
                <button id="addMedicationBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medication">
                </button>
            </div>
            @php
                $medications = [
                    ['name' => 'Lisinopril'],
                    ['name' => 'Metformin'],
                    ['name' => 'Albuterol']
                ];
            @endphp

            {{-- Desktop View --}}
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto">
                    <thead>

                        <tr class="border-b border-gray-200 ">
                            <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 85%;">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Medications
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medications as $index => $medication)
                            <tr class="view-medication-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $medication['name'] }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        {{-- edit button --}}
                                        <button class="edit-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        {{-- delete button --}}
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

            {{-- Mobile View --}}
            <div class="md:hidden">
                {{-- <div id="addMedicationBtn" class="flex justify-end mb-4">
                    <button id="addMedicationBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medication">
                    </button>
                </div> --}}
                @foreach ($medications as $index => $medication)
                    <div class="view-medication-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $medication['name'] }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- edit button --}}
                                <button class="edit-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                {{-- delete button --}}
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
                    // Content is wider than container, show right arrow initially
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

    {{-- CSS to hide scrollbar but keep functionality --}}
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
    </style> -->







<div id="patient-tabs">
    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-200">
        <div class="relative">
            <!-- Tabs Container with Horizontal Scroll -->
            <div class="flex px-1 sm:px-2 overflow-x-auto scrollbar-hide" id="tabs-carousel">
                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer tab-btn active flex-shrink-0"
                    data-tab="visit">
                    <button class="text-xs sm:text-sm text-[#F91D7C] whitespace-nowrap">Visit History</button>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                </div>

                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medical">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Medical Condition</button>
                </div>

                <div class="relative px-2 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="allergies">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Allergies</button>
                </div>

                <div class="relative px-2 sm:px-4 py-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                    data-tab="medications">
                    <button class="text-xs sm:text-sm whitespace-nowrap">Medications</button>
                </div>
            </div>

            <!-- Left Arrow (hidden by default, shown when scrollable) -->
            <button id="scroll-left"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow (hidden by default, shown when scrollable) -->
            <button id="scroll-right"
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="p-5">
        {{-- Visit History Content with Pagination --}}
        <div id="visit-content" class="tab-content">
            <div class="flex justify-end mb-4 relative group">
                <button id="newVisitBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Visit">
                </button>
                <!-- Tooltip -->
                <span
                    class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute bottom-full right-0 mb-2 px-3 py-1 bg-black/70 text-white text-sm rounded whitespace-nowrap">
                    Add Visit
                </span>
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block">
                <table class="w-full min-w-full table-auto visits-table">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th
                                class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                Date
                            </th>
                            <th
                                class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins">
                                Height
                            </th>
                            <th
                                class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins">
                                Weight
                            </th>
                            <th
                                class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins">
                                BP
                            </th>
                            <th
                                class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->visitHistory ?? [] as $index => $visit)
                            <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins" data-visit-id="{{ $visit->visit_ID }}"
                                    onclick="window.location.href='{{ route('visits.show', $visit->visit_ID) }}';"
                                    style="cursor: pointer;">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    {{ \Carbon\Carbon::parse($visit->timestamp)->format('F d, Y') }}
                                </td>
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    {{ $visit->height }}
                                </td>
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    {{ $visit->weight }}
                                </td>
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    {{ $visit->blood_pressure }}
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button class="edit-visit-btn" data-visit-id="{{ $visit->visit_ID }}"
                                            onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>

                                        <!-- delete button -->
                                        <form class="delete-visit-form"
                                            action="{{ route('visits.destroy', $visit->visit_ID) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-visit-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">No visit records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden visits-mobile">
                @forelse($patient->visitHistory ?? [] as $index => $visit)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        onclick="window.location.href='{{ route('visits.show', $visit->visit_ID) }}';"
                        style="cursor: pointer;">
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    {{ \Carbon\Carbon::parse($visit->timestamp)->format('F d, Y') }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <!-- edit button -->
                                    <button
                                        class="edit-visit-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                        data-visit-id="{{ $visit->visit_ID }}" data-timestamp="{{ $visit->timestamp }}"
                                        data-weight="{{ $visit->weight }}" data-height="{{ $visit->height }}"
                                        data-blood-pressure="{{ $visit->blood_pressure }}">
                                        <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                    </button>

                                    <!-- delete button -->
                                    <form class="delete-visit-form" action="{{ route('visits.destroy', $visit->visit_ID) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-visit-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-xs text-gray-600 mt-1">
                                <div>
                                    <span class="font-medium">Height:</span> {{ $visit->height }}
                                </div>
                                <div>
                                    <span class="font-medium">Weight:</span> {{ $visit->weight }}
                                </div>
                                <div>
                                    <span class="font-medium">BP:</span> {{ $visit->blood_pressure }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">No visit records found.</div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($visits) && $visits->total() > $visits->perPage())
                <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center mt-4">
                    <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                        Showing {{ $visits->firstItem() ?? 0 }} to {{ $visits->lastItem() ?? 0 }} of
                        {{ $visits->total() }} results
                    </div>
                    <div class="flex space-x-1">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            <!-- Previous Page Link -->
                            @if($visits->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $visits->previousPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
                                    rel="prev"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Previous
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @for ($i = 1; $i <= $visits->lastPage(); $i++)
                                @if ($i == $visits->currentPage())
                                    <span aria-current="page"
                                        class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-white bg-[#F91D7C] border border-[#F91D7C] cursor-default leading-5 rounded-md">
                                        {{ $i }}
                                    </span>
                                @else
                                    <a href="{{ $visits->url($i) }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
                                        class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            <!-- Next Page Link -->
                            @if($visits->hasMorePages())
                                <a href="{{ $visits->nextPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
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


        {{-- Medical Conditions Content --}}
        <div id="medical-content" class="tab-content hidden">
            <div class="flex justify-end mb-4">
                <button id="medicalConditionBtn" class="open-condition-modal text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medical Condition">
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
                                Condition
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->medicalConditions ?? [] as $index => $condition)
                            <tr class="view-medical-condition-btn border-b border-gray-200 hover:bg-[#F91D7C]/5"
                                data-condition-id="{{ $condition->medical_ID }}">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $condition->condition }}</span>
                                </td>
                                <td class="py-3">


                                    <div class="flex justify-end items-center gap-3.5 z-[100]">
                                        <!-- edit button -->
                                        <button
                                            class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-medical-condition-btn"
                                            data-condition-id="{{ $condition->medical_ID }}"
                                            onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                        </button>

                                        <!-- delete button -->
                                        <form class="delete-medical-condition-form"
                                            action="{{ route('conditions.destroy', $condition->medical_ID) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">No medical conditions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse($patient->medicalConditions ?? [] as $index => $condition)
                    <div class="view-medical-condition-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        data-condition-id="{{ $condition->medical_ID }}">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $condition->condition }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-medical-condition-btn"
                                    data-condition-id="{{ $condition->medical_ID }}" onclick="event.stopPropagation();">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                </button>

                                <!-- delete button -->
                                <form class="delete-medical-condition-form"
                                    action="{{ route('conditions.destroy', $condition->medical_ID) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">No medical conditions found.</div>
                @endforelse
            </div>
        </div>




        {{-- Allergies Content --}}
        <div id="allergies-content" class="tab-content hidden">

            <div class="flex justify-end mb-4">
                <button id="addAllergiesBtn" class="text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Allergies">
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
                                Allergies
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($patient->allergies) && $patient->allergies->count() > 0)
                            @foreach($patient->allergies as $index => $allergy)
                                <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5" data-allergy-id="{{ $allergy->id }}"
                                    onclick="openViewAllergyModal('{{ $allergy->id }}')">
                                    <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                        <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                        <span class="font-normal">{{ $allergy->allergies }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-end items-center gap-3.5">
                                            <!-- edit button -->
                                            <button
                                                class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-allergy-btn"
                                                data-allergy-id="{{ $allergy->allergy_ID }}" onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                            </button>
                                            <!-- delete button -->
                                            <form class="delete-allergy-form"
                                                action="{{ route('allergies.destroy', $allergy->allergy_ID) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="delete-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                                    onclick="event.stopPropagation();">
                                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">No allergies found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                @if(isset($patient->allergies) && $patient->allergies->count() > 0)
                    @foreach($patient->allergies as $index => $allergy)
                        <div class="view-allergy-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                            data-allergy-id="{{ $allergy->allergy_ID }}" onclick="openViewAllergyModal('{{ $allergy->allergy_ID }}')">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $allergy->allergies }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- edit button -->
                                    <button
                                        class="edit-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                        data-allergy-id="{{ $allergy->id }}" onclick="event.stopPropagation();">
                                        <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                    </button>
                                    <!-- delete button -->
                                    <form class="delete-allergy-form"
                                        action="{{ route('allergies.destroy', $allergy->allergy_ID) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                            onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="py-4 text-center text-gray-500">No allergies found.</div>
                @endif
            </div>
        </div>







        {{-- Medications Content --}}
        <div id="medications-content" class="tab-content hidden">

            <div class="flex justify-end mb-4">
                <button id="addMedicationBtn" class="open-medication-modal text-[#F91D7C] z-10 flex items-center">
                    <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medication">
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
                                Medications
                            </th>
                            <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap"
                                style="width: 15%;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->medications ?? [] as $index => $medication)
                            <tr class="view-medication-btn border-b border-gray-200 hover:bg-[#F91D7C]/5"
                                data-medication-id="{{ $medication->medication_ID }}"
                                onclick="openViewMedicationModal('{{ $medication->medication_ID }}')">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $medication->medication }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <button
                                            class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-medication-btn"
                                            data-medication-id="{{ $medication->medication_ID }}"
                                            onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                        </button>
                                        <!-- delete button -->
                                        <form class="delete-medication-form"
                                            action="{{ route('medications.destroy', $medication->medication_ID) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                                onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">No medications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse($patient->medications ?? [] as $index => $medication)
                    <div class="view-medication-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        data-medication-id="{{ $medication->id }}">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $medication->medication }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button
                                    class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-medication-btn"
                                    data-medication-id="{{ $medication->medication_ID }}"
                                    onclick="event.stopPropagation();">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                </button>


                                <!-- delete button -->
                                <form class="delete-medication-form"
                                    action="{{ route('medications.destroy', $medication->medication_ID) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"
                                        onclick="event.stopPropagation();">
                                        <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">No medications found.</div>
                @endforelse
            </div>
        </div>







        <script>


            document.addEventListener('DOMContentLoaded', function () {
                initTabs();
                initTabsScrolling();
                setupModalTriggers();
                setupModalCloseButtons();
                initFormHandlers();
            });



            // Tab functionality
            function initTabs() {
                const tabBtns = document.querySelectorAll('.tab-btn');
                const tabContents = document.querySelectorAll('.tab-content');

                tabBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // Reset all tabs
                        tabBtns.forEach(b => {
                            b.classList.remove('active');
                            const button = b.querySelector('button');
                            if (button) button.classList.remove('text-[#F91D7C]');
                            const underline = b.querySelector('div.absolute');
                            if (underline) underline.remove();
                        });

                        // Activate clicked tab
                        btn.classList.add('active');
                        const button = btn.querySelector('button');
                        if (button) button.classList.add('text-[#F91D7C]');

                        // Add underline
                        const underline = document.createElement('div');
                        underline.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                        btn.appendChild(underline);

                        // Show correct content
                        tabContents.forEach(content => content.classList.add('hidden'));
                        const tabId = btn.getAttribute('data-tab');
                        const selectedTab = document.getElementById(`${tabId}-content`);
                        if (selectedTab) selectedTab.classList.remove('hidden');
                    });
                });
            }

            // Tab scrolling arrows
            function initTabsScrolling() {
                const tabsContainer = document.getElementById('tabs-carousel');
                const scrollLeftBtn = document.getElementById('scroll-left');
                const scrollRightBtn = document.getElementById('scroll-right');

                if (!tabsContainer || !scrollLeftBtn || !scrollRightBtn) return;

                function checkScroll() {
                    const hasOverflow = tabsContainer.scrollWidth > tabsContainer.clientWidth;
                    const atStart = tabsContainer.scrollLeft <= 0;
                    const atEnd = tabsContainer.scrollLeft + tabsContainer.clientWidth >= tabsContainer.scrollWidth - 5;

                    scrollLeftBtn.classList.toggle('hidden', atStart || !hasOverflow);
                    scrollRightBtn.classList.toggle('hidden', atEnd || !hasOverflow);
                }

                scrollLeftBtn.addEventListener('click', () => {
                    tabsContainer.scrollBy({ left: -100, behavior: 'smooth' });
                    setTimeout(checkScroll, 300);
                });

                scrollRightBtn.addEventListener('click', () => {
                    tabsContainer.scrollBy({ left: 100, behavior: 'smooth' });
                    setTimeout(checkScroll, 300);
                });

                // Update on events
                tabsContainer.addEventListener('scroll', checkScroll);
                window.addEventListener('resize', checkScroll);

                // Initial check
                checkScroll();
            }



            // Modal setup and management
            function setupModalTriggers() {
                // Visit tab
                setupModalButton('newVisitBtn', 'add-visit-modal');
                setupDataButtons('.edit-visit-btn', 'data-visit-id', editVisit);
                setupFormDeleteButtons('.delete-visit-btn', '.delete-visit-form',
                    'visit record', showDeleteConfirmation);

                // Medical Conditions tab
                setupModalButton('medicalConditionBtn', 'addConditionModal');
                setupDataButtons('.view-medical-condition-btn', 'data-condition-id', viewMedicalCondition);
                setupDataButtons('.edit-medical-condition-btn', 'data-condition-id', editMedicalCondition, true);
                setupFormDeleteButtons('.delete-medical-condition-btn', '.delete-medical-condition-form',
                    'medical condition', showMedicalConditionDeleteConfirmation);

                // Allergies tab
                setupModalButton('addAllergiesBtn', 'addAllergyModal');
                setupDataButtons('.view-allergy-btn', 'data-allergy-id', viewAllergy);
                setupDataButtons('.edit-allergy-btn', 'data-allergy-id', editAllergy, true);
                setupFormDeleteButtons('.delete-allergy-btn', '.delete-allergy-form',
                    'allergy', showAllergyDeleteConfirmation);

                // Medications tab
                setupModalButton('addMedicationBtn', 'add-medication-modal');
                setupDataButtons('.view-medication-btn', 'data-medication-id', viewMedication);
                setupDataButtons('.edit-medication-btn', 'data-medication-id', editMedication, true);
                setupFormDeleteButtons('.delete-medication-btn', '.delete-medication-form',
                    'medication', showMedicationDeleteConfirmation);


                // Helper for setting up modal open buttons
                function setupModalButton(btnId, modalId) {
                    const btn = document.getElementById(btnId);
                    const modal = document.getElementById(modalId);

                    if (btn && modal) {
                        btn.addEventListener('click', () => {
                            modal.classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        });
                    }
                }

                // Helper for setting up buttons that work with data attributes
                function setupDataButtons(selector, dataAttr, handler, stopPropagation = false) {
                    const buttons = document.querySelectorAll(selector);
                    buttons.forEach(btn => {
                        btn.addEventListener('click', function (e) {
                            if (stopPropagation) e.stopPropagation();
                            const id = this.getAttribute(dataAttr);
                            handler(id, this);
                        });
                    });
                }

                // Helper for setting up form delete buttons
                function setupFormDeleteButtons(btnSelector, formSelector, entityName, confirmHandler) {
                    const buttons = document.querySelectorAll(btnSelector);
                    buttons.forEach(btn => {
                        btn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            e.preventDefault();

                            const form = this.closest(formSelector);
                            if (!form) {
                                console.error(`Delete button not in a form:`, this);
                                Swal.fire({
                                    title: 'Error!',
                                    text: `Cannot delete ${entityName}: Form not found`,
                                    icon: 'error',
                                    confirmButtonColor: '#F91D7C'
                                });
                                return;
                            }

                            confirmHandler(form);
                        });
                    });
                }

                // Modal close functionality
                function setupModalCloseButtons() {
                    // Close buttons
                    document.querySelectorAll('.close-modal-btn, .cancel-btn').forEach(btn => {
                        btn.addEventListener('click', function () {
                            closeModal(this.closest('.modal'));
                        });
                    });

                    // Overlay clicks
                    document.querySelectorAll('.modal-overlay').forEach(overlay => {
                        overlay.addEventListener('click', function () {
                            closeModal(this.closest('.modal'));
                        });
                    });

                    // ESC key
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape') {
                            document.querySelectorAll('.modal:not(.hidden)').forEach(closeModal);
                        }
                    });
                }

                function closeModal(modal) {
                    if (modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                }

                // Form submissions
                function initFormHandlers() {
                    // Only setup forms that don't have their own handlers
                    const formConfigs = [
                        { id: 'edit-visit-form', method: 'PUT', urlFn: form => `/api/visits/${form.elements['visit_id'].value}` },
                        {
                            id: 'edit-medical-condition-form', method: 'PUT', urlFn: form =>
                                `/api/medical-conditions/${form.elements['condition_id'].value}`
                        },
                        { id: 'add-allergies-form', url: '/api/allergies', method: 'POST' },
                        {
                            id: 'edit-allergies-form', method: 'PUT', urlFn: form =>
                                `/api/allergies/${form.elements['allergy_id'].value}`
                        },
                        { id: 'add-medication-form', url: '/api/medications', method: 'POST' },
                        {
                            id: 'edit-medication-form', method: 'PUT', urlFn: form =>
                                `/api/medications/${form.elements['medication_id'].value}`
                        }
                    ];

                    formConfigs.forEach(config => {
                        setupFormSubmission(config.id, config.url, config.method, config.urlFn);
                    });
                }

                function setupFormSubmission(formId, defaultUrl, method, urlCallback) {
                    const form = document.getElementById(formId);
                    if (!form) {
                        console.error(`Form not found: ${formId}`);
                        return;
                    }

                    // Skip forms with their own handlers
                    const skipForms = ['add-visit-form', 'addConditionForm', 'add-medical-condition-form'];
                    if (skipForms.includes(formId)) {
                        console.log(`Skipping ${formId} setup - handled elsewhere`);
                        return;
                    }

                    form.dataset.hasSubmitHandler = 'true';

                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        // Prevent duplicate submissions
                        if (form.dataset.submitting === 'true') return;
                        form.dataset.submitting = 'true';

                        const formData = new FormData(form);
                        const url = urlCallback ? urlCallback(form) : defaultUrl;

                        // Handle blood pressure fields
                        if (formId.includes('visit')) {
                            const systolic = formData.get('systolic');
                            const diastolic = formData.get('diastolic');
                            if (systolic && diastolic) {
                                formData.set('blood_pressure', `${systolic}/${diastolic}`);
                                formData.delete('systolic');
                                formData.delete('diastolic');
                            }
                        }

                        // Form submission code would go here
                        // This section is commented out in the original code
                        form.dataset.submitting = 'false';
                    });
                }

                // ==================== API Functions ====================

                // Visit functions
                function editVisit(visitId) {
                    callApi(`/api/visits/${visitId}`, data => {
                        const form = document.getElementById('edit-visit-form');
                        if (!form) return;

                        form.elements['visit_id'].value = visitId;
                        form.elements['timestamp'].value = data.timestamp.substr(0, 10);
                        form.elements['weight'].value = data.weight;
                        form.elements['height'].value = data.height;

                        if (data.blood_pressure) {
                            const bp = data.blood_pressure.split('/');
                            form.elements['systolic'].value = bp[0] || '';
                            form.elements['diastolic'].value = bp[1] || '';
                        }

                        form.elements['notes'].value = data.notes || '';

                        showModal('edit-visit-modal');
                    });
                }

                function showDeleteConfirmation(form) {
                    confirmDelete(form, 'This will permanently delete this visit record.',
                        'Visit record has been deleted successfully.');
                }

                // Medical condition functions
                function viewMedicalCondition(conditionId) {
                    callApi(`/conditions/${conditionId}`, data => {
                        document.getElementById('conditionName').textContent = data.condition;
                        document.getElementById('conditionNotes').textContent = data.note || 'No additional notes';
                        showModal('viewMedicalConditionModal');
                    });
                }

                function editMedicalCondition(conditionId) {
                    callApi(`/conditions/${conditionId}/edit`, data => {
                        const form = document.getElementById('editConditionForm');
                        if (!form) return;

                        form.elements['condition'].value = data.condition;
                        form.elements['note'].value = data.note || '';
                        form.action = `/conditions/${conditionId}`;

                        showModal('editConditionModal');
                    });
                }

                function showMedicalConditionDeleteConfirmation(form) {
                    confirmDelete(form, 'This will permanently delete this medical condition.',
                        'Medical condition has been deleted successfully.');
                }


                function showAllergyDeleteConfirmation(form) {
                    confirmDelete(form, 'This will permanently delete this allergy.',
                        'Allergy has been deleted successfully.');
                }

                // Allergy functions
                function viewAllergy(allergyId) {
                    callApi(`/allergies/${allergyId}`, data => {
                        document.getElementById('allergyName').textContent = data.allergies;
                        document.getElementById('allergyNotes').textContent = data.note || 'No additional notes';
                        showModal('viewAllergyModal');
                    });
                }


                function editAllergy(allergyId) {
                    callApi(`/allergies/${allergyId}/edit`, data => {
                        const form = document.getElementById('editAllergyForm');
                        if (!form) return;

                        form.elements['allergies'].value = data.allergies;
                        form.elements['note'].value = data.note || '';
                        form.action = `/allergies/${allergyId}`;

                        showModal('editAllergyModal');
                    });
                }

                // Medication functions

                function showMedicationDeleteConfirmation(form) {
                    confirmDelete(form, 'This will permanently delete this medication.',
                        'Medication has been deleted successfully.');
                }


                function viewMedication(medicationId) {
                    callApi(`/api/medications/${medicationId}`, data => {
                        document.getElementById('view-medication-name').textContent = data.medication;
                        document.getElementById('view-medication-dosage').textContent = data.dosage || 'Not specified';
                        document.getElementById('view-medication-frequency').textContent = data.frequency || 'Not specified';

                        const startDate = data.start_date ? new Date(data.start_date).toLocaleDateString() : 'Not specified';
                        document.getElementById('view-medication-start-date').textContent = startDate;

                        const endDate = data.end_date ? new Date(data.end_date).toLocaleDateString() : 'Not specified';
                        document.getElementById('view-medication-end-date').textContent = endDate;

                        document.getElementById('view-medication-notes').textContent = data.note || 'No additional notes';

                        showModal('view-medication-modal');
                    });
                }

                function editMedication(medicationId) {
                    callApi(`/medications/${medicationId}`, data => {
                        const form = document.getElementById('medicationForm');
                        if (!form) return;

                        form.elements['medication'].value = data.medication;
                        form.elements['dosage'].value = data.dosage || '';
                        form.elements['frequency'].value = data.frequency || '';
                        form.elements['duration'].value = data.duration || '';
                        form.elements['note'].value = data.note || '';
                        form.action = `/medications/${medicationId}`;

                        showModal('editMedicationModal');
                    });
                }
                function deleteMedication(medicationId) {
                    if (!confirm('Are you sure you want to delete this medication?')) return;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/api/medications/${medicationId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                        .then(handleApiResponse)
                        .then(() => window.location.reload())
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the medication: ' + error.message);
                        });
                }

                // ==================== Utility Functions ====================




                // API helpers
                function callApi(url, successCallback) {
                    console.log(`Calling API: ${url}`);

                    fetch(url)
                        .then(response => {
                            console.log(`API response status: ${response.status}`);
                            if (!response.ok) {
                                return response.text().then(text => {
                                    console.error(`API error response: ${text}`);
                                    throw new Error(`API request failed: ${response.status}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(`API response data:`, data);
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error(`Error fetching data from ${url}:`, error);
                            // alert(`Failed to load data: ${error.message}`);
                        });
                }

                function handleApiResponse(response) {
                    if (response.ok || response.status === 204) {
                        return response.status === 204 ? {} : response.json();
                    } else {
                        return response.json().then(data => {
                            throw new Error(data.message || 'API request failed');
                        });
                    }
                }

                function showModal(modalId) {
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                }

                function confirmDelete(form, confirmMessage, successMessage) {
                    const actionUrl = form.getAttribute('action');
                    const csrfToken = form.querySelector('input[name="_token"]').value;
                    const method = form.querySelector('input[name="_method"]')?.value || 'POST';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: confirmMessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#F91D7C',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData(form);

                            fetch(actionUrl, {
                                method: 'POST',  // We still use POST for the fetch request
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData  // But we include the _method field in the FormData
                            })
                                .then(response => {
                                    console.log("Delete response status:", response.status);
                                    if (response.ok) {
                                        return response.json();
                                    } else {
                                        return response.json().then(data => {
                                            throw new Error(data.message || 'Failed to delete');
                                        });
                                    }
                                })
                                .then(data => {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message || successMessage,
                                        icon: 'success',
                                        confirmButtonColor: '#F91D7C'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'An error occurred while deleting: ' + error.message,
                                        icon: 'error',
                                        confirmButtonColor: '#F91D7C'
                                    });
                                });
                        }
                    });
                }

            }


        </script>



    @include('patients record/modal/add modal/add_visit')
    @include('patients record/modal/add modal/add_medical_condition')
    @include('patients record/modal/add modal/add_allergies')
    @include('patients record/modal/add modal/add_medication')

    @include('patients record/modal/edit modal/edit_medical_condition')
    @include('patients record/modal/edit modal/edit_allergies')
    @include('patients record/modal/edit modal/edit_medication')
    @include('patients record/modal/edit modal/edit_visit')

    @include('patients record/modal/view modal/view_medical_condition')
    @include('patients record/modal/view modal/view_allergies')
    @include('patients record/modal/view modal/view_medication')