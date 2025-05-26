@extends('layouts.app')

@section('title', 'Patient Records')
@section('header', 'Patient Visit')

@section('content')
    <div class="w-full bg-neutral-100 p-3 md:p-5">
        <div class="bg-white p-3 md:p-5 rounded-lg">
            {{-- Top navigation area --}}
            <div class="flex justify-between items-center w-full mb-4">
                {{-- Back button --}}
                 <button type="button" onclick="window.history.back()"
                    class="text-gray-800 p-3.5 flex items-center gap-3.5 hover:bg-pink-600/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                
            </div>

            {{-- Tab navigation --}}
            {{-- <div class="mb-8"> --}}
                @include('patients record/patient_visit_tab_navigation')
            {{-- </div> --}}


           
        </div>
    </div>
    </div>
@endsection

@php
    $activePage = 'patientsRecord'; // Set the active page for this specific view
@endphp


