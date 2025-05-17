@extends('layouts.app')

@section('title', 'Patient Details - ' . $patient->full_name)
@section('header', 'Patient Details')

@section('content')
    <div class="w-full bg-neutral-100 p-3 md:p-5">
        <div class="bg-white p-3 md:p-5 rounded-lg"> 
            <!-- Back button and edit button row -->
            <div class="p-2 flex justify-between items-center w-full">
                <!-- Back button -->
                <button class="text-gray-800">
                    <a href="{{ route('patients.index') }}" class="p-3.5 flex items-center gap-3.5 hover:bg-pink-600/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </button>

                <!-- Edit button-->
                <button id="editPatientBtn" class="edit-patient-btn w-6 h-6 relative overflow-hidden flex items-center justify-center"  data-pid="{{ $patient->PID }}" onclick="event.stopPropagation();">
                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                </button>
            </div>

            <div class="p-2">
                <!-- Patient Name -->
                <h2 class="text-lg font-bold px-4 mb-4">{{ $patient->full_name }}</h2>

                <!-- Mobile View Layout -->
                <div class="px-4 md:hidden">
                    <!-- Row 1: Patient ID and Sex -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div>
                            <p class="text-neutral-500 text-xs mb-2">Patient ID</p>
                            <p class="text-sm md:text-base">{{ $patient->PID }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500 text-xs mb-2">Sex</p>
                            <p class="text-sm md:text-base">{{ $patient->sex }}</p>
                        </div>
                    </div>

                    <!-- Row 2: Address (full width) -->
                    <div class="mb-4">
                        <p class="text-neutral-500 text-xs mb-2">Address</p>
                        <p class="text-sm md:text-base">{{ $patient->address }}</p>
                    </div>

                    <!-- Row 3: Contact Number and Date of Birth -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div>
                            <p class="text-neutral-500 text-xs mb-2">Contact Number</p>
                            <p class="text-sm md:text-base">{{ $patient->contact_number }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500 text-xs mb-2">Date of Birth</p>
                            <p class="text-sm md:text-base">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500 text-xs mb-2">Civil Status</p>
                            <p class="text-sm md:text-base">{{ $patient->civil_status ?? 'Not specified' }}</p>
                        </div>
                    </div>

                   
                </div>

                <!-- Desktop View Layout -->
                <div class="hidden md:block">
                    <!-- First Row of Patient Details -->
                    <div class="flex flex-wrap">
                        <div class="w-1/7 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Patient ID</p>
                            <p class="text-sm">{{ $patient->PID }}</p>
                        </div>
                        <div class="w-1/7 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Sex</p>
                            <p class="text-sm">{{ $patient->sex }}</p>
                        </div>
                        <div class="w-1/3 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Address</p>
                            <p class="text-sm">{{ $patient->address }}</p>
                        </div>
                        <div class="w-1/7 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Contact Number</p>
                            <p class="text-sm">{{ $patient->contact_number }}</p>
                        </div>
                        <div class="w-1/7 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Date of Birth</p>
                            <div class="flex items-center">
                                <p class="text-sm">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F d, Y') }}</p>
                            </div>
                        </div>
                        <div class="w-1/7 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Civil Status</p>
                            <p class="text-sm">{{ $patient->civil_status ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <!-- Second Row of Patient Details -->
                    <!-- <div class="flex flex-wrap"> -->
                        
                        <!-- <div class="w-1/5 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Weight (kg)</p>
                            <p class="text-sm">{{ $patient->latest_visit ? $patient->latest_visit->weight : 'Not recorded' }}</p>
                        </div>
                        <div class="w-1/5 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Height (cm)</p>
                            <p class="text-sm">{{ $patient->latest_visit ? $patient->latest_visit->height : 'Not recorded' }}</p>
                        </div>
                        <div class="w-1/5 px-4 mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Blood Pressure</p>
                            <div class="flex items-center">
                                <div class="flex">
                                    @if($patient->latest_visit && $patient->latest_visit->blood_pressure)
                                        @php
                                            $bp = explode('/', $patient->latest_visit->blood_pressure);
                                        @endphp
                                        <span class="py-1 text-sm">{{ $bp[0] ?? '' }}</span>
                                        <span class="text-sm py-1">/</span>
                                        <span class="py-1 text-sm">{{ $bp[1] ?? '' }}</span>
                                    @else
                                        <span class="py-1 text-sm">Not recorded</span>
                                    @endif
                                </div>
                            </div>
                        </div> -->
                    <!-- </div> -->
                </div>
            </div>

            <div class="p-2">
                @include('patients record.patient_details_tab_navigation')

                <!-- Pagination -->
                @if(isset($pagination) && $pagination)
                <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                        Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['total'] }} results
                    </div>
                    <div class="flex space-x-1">
                        @if($pagination['current_page'] > 1)
                            <a href="{{ $pagination['prev_page_url'] }}" class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500">Previous</a>
                        @else
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-300 cursor-not-allowed">Previous</button>
                        @endif
                        
                        @for($i = 1; $i <= $pagination['last_page']; $i++)
                            @if($i == $pagination['current_page'])
                                <span class="w-8 h-8 flex items-center justify-center bg-[#F91D7C] text-white rounded text-sm">{{ $i }}</span>
                            @else
                                <a href="{{ str_replace('page='.$pagination['current_page'], 'page='.$i, $pagination['path']) }}" 
                                   class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-sm">{{ $i }}</a>
                            @endif
                        @endfor
                        
                        @if($pagination['current_page'] < $pagination['last_page'])
                            <a href="{{ $pagination['next_page_url'] }}" class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500">Next</a>
                        @else
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-300 cursor-not-allowed">Next</button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

       @include('patients record/modal/edit modal/edit_patient_details')
@endsection

@php
    $activePage = 'patientsRecord';
@endphp