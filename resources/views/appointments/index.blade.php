@extends('layouts.app')

@section('title', 'Appointments')
@section('header', 'Appointments')

@section('content')
    <div class="bg-neutral-100 p-3 md:p-5">
        <div class="bg-white p-3 md:p-5 rounded-lg">
            <!-- Content Area -->
            <div class="p-4 sm:p-6">
                <!-- Status Cards - 2 cards per row on mobile -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
                    @php
                        $statusCards = [
                            [
                                'status' => 'today',
                                'label' => 'Today',
                                'count' => $todayCount ?? 0,
                                'icon' => 'today_icon.svg',
                                'bg' => 'blue-100',
                                'active' => true
                            ],
                            [
                                'status' => 'pending',
                                'label' => 'Pending',
                                'count' => $pendingCount ?? 0,
                                'icon' => 'pending_icon.svg',
                                'bg' => 'amber-100',
                                'active' => false
                            ],
                            [
                                'status' => 'upcoming',
                                'label' => 'Upcoming',
                                'count' => $upcomingCount ?? 0,
                                'icon' => 'upcoming_icon.svg',
                                'bg' => 'pink-100',
                                'active' => false
                            ],
                            [
                                'status' => 'completed',
                                'label' => 'Completed',
                                'count' => $completedCount ?? 0,
                                'icon' => 'completed_icon.svg',
                                'bg' => 'green-100',
                                'active' => false
                            ],
                            [
                                'status' => 'cancelled',
                                'label' => 'Cancelled',
                                'count' => $cancelledCount ?? 0,
                                'icon' => 'cancelled_icon.svg',
                                'bg' => 'red-100',
                                'active' => false
                            ]
                        ];
                    @endphp

                    @foreach($statusCards as $card)
                        <button type="button" data-status="{{ $card['status'] }}"
                            class="status-card {{ $card['active'] ? 'bg-blue-50' : 'bg-white' }} rounded-lg shadow-sm p-4 flex justify-between items-start h-24">
                            <div>
                                <p class="text-gray-500 mb-2">{{ $card['label'] }}</p>
                                <p class="text-3xl sm:text-4xl font-normal">{{ $card['count'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-{{ $card['bg'] }} rounded-md flex items-center justify-center mt-1">
                                <img src="{{ asset('icons/' . $card['icon']) }}" alt="{{ $card['label'] }}">
                            </div>
                        </button>
                    @endforeach
                </div>

                <!-- Main Content Box -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 overflow-x-auto">
                        <div class="flex min-w-full">
                            @php
                                $tabs = [
                                    ['id' => 'consultation', 'label' => 'Consultation', 'active' => true],
                                    ['id' => 'treatment', 'label' => 'Treatment/Service', 'active' => false]
                                ];
                            @endphp

                            @foreach($tabs as $tab)
                                <button type="button" data-tab="{{ $tab['id'] }}"
                                    class="tab-button px-4 sm:px-6 py-3 sm:py-4 relative {{ $tab['active'] ? 'text-[#F91D7C]' : 'text-gray-800' }} font-normal whitespace-nowrap">
                                    {{ $tab['label'] }}
                                    @if($tab['active'])
                                        <div class="absolute bottom-0 left-0 h-0.5 w-full bg-[#F91D7C]"></div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="py-3 sm:py-4"></div>

                    <!-- Content Area with Add Button -->
                    <div class="relative">
                        <div class="flex justify-end px-4 sm:px-6 mb-4">
                            <button id="addAppointmentBtn" class="text-[#F91D7C] z-10 flex items-center">
                                <img src="{{ asset('icons/add_appointment.svg') }}" alt="Add Appointment">
                            </button>
                        </div>

                        <!-- Appointment Table for large screens -->
                        <div class="hidden md:block px-4 sm:px-6 pb-6">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-full">
                                    <thead>
                                        <tr class="text-left text-gray-500">
                                            <th class="pb-4 font-normal" style="width: 30%;">Patient Name</th>
                                            <th class="pb-4 font-normal" style="width: 20%;">Date</th>
                                            <th class="pb-4 font-normal" style="width: 15%;">Time</th>
                                            <th class="pb-4 font-normal" style="width: 25%;">Appointment Type</th>
                                            <th class="pb-4 font-normal text-right" style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="appointment-list">
                                        @forelse($appointments as $appointment)
                                            <tr class="border-t border-gray-100">
                                                <td class="py-5">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                                                <td class="py-5">{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</td>
                                                <td class="py-5">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                                <td class="py-5">{{ $appointment->appointment_type }}</td>
                                                <td class="py-5 text-right">
                                                    <div class="flex justify-end space-x-2">
                                                        @if($appointment->status == 'pending')
                                                            <button class="text-green-600 approve-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/check_icon.svg') }}" alt="Approve">
                                                            </button>
                                                            <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                            </button>
                                                        @elseif($appointment->date == \Carbon\Carbon::today()->format('Y-m-d'))
                                                            <button class="text-[#F91D7C] complete-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/check_icon.svg') }}" alt="Done">
                                                            </button>
                                                            <button class="text-[#F91D7C] reschedule-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/reschedule_icon.svg') }}" alt="Reschedule">
                                                            </button>
                                                            <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                            </button>
                                                        @elseif($appointment->date > \Carbon\Carbon::today()->format('Y-m-d'))
                                                            <button class="text-[#F91D7C] reschedule-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/reschedule_icon.svg') }}" alt="Reschedule">
                                                            </button>
                                                            <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                                <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                            </button>
                                                        @else
                                                            <span class="inline-block px-4 py-1 {{ $appointment->status == 'completed' ? 'bg-[#2CA74D]/30 text-green-800' : 'bg-[#D11313]/30 text-red-800' }} rounded-lg text-sm">
                                                                {{ $appointment->status }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="py-5 text-center text-gray-500">No appointments found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Appointment Cards for mobile/tablet -->
                        <div class="md:hidden px-4 sm:px-6 pb-6">
                            <div id="appointment-cards" class="space-y-4">
                                @forelse($appointments as $appointment)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-normal">{{ $appointment->first_name }} {{ $appointment->last_name }}</h3>
                                            <div class="flex space-x-2">
                                                @if($appointment->status == 'pending')
                                                    <button class="text-green-600 approve-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/check_icon.svg') }}" alt="Approve">
                                                    </button>
                                                    <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                    </button>
                                                @elseif($appointment->date == \Carbon\Carbon::today()->format('Y-m-d'))
                                                    <button class="text-[#F91D7C] complete-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/check_icon.svg') }}" alt="Done">
                                                    </button>
                                                    <button class="text-[#F91D7C] reschedule-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/reschedule_icon.svg') }}" alt="Reschedule">
                                                    </button>
                                                    <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                    </button>
                                                @elseif($appointment->date > \Carbon\Carbon::today()->format('Y-m-d'))
                                                    <button class="text-[#F91D7C] reschedule-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/reschedule_icon.svg') }}" alt="Reschedule">
                                                    </button>
                                                    <button class="text-red-600 cancel-btn" data-id="{{ $appointment->appointment_ID }}">
                                                        <img src="{{ asset('icons/xmark_icon.svg') }}" alt="Cancel">
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <p class="text-gray-500">Date</p>
                                                <p>{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Time</p>
                                                <p>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                                            </div>
                                            <div class="col-span-2">
                                                <p class="text-gray-500">Type</p>
                                                <p>{{ $appointment->appointment_type }}</p>
                                            </div>
                                            @if($appointment->status == 'completed' || $appointment->status == 'cancelled')
                                                <div class="col-span-2 mt-1">
                                                    <span class="inline-block px-3 py-1 {{ $appointment->status == 'completed' ? 'bg-[#2CA74D]/30 text-green-800' : 'bg-[#D11313]/30 text-red-800' }} rounded-lg text-xs">
                                                        {{ $appointment->status }}
                                                    </span>
                                                </div>                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-gray-500">No appointments found</div>
                                @endforelse
                            </div>
                        </div>                    <!-- Pagination -->
                    <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                            @if(is_object($appointments) && method_exists($appointments, 'firstItem'))
                                Showing {{ $appointments->firstItem() ?? 0 }} to {{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() ?? 0 }} results
                            @else
                                Showing {{ count($appointments) }} results
                            @endif
                        </div>
                        <div class="pagination-container">
                            @if(is_object($appointments) && method_exists($appointments, 'links'))
                                {{ $appointments->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('appointments.modals.appointment-modal')

    <!-- Add a feedback modal -->
    @include('feedbacks.modals.feedback-modal')

    <!-- Add a reschedule modal -->
    @include('appointments.modals.reschedule-modal')

@endsection

@section('scripts')
<script src="{{ asset('js/appointments.js') }}"></script>
@endsection

@php
    $activePage = 'appointments'; // Set the active page for this specific view
@endphp