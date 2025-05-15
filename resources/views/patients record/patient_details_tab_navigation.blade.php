<div id="patient-tabs">
    {{-- Tabs Navigation --}}
    <!-- Responsive Tabs Navigation -->
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

        {{-- Visit History Content --}}
        <div id="visit-content" class="tab-content">

            <div id="newVisitBtn" class="flex justify-end mb-4 relative group">
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
                                        <!-- edit button -->
                                        <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                        </button>
                                        <!-- delete button -->
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

            <!-- Mobile View -->
            <div class="md:hidden">
                <!-- <div id="newVisitBtn" class="flex justify-end mb-4">
                    <button id="newVisitBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Visit">
                    </button>

                </div> -->
                @for ($i = 0; $i < 9; $i++)
                    <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5"
                        onclick="window.location.href='{{ url('/patientsVisits') }}';" style="cursor: pointer;">
                        <div class="flex justify-between items-center ">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $i + 1 }}.</span>March 25,
                                2025
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                </button>
                                <!-- delete button -->
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
        <!-- id="medicalConditionBtn"  -->
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
                        @foreach ($conditions as $index => $condition)
                            <tr class="view-medical-condition-btn border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                    <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                    <span class="font-normal">{{ $condition['name'] }}</span>

                                </td>
                                <td class="py-3">
                                    <div class="flex justify-end items-center gap-3.5">
                                        <!-- edit button -->
                                        <!-- id="editMedicalConditionBtn"  -->
                                        <button class=" edit-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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
                @foreach ($conditions as $index => $condition)
                    <div class="view-medical-condition-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $condition['name'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button class="edit-medical-condition-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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

            <!-- Desktop View -->
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
                                        <!-- edit button -->
                                        <button class="edit-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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
                <!-- <div id="addAllergiesBtn" class="flex justify-end mb-4">
                    <button id="addAllergiesBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Allergies">
                    </button>
                </div> -->
                @foreach ($allergies as $index => $allergy)
                    <div class="view-allergy-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $allergy['allergen'] }}</span>

                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button class="edit-allergy-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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

            <!-- Desktop View -->
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
                                        <!-- edit button -->
                                        <button class="edit-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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
                <!-- <div id="addMedicationBtn" class="flex justify-end mb-4">
                    <button id="addMedicationBtn" class="text-[#F91D7C] z-10 flex items-center">
                        <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Medication">
                    </button>
                </div> -->
                @foreach ($medications as $index => $medication)
                    <div class="view-medication-btn border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-poppins">
                                <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                <span class="font-normal">{{ $medication['name'] }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- edit button -->
                                <button class="edit-medication-btn w-6 h-6 relative overflow-hidden flex items-center justify-center">
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


    <!-- JavaScript to handle horizontal scrolling and show/hide arrows -->
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



    @include('patients record/modal/add modal/add_visit')
    @include('patients record/modal/add modal/add_medical_condition')
    @include('patients record/modal/add modal/add_allergies')
    @include('patients record/modal/add modal/add_medication')

    @include('patients record/modal/edit modal/edit_medical_condition')
    @include('patients record/modal/edit modal/edit_allergies')
    @include('patients record/modal/edit modal/edit_medication')

    @include('patients record/modal/view modal/view_medical_condition')
    @include('patients record/modal/view modal/view_allergies')
    @include('patients record/modal/view modal/view_medication')