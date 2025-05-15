@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')



@section('content')

    <!-- Main Content Section -->
    <div class="flex-1 p-3 md:p-5 bg-neutral-100 overflow-y-auto">
        <div class="flex flex-col lg:flex-row gap-3 md:gap-5">
            <!-- Left Content Section -->
            <div class="w-full lg:flex-1 p-2 md:p-2.5 flex flex-col gap-5">
                <!-- Banner Image -->
                <div class="w-full h-auto md:h-44 rounded-lg overflow-hidden">

                    <img class="w-full h-full object-cover" src="{{ asset('images/dashboard_img.png') }}"
                        alt="Pelaez Derm Clinic">
                </div>

                <!-- Quick Action Buttons -->
                <div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">

                    <!-- Add Clinic Button -->
                    <button id="openModalBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full"
                        onclick="openClinicModalDirect()">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-6 h-6">
                                <img class="w-full h-full object-cover" src="{{ asset('icons/add_clinic_icon.svg') }}"
                                    alt="Add Clinic">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Branch</span>
                    </button>

                    <!-- Add Staff Button -->
                    <button id="addStaffBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full"
                        onclick="openStaffModalDirect()">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-6 h-6">
                                <img class="w-full h-full object-cover" src="{{ asset('icons/add_staff_icon.svg') }}"
                                    alt="Add Staff">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Staff</span>
                    </button>

                    <!-- Add Appointment Button -->
                    <button id="addAppointmentBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full"
                        onclick="openAppointmentModalDirect()">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-6 h-6">
                                <img class="w-full h-full object-cover" src="{{ asset('icons/add_appointment_icon.svg') }}"
                                    alt="Add Appointment">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Appointment</span>
                    </button>

                    <!-- Add Patient Record Button -->
                    <button id="addPatientBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-7 h-7">
                                <img class="w-full h-full object-cover"
                                    src="{{ asset('icons/add_patient_record_icon.svg') }}" alt="Add Patient Record">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Patient Record</span>
                    </button>

                    <!-- Add Products Button -->
                    <button id="addProductBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full"
                        onclick="openProductModalDirect()">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-6 h-6">
                                <img class="w-full h-full object-cover" src="{{ asset('icons/add_products_icon.svg') }}"
                                    alt="Add Products">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Products</span>
                    </button>

                    <!-- Add Services Button -->
                    <button id="addServiceBtn"
                        class="bg-white rounded-lg p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10 shadow-sm cursor-pointer transition-colors w-full"
                        onclick="openServiceModalDirect()">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#F91D7C]/30 rounded flex justify-center items-center">
                            <div class="w-6 h-6">
                                <img class="w-full h-full object-cover" src="{{ asset('icons/add_services_icon.svg') }}"
                                    alt="Add Services">
                            </div>
                        </div>
                        <span class="text-black text-xs md:text-sm font-normal">Add Services</span>
                    </button>
                </div>
            </div>

            <!-- Right Sidebar - Appointments Calendar and List -->
            <!-- <div class="w-full lg:w-72 p-3 md:p-5 bg-white rounded-lg shadow-sm"> -->
            <div
                class="w-full lg:w-72 max-h-[calc(100vh-100px)] p-3 md:p-5 bg-white rounded-lg shadow-sm overflow-y-auto flex flex-col">



                <!-- Appointments Header -->
                <div class="mb-4">
                    <h2 class="text-base font-bold">Appointments</h2>
                </div>


                <!-- Calendar Section - Real Calendar -->
                <div class="calendar mb-5">
                    <div class="flex justify-between items-center mb-3">
                        @php
                            // Get month and year, potentially from form selection
                            $currentMonth = request()->query('month', date('m'));
                            $currentYear = request()->query('year', date('Y'));

                            // Create date for display
                            $displayDate = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);

                            // Month and year arrays for dropdowns
                            $months = [
                                '01' => 'January',
                                '02' => 'February',
                                '03' => 'March',
                                '04' => 'April',
                                '05' => 'May',
                                '06' => 'June',
                                '07' => 'July',
                                '08' => 'August',
                                '09' => 'September',
                                '10' => 'October',
                                '11' => 'November',
                                '12' => 'December'
                            ];

                            // Generate year range (current year -5 to +5)
                            $currentYearInt = (int) date('Y');
                            $years = range($currentYearInt - 5, $currentYearInt + 5);
                        @endphp

                        <form action="" method="get" class="flex items-center space-x-2">
                            <select name="month" onchange="this.form.submit()"
                                class="text-xs border border-neutral-200 rounded px-1 py-0.5">
                                @foreach($months as $value => $label)
                                    <option value="{{ $value }}" {{ $currentMonth == $value ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="year" onchange="this.form.submit()"
                                class="text-xs border border-neutral-200 rounded px-1 py-0.5">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="grid grid-cols-7 gap-1 mb-1 text-center">
                        <div class="text-xs font-medium">SUN</div>
                        <div class="text-xs font-medium">MON</div>
                        <div class="text-xs font-medium">TUE</div>
                        <div class="text-xs font-medium">WED</div>
                        <div class="text-xs font-medium">THU</div>
                        <div class="text-xs font-medium">FRI</div>
                        <div class="text-xs font-medium">SAT</div>
                    </div>

                    <div>
                        @php
                            // Use current displayed month/year rather than current date
                            $month = $displayDate->format('m');
                            $year = $displayDate->format('Y');
                            $daysInMonth = $displayDate->daysInMonth;
                            $firstDayOfMonth = date('w', strtotime("$year-$month-01"));
                            $day = 1;

                            // Only highlight today if we're viewing the current month/year
                            $isCurrentMonth = (date('m') == $month && date('Y') == $year);
                            $today = $isCurrentMonth ? date('j') : -1;

                            // Format current date for default selection
                            $currentDate = date('Y-m-d');
                        @endphp

                        @for ($i = 0; $i < 6 && $day <= $daysInMonth; $i++)
                            <div class="grid grid-cols-7 text-center">
                                @for ($j = 0; $j < 7; $j++)
                                    @if (($i == 0 && $j < $firstDayOfMonth) || ($day > $daysInMonth))
                                        <div class="h-8 flex justify-center items-center text-gray-400">
                                        </div>
                                    @else
                                        @php
                                            $dateStr = sprintf('%s-%s-%02d', $year, $month, $day);
                                            $isActive = ($day == $today && $isCurrentMonth);
                                            $isSelected = ($dateStr == $currentDate);
                                        @endphp
                                        <div data-date="{{ $dateStr }}"
                                            class="calendar-day h-8 flex justify-center items-center relative cursor-pointer
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $isActive ? 'bg-[#FF006E]' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $isSelected ? 'selected-date' : '' }}"
                                            onclick="selectDate('{{ $dateStr }}', {{ $day }})">
                                            <span class="text-xs z-10 {{ $isActive ? 'font-medium ' : '' }}">{{ $day }}</span>

                                            <!-- Appointment indicator dot - will be populated by JS -->
                                            <div class="appointment-indicator absolute bottom-0.5 w-full flex justify-center">
                                                <div class="appointment-dots" data-date="{{ $dateStr }}"></div>
                                            </div>
                                            @php $day++; @endphp
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Selected Date Info Box -->
                <div class="p-3 border border-neutral-200 rounded-lg mb-4 flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-400" id="dateLabel">Today</div>
                        <div>
                            <!-- Dynamic date display that will update on click -->
                            <div class="text-xs font-medium text-white" id="selectedDate">{{ date('j') }}</div>
                            <!-- Appointment count below the date -->
                            <div class="text-3xl font-medium" id="appointmentCount">0</div>
                        </div>
                    </div>
                    <div class="w-9 h-9 bg-blue-600/30 rounded flex justify-center items-center">
                        <div class="w-5 h-5">
                            <img class="w-full h-full object-cover" src="{{ asset('icons/today_icon.svg') }}"
                                alt="Calendar">
                        </div>
                    </div>
                </div>

                <!-- Appointments List Container -->
                <div id="appointmentsContainer" class="max-h-80 overflow-y-auto">
                    <div class="divide-y divide-neutral-200" id="appointmentsList">
                        <!-- Appointments will be loaded here dynamically -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('branches.modal.add_clinic')
    @include('appointments.modals.appointment-modal')
    @include('staffs.modal.staff-modal')
    @include('patients record/modal/add modal/add_patient')
    @include('inventory.modals.addProduct')
    @include('services.modals.add-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to close modals consistently
            function closeAllModals() {
                const modals = [
                    document.getElementById('clinicModal'),
                    document.getElementById('appointmentModal'),
                    document.getElementById('staffModal'),
                    document.getElementById('patientModal'),
                    document.getElementById('productModal'),
                    document.getElementById('serviceModal')
                ];
                
                modals.forEach(modal => {
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                });
                document.body.style.overflow = 'auto';
            }

            // Close modals when clicking outside
            document.addEventListener('click', function(e) {
                const modals = document.querySelectorAll('.modal-backdrop');
                modals.forEach(modal => {
                    if (e.target === modal) {
                        closeAllModals();
                    }
                });
            });

            // Close modals on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });

            // Make closeAllModals available globally
            window.closeAllModals = closeAllModals;
        });
    </script>

