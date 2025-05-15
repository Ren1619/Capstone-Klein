@extends('layouts.app')

@section('title', 'Patient Records')
@section('header', 'Patient Details')

@section('content')
    <div class="w-full  bg-neutral-100 p-3 md:p-5">
        <div class=" bg-white p-3 md:p-5 rounded-lg"> 
            <!-- Back button -->
            <div class="p-2 flex justify-between items-center w-full">
                <!-- Back button -->
                <button class="text-gray-800">
                    <a href={{ url('/patientsRecord') }} class="p-3.5 flex items-center gap-3.5 hover:bg-pink-600/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </button>

                <!-- Edit button-->
                <button id="editPatientBtn" class="w-6 h-6 relative overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                    </button>
                </div>


                <div class=" p-2">
                    <!-- Patient Name -->
                    <h2 class="text-lg font-bold px-4 mb-4">Earl Francis Philip M. Amoy</h2>

                    <!-- Mobile View Layout -->
                    <div class="px-4 md:hidden">
                        <!-- Row 1: Patient ID and Sex -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Patient ID</p>
                                <p class="text-sm md:text-base">P-Mar-2025-01</p>
                            </div>
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Sex</p>
                                <p class="text-sm md:text-base">Male</p>
                            </div>
                        </div>

                        <!-- Row 2: Address (full width) -->
                        <div class="mb-4">
                            <p class="text-neutral-500 text-xs mb-2">Address</p>
                            <p class="text-sm md:text-base">Dologon, Maramag, Bukidnon</p>
                        </div>

                        <!-- Row 3: Contact Number and Date of Birth -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Contact Number</p>
                                <p class="text-sm md:text-base">09123456789</p>
                            </div>
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Date of Birth</p>
                                <p class="text-sm md:text-base">May 1, 2003</p>
                            </div>
                        </div>

                        <!-- Row 4: Civil Status and Weight -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Civil Status</p>
                                <p class="text-sm md:text-base">Single</p>
                            </div>
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Weight (kg)</p>
                                <p class="text-sm md:text-base">50</p>
                            </div>
                        </div>

                        <!-- Row 5: Height and Blood Pressure -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Height (cm)</p>
                                <p class="text-sm md:text-base">165</p>
                            </div>
                            <div>
                                <p class="text-neutral-500 text-xs mb-2">Blood Pressure</p>
                                <div class="flex">
                                    <span class="text-sm md:text-base">130</span>
                                    <span class="text-sm md:text-base">/</span>
                                    <span class="text-sm md:text-base">90</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop View (Original Layout) -->
                    <div class="hidden md:block">
                        <!-- First Row of Patient Details -->
                        <div class="flex flex-wrap">
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2 ">Patient ID</p>
                                <p class="text-sm">P-Mar-2025-01</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Sex</p>
                                <p class="text-sm">Male</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Address</p>
                                <p class="text-sm">Dologon, Maramag, Bukidnon</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Contact Number</p>
                                <p class="text-sm">09123456789</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Date of Birth</p>
                                <div class="flex items-center">
                                    <p class="text-sm">May 1, 2003</p>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row of Patient Details -->
                        <div class="flex flex-wrap">
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Civil Status</p>
                                <p class="text-sm">Single</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Weight (kg)</p>
                                <p class="text-sm">50</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Height (cm)</p>
                                <p class="text-sm">165</p>
                            </div>
                            <div class="w-1/5 px-4 mb-4">
                                <p class="text-neutral-500 text-xs mb-2">Blood Pressure</p>
                                <div class="flex items-center">
                                    <div class="flex">
                                        <span class="py-1 text-sm">130</span>
                                        <span class="text-sm py-1">/</span>
                                        <span class="py-1 text-sm">90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="p-2">

                @include('patients record/patient_details_tab_navigation')





                 <!-- Pagination -->
                 <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 mb-3 sm:mb-0">Showing 1 to 3 of 9 results</div>
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
            </div>
            <!-- </div> -->
        </div>
    </div>


    @include('patients record/modal/edit modal/edit_patient_details')
@endsection

@php
    $activePage = 'patientsRecord'; // Set the active page for this specific view
@endphp