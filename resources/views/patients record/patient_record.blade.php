@extends('layouts.app')

@section('title', 'Patient Records')
@section('header', 'Patient Records')

@section('content')
    <div class="w-full  bg-neutral-100 p-3 md:p-5">
        <div class="flex flex-col w-full gap-4 md:gap-7">
            <!-- New Patient Button -->


            <!-- Header Section -->
            <div
                class="w-full bg-white rounded-lg p-2 sm:p-3 md:px-7 md:py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
                <!-- Search bar -->
                <div class="w-full sm:w-52 relative">
                    <input type="text" placeholder="Search Patients..."
                        class="w-full h-9 px-2.5 py-1.5 pl-9 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-normal leading-none tracking-tight focus:outline-[#F91D7C] focus:outline-0.5" />
                    <div class="absolute left-2.5 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Dropdown and button  -->
                <div class="flex flex-row items-center justify-between gap-2 sm:gap-5 w-full sm:w-auto mt-2 sm:mt-0">
                    <!-- Dropdown -->
                    <div class="relative inline-block w-1/2 sm:w-32">
                        <div class="relative">
                            <select id="timeFilter" name="time_filter"
                                class="w-full h-9 px-2 sm:px-2.5 py-1.5 pr-6 sm:pr-8 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-semibold appearance-none focus:outline-[#F91D7C] focus:outline-2 truncate bg-transparent">
                                <option value="all_time">All Time</option>
                                <option value="this_week">This Week</option>
                                <option value="this_month">This Month</option>
                                <option value="last_3_months">Last 3 Months</option>
                                <option value="last_year">Last Year</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-1 sm:right-2 flex items-center">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Add patient button -->
                    <button data-property-1="Default" id="addPatientBtn"
                        class="w-1/2 sm:w-36 h-9 sm:h-10 px-2 sm:px-4 py-1 bg-[#F91D7C] hover:bg-[#D4156A] rounded-md flex items-center justify-between transition-colors duration-200">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 relative overflow-hidden">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4V20M4 12H20" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-white text-xs sm:text-sm font-semibold leading-none tracking-tight truncate">
                            New Patient
                        </div>
                    </button>
                </div>
            </div>


            <!-- Patient Information Section -->
            <div class="w-full bg-white rounded-lg p-3 md:px-7 md:py-3.5 flex flex-col">
                <!-- Table for desktop/large screens -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full min-w-full table-auto">
                        <thead>
                            <tr class="border-b border-neutral-200">
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal  whitespace-nowrap px-2"
                                    style="width: 40%;">
                                    <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                    Patients Name
                                </th>
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal  whitespace-nowrap px-2"
                                    style="width: 25%;">
                                    ID
                                </th>
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal  whitespace-nowrap px-2"
                                    style="width: 20%;">
                                    Last Visit
                                </th>
                                <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal  whitespace-nowrap px-2"
                                    style="width: 15%;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @for ($i = 0; $i < 8; $i++)

                                <tr class="border-b border-neutral-200 hover:bg-[#F91D7C]/5"
                                    onclick="window.location.href='{{ url('/patientsDetails') }}';" style="cursor: pointer;">
                                    <td class="py-3 text-black text-sm md:text-base font-normal  px-2">
                                        <div class="flex items-center">
                                            <span class="inline-block mr-2 text-neutral-500 shrink-0">{{ $i + 1 }}.</span>
                                            <span class="truncate">Earl Francis Philip Amoy</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-black text-sm md:text-base font-normal  truncate px-2">
                                        P-Mar-2025-01
                                    </td>
                                    <td class="py-3 text-black text-sm md:text-base font-normal  truncate px-2">
                                        March 27, 2025
                                    </td>
                                    <td class="py-3 px-2">
                                        <div class="flex justify-end items-center gap-2 md:gap-3.5">
                                            <!-- edit button -->
                                            <button id="editPatientBtn" class="w-10 h-10 relative overflow-hidden flex items-center justify-center"
                                                onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                            </button>
                                            <!-- delete button -->
                                            <button class="w-10 h-10 relative overflow-hidden flex items-center justify-center"
                                                onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- Cards for mobile/tablet -->
                <div class="md:hidden">
                    <div class="space-y-4">
                        @for ($i = 0; $i < 9; $i++)
                            <div class="border border-neutral-200 rounded-lg p-4 hover:bg-[#F91D7C]/10"
                                onclick="window.location.href='{{ url('/patientsDetails') }}';" style="cursor: pointer;">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-medium font-poppins">
                                        <span class="inline-block mr-2 text-neutral-500">{{ $i + 1 }}.</span>
                                        Earl Francis Philip Amoy
                                    </h3>
                                    <div class="flex space-x-2">
                                        <button class="w-8 h-8 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                        </button>
                                        <button class="w-8 h-8 relative overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete" class="w-5 h-5">
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <p class="text-neutral-500">ID</p>
                                        <p class="font-poppins">P-Mar-2025-01</p>
                                    </div>
                                    <div>
                                        <p class="text-neutral-500">Last Visit</p>
                                        <p class="font-poppins">March 27, 2025</p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <br>

                <!-- Pagination -->
                <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-600 mb-3 sm:mb-0">Showing 1 to 8 of 36 results</div>
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
    </div>
    </div>

    @include('patients record/modal/add modal/add_patient')
    @include('patients record/modal/edit modal/edit_patient_details')

@endsection

@php
    $activePage = 'patientsRecord'; // Set the active page for this specific view
@endphp