@endsection


@php
    $activePage = 'dashboard'; // Set the active page for this specific view
@endphp


<!-- Sample appointments data structure (this would normally come from your database) -->
<script>
    // Sample appointment data - in a real application, this would come from your database
    const appointmentsData = {
        // Format: 'YYYY-MM-DD': [{clientName: 'Client Name', time: 'HH:MM', ...other data}]
        '{{ date('Y-m-d') }}': [
            { clientName: 'Daven Alajid', time: '09:00' },
            { clientName: 'Ralph Jumao-as', time: '10:30' },
            { clientName: 'Klein Allen', time: '13:00' },
            { clientName: 'Melbert Buligan', time: '15:30' },
            { clientName: 'Janos Panague', time: '13:30' },
            { clientName: 'Edgest Agnayani', time: '14:45' },
            { clientName: 'Yohan Callanta', time: '16:30' },
            { clientName: 'Earl Francis Philip Amoy', time: '17:15' },
            { clientName: 'Andrie Dela Peña', time: '13:30' }
        ],
        '{{ date('Y-m-d', strtotime('+1 day')) }}': [
            { clientName: 'Earl Francis Philip Amoy', time: '11:00' },
            { clientName: 'Edgest Agnayani', time: '14:00' }
        ],
        '{{ date('Y-m-d', strtotime('+2 days')) }}': [
            { clientName: 'Melbert Buligan', time: '10:00' },
            { clientName: 'Klein Allen', time: '12:30' },
            { clientName: 'Cydiemar Lagrosas', time: '16:00' }
        ],
        '{{ date('Y-m-d', strtotime('+3 days')) }}': [
            { clientName: 'Van Kendrick Caseres', time: '09:30' }
        ],
        '{{ date('Y-m-d', strtotime('+5 days')) }}': [
            { clientName: 'Janos Panague', time: '13:30' },
            { clientName: 'Edgest Agnayani', time: '14:45' },
            { clientName: 'Yohan Callanta', time: '16:30' },
            { clientName: 'Earl Francis Philip Amoy', time: '17:15' },
            { clientName: 'Andrie Dela Peña', time: '13:30' },
            { clientName: 'Jao Beronio', time: '14:45' },
            { clientName: 'Klein Allen', time: '16:30' },
            { clientName: 'Van Kendrick Caseres', time: '17:15' }
        ],
        '{{ date('Y-m-d', strtotime('+7 days')) }}': [
            { clientName: 'Xian Calacala', time: '10:15' },
            { clientName: 'Carol White', time: '11:45' }
        ],
        '{{ date('Y-m-d', strtotime('+10 days')) }}': [
            { clientName: 'Janos Panague', time: '14:00' },
            { clientName: 'Daven Alajid', time: '15:30' },
            { clientName: 'Jibril Rubi', time: '16:45' },
            { clientName: 'Yohan Callanta', time: '16:30' },
            { clientName: 'Earl Francis Philip Amoy', time: '17:15' },
            { clientName: 'Andrie Dela Peña', time: '13:30' },
            { clientName: 'Jao Beronio', time: '14:45' }
        ]
    };

    // Function to select a date and show its appointments
    function selectDate(dateString, dayNumber) {
        // Update the visual selected state
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected-date', 'bg-[#FF006E]', 'text-white');
            day.querySelectorAll('span').forEach(span => {
                span.classList.remove('text-white');
            });
        });

        // Find and highlight the clicked date
        const selectedDay = document.querySelector(`[data-date="${dateString}"]`);
        if (selectedDay) {
            selectedDay.classList.add('selected-date', 'bg-[#FF006E]');
            selectedDay.querySelector('span').classList.add('text-white');
        }

        // Update the displayed date information
        document.getElementById('selectedDate').textContent = dayNumber;

        // Update the date label (Today/Selected Date)
        const today = '{{ date('Y-m-d') }}';
        if (dateString === today) {
            document.getElementById('dateLabel').textContent = 'Today';
        } else {
            const selectedDate = new Date(dateString);
            const formattedDate = selectedDate.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            document.getElementById('dateLabel').textContent = formattedDate;
        }

        // Load appointments for the selected date
        loadAppointments(dateString);
    }

    // Function to load appointments for a specific date
    function loadAppointments(dateString) {
        const appointmentsList = document.getElementById('appointmentsList');
        appointmentsList.innerHTML = ''; // Clear existing appointments

        const appointments = appointmentsData[dateString] || [];

        // Update appointment count - just the number
        document.getElementById('appointmentCount').textContent = appointments.length;

        if (appointments.length === 0) {
            // Show a message when no appointments exist
            const noAppointmentsElem = document.createElement('div');
            noAppointmentsElem.className = 'py-2 px-2.5 text-sm text-gray-500';
            noAppointmentsElem.textContent = 'No appointments for this day';
            appointmentsList.appendChild(noAppointmentsElem);
        } else {
            // Display all appointments for the selected date
            appointments.forEach(appointment => {
                const appointmentElem = document.createElement('div');
                appointmentElem.className = 'py-2 px-2.5';
                appointmentElem.innerHTML = `
                            <div class="text-sm">${appointment.clientName}</div>
                            <div class="text-xs text-gray-500">${appointment.time}</div>
                        `;
                appointmentsList.appendChild(appointmentElem);
            });
        }
    }

    // Function to update appointment indicators on calendar days
    function updateAppointmentIndicators() {
        // Clear existing indicators
        document.querySelectorAll('.appointment-dots').forEach(el => {
            el.innerHTML = '';
        });

        // Add indicators for dates with appointments
        for (const dateStr in appointmentsData) {
            const count = appointmentsData[dateStr].length;
            if (count > 0) {
                const indicator = document.querySelector(`.appointment-dots[data-date="${dateStr}"]`);
                if (indicator) {
                    // If many appointments, just show a single dot in a different color
                    if (count >= 5) {
                        indicator.innerHTML = '<div class="w-1 h-1 rounded-full bg-[#FF006E]"></div>';
                    } else {
                        // For fewer appointments, show small dots
                        indicator.innerHTML = '<div class="w-1 h-1 rounded-full bg-gray-400"></div>';
                    }
                }
            }
        }
    }

    // Initialize by loading today's appointments
    document.addEventListener('DOMContentLoaded', function () {
        // Set styling for the selected-date class
        const style = document.createElement('style');
        style.innerHTML = `
                    .selected-date span {
                        color: white !important;
                    }
                    .calendar-day:hover {
                        background-color: rgba(255, 0, 110, 0.1);
                    }
                    .appointment-dots {
                        display: flex;
                        gap: 2px;
                    }
                `;
        document.head.appendChild(style);

        // Initialize with today's date
        const today = '{{ date('Y-m-d') }}';
        const todayNumber = {{ date('j') }};

        // Add appointment indicators for all dates
        updateAppointmentIndicators();

        // Load today's appointments
        loadAppointments(today);

        // Add selected-date class to today initially
        const todayElement = document.querySelector(`[data-date="${today}"]`);
        if (todayElement) {
            todayElement.classList.add('selected-date', 'bg-[#FF006E]');
            todayElement.querySelector('span').classList.add('text-white');
        }
    });

</script>