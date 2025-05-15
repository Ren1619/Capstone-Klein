@extends('layouts.app')

@section('title', 'Patient Records')
@section('header', 'Patient Visit')

@section('content')
    <div class="w-full bg-neutral-100 p-3 md:p-5">
        <div class="bg-white p-3 md:p-5 rounded-lg">
            <!-- Top navigation area -->
            <div class="flex justify-between items-center w-full mb-4">
                <!-- Back button -->
                <button class="text-gray-800">
                    <a href="{{ url('/patientsDetails') }}" class="p-3.5 flex items-center gap-3.5 hover:bg-pink-600/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </button>

                
            </div>

            <!-- Tab navigation -->
            <!-- <div class="mb-8"> -->
                @include('patients record/patient_visit_tab_navigation')
            <!-- </div> -->


            <!-- Pagination -->
            <div class="w-full px-4  flex flex-col sm:flex-row justify-between items-center">
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
    </div>
@endsection

@php
    $activePage = 'patientsRecord'; // Set the active page for this specific view
@endphp