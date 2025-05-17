@extends('layouts.app')

@section('title', 'Patient Records')
@section('header', 'Patient Records')

@section('content')
    <div class="w-full bg-neutral-100 p-3 md:p-5">
        <div class="flex flex-col w-full gap-4 md:gap-7">
            <!-- Flash Messages -->
            <!-- @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif -->

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Header Section -->
            <div
                class="w-full bg-white rounded-lg p-2 sm:p-3 md:px-7 md:py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
                <!-- Search bar -->
                <form method="GET" action="{{ route('patients.index') }}" class="w-full sm:w-52 relative">
                    <input type="text" name="search" placeholder="Search Patients..." value="{{ $search ?? '' }}"
                        class="w-full h-9 px-2.5 py-1.5 pl-9 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-normal leading-none tracking-tight focus:outline-[#F91D7C] focus:outline-0.5" />
                    <div class="absolute left-2.5 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="hidden" name="time_filter" value="{{ $timeFilter ?? 'all_time' }}">
                </form>

                <!-- Dropdown and button  -->
                <div class="flex flex-row items-center justify-between gap-2 sm:gap-5 w-full sm:w-auto mt-2 sm:mt-0">
                    <!-- Dropdown -->
                    <div class="relative inline-block w-1/2 sm:w-32">
                        <div class="relative">
                            <form id="timeFilterForm" method="GET" action="{{ route('patients.index') }}">
                                <select id="timeFilter" name="time_filter" onchange="this.form.submit()"
                                    class="w-full h-9 px-2 sm:px-2.5 py-1.5 pr-6 sm:pr-8 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-semibold appearance-none focus:outline-[#F91D7C] focus:outline-2 truncate bg-transparent">
                                    <option value="all_time" {{ ($timeFilter ?? '') == 'all_time' ? 'selected' : '' }}>All
                                        Time</option>
                                    <option value="this_week" {{ ($timeFilter ?? '') == 'this_week' ? 'selected' : '' }}>This
                                        Week</option>
                                    <option value="this_month" {{ ($timeFilter ?? '') == 'this_month' ? 'selected' : '' }}>
                                        This Month</option>
                                    <option value="last_3_months" {{ ($timeFilter ?? '') == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                    <option value="last_year" {{ ($timeFilter ?? '') == 'last_year' ? 'selected' : '' }}>Last
                                        Year</option>
                                </select>
                                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                            </form>
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
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal whitespace-nowrap px-2"
                                    style="width: 40%;">
                                    <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                    Patients Name
                                </th>
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal whitespace-nowrap px-2"
                                    style="width: 25%;">
                                    ID
                                </th>
                                <th class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal whitespace-nowrap px-2"
                                    style="width: 20%;">
                                    Last Visit
                                </th>
                                <th class="pb-3 pt-3 text-right text-neutral-500 text-sm md:text-base font-normal whitespace-nowrap px-2"
                                    style="width: 15%;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $index => $patient)
                                <tr class="border-b border-neutral-200 hover:bg-[#F91D7C]/5"
                                    onclick="window.location.href='{{ route('patients.show', $patient->PID) }}';"
                                    style="cursor: pointer;">
                                    <td class="py-3 text-black text-sm md:text-base font-normal px-2">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-block mr-2 text-neutral-500 shrink-0">{{ $patients->firstItem() + $index }}.</span>
                                            <span class="truncate">{{ $patient->full_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-black text-sm md:text-base font-normal truncate px-2">
                                        {{ $patient->PID }}
                                    </td>
                                    <!-- <td class="py-3 text-black text-sm md:text-base font-normal truncate px-2">
                                                       @if($patient->visitHistory->isNotEmpty())
                                                        {{ $patient->visitHistory->first()->timestamp->format('F d, Y') }}
                                                        @else
                                                            No visits
                                                        @endif
                                                    </td> -->
                                    <!-- For desktop view - Update the Last Visit column -->
                                    <td class="py-3 text-black text-sm md:text-base font-normal truncate px-2">
                                        @if($patient->visitHistory->isNotEmpty())
                                            {{ $patient->visitHistory->last()->timestamp->format('F d, Y') }}
                                        @else
                                            <span class="text-gray-500">No Visit</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2">
                                        <div class="flex justify-end items-center gap-2 md:gap-3.5">
                                            <!-- edit button -->
                                            <button
                                                class="w-10 h-10 relative overflow-hidden flex items-center justify-center edit-patient-btn"
                                                data-pid="{{ $patient->PID }}" onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit">
                                            </button>
                                            <!-- delete button -->
                                            <button
                                                class="w-10 h-10 relative overflow-hidden flex items-center justify-center delete-patient-btn"
                                                data-pid="{{ $patient->PID }}" onclick="event.stopPropagation();">
                                                <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-5 text-center text-gray-500">No patients found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Cards for mobile/tablet -->
                <div class="md:hidden">
                    <div class="space-y-4">
                        @forelse($patients as $index => $patient)
                            <div class="border border-neutral-200 rounded-lg p-4 hover:bg-[#F91D7C]/10"
                                onclick="window.location.href='{{ route('patients.show', $patient->PID) }}';"
                                style="cursor: pointer;">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-medium font-poppins">
                                        <span
                                            class="inline-block mr-2 text-neutral-500">{{ $patients->firstItem() + $index }}.</span>
                                        {{ $patient->full_name }}
                                    </h3>
                                    <div class="flex space-x-2">
                                        <button
                                            class="w-8 h-8 relative overflow-hidden flex items-center justify-center edit-patient-btn"
                                            data-pid="{{ $patient->PID }}" onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                        </button>
                                        <!-- delete -->
                                        <button
                                            class="w-8 h-8 relative overflow-hidden flex items-center justify-center delete-patient-btn"
                                            data-pid="{{ $patient->PID }}" onclick="event.stopPropagation();">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete" class="w-5 h-5">
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-neutral-500">Last Visit</p>
                                    <p class="font-poppins">
                                        @if($patient->visitHistory->isNotEmpty())
                                            {{ $patient->visitHistory->last()->timestamp->format('F d, Y') }}
                                        @else
                                            <span class="text-gray-500">No Visit</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">No patients found</div>
                        @endforelse
                    </div>
                </div>

                <br>

                <!-- Pagination -->
                <!-- <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                                    <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                                        Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} results
                                    </div>
                                    <div class="flex space-x-1">
                                        {{ $patients->appends(['search' => $search ?? '', 'time_filter' => $timeFilter ?? 'all_time'])->links() }}
                                    </div>
                                </div> -->

                <!-- Pagination -->
                @if($patients->total() > $patients->perPage())
                    <div class="w-full px-4 sm:px-6 pb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                            Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of
                            {{ $patients->total() }} results
                        </div>
                        <div class="flex space-x-1">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                                <!-- Previous Page Link -->
                                @if($patients->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $patients->previousPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
                                        rel="prev"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        Previous
                                    </a>
                                @endif

                                <!-- Pagination Elements -->
                                @for ($i = 1; $i <= $patients->lastPage(); $i++)
                                    <!-- "Three Dots" Separator -->
                                    @if ($i == $patients->currentPage())
                                        <span aria-current="page"
                                            class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-white bg-[#F91D7C] border border-[#F91D7C] cursor-default leading-5 rounded-md">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <a href="{{ $patients->url($i) }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
                                            class="relative inline-flex items-center px-4 py-2 mx-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endfor

                                <!-- Next Page Link -->
                                @if($patients->hasMorePages())
                                    <a href="{{ $patients->nextPageUrl() }}&search={{ $search ?? '' }}&time_filter={{ $timeFilter ?? 'all_time' }}"
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
        </div>
    </div>




    <!-- Deletion Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/70 transition-opacity" id="deleteModalOverlay"></div>
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10 text-center p-8">
                <!-- Exclamation Icon -->
                <div class="flex justify-center mb-6">
                    <!-- <div class="rounded-full border-4 border-pink-200 p-3 inline-flex">
                                <div class="text-4xl font-bold text-[#F91D7C]">!</div>
                            </div> -->
                    <img src="{{ asset('icons/pending.svg') }}" alt="Pending">
                </div>

                <!-- Text -->
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Are you sure?</h3>
                <p class="text-gray-600 mb-8">You won't be able to revert this!</p>

                <!-- Buttons -->
                <form id="deletePatientForm" method="POST" class="flex flex-col sm:flex-row gap-4 justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-[#F91D7C] text-white rounded-md font-medium hover:bg-[#e4196f] transition-colors w-full sm:w-auto">
                        Yes, delete it!
                    </button>
                    <button type="button" id="cancelDeleteBtn"
                        class="px-6 py-3 bg-gray-800 text-white rounded-md font-medium hover:bg-gray-700 transition-colors w-full sm:w-auto">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('patients record/modal/add modal/add_patient')
    @include('patients record/modal/edit modal/edit_patient_details')


@endsection





<!--  Delete button functionality for SweetAlert -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete patient functionality with SweetAlert
        const deleteButtons = document.querySelectorAll('.delete-patient-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const patientId = this.getAttribute('data-pid');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F91D7C',
                    cancelButtonColor: '#333',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/patients/${patientId}`;
                        form.style.display = 'none';
                        
                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);
                        
                        // Add method field for DELETE
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);
                        
                        // Append form to body, submit it, then remove it
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
        
        // Edit patient functionality
            const editButtons = document.querySelectorAll('.edit-patient-btn');

            editButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const patientId = this.getAttribute('data-pid');

                    // Fetch patient data via AJAX
                    fetch(`/patients/${patientId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate the edit form with patient data
                            document.getElementById('patientFirstName').value = data.first_name;
                            document.getElementById('patientMiddleName').value = data.middle_name || '';
                            document.getElementById('patientLastName').value = data.last_name;
                            document.getElementById('patientId').value = data.PID;
                            document.getElementById('patientSex').value = data.sex;
                            document.getElementById('patientAddress').value = data.address;
                            document.getElementById('patientContact').value = data.contact_number;
                            document.getElementById('patientDob').value = data.date_of_birth;
                            document.getElementById('patientCivilStatus').value = data.civil_status || 'Single';

                            // Update the form action
                            document.getElementById('patientForm').action = `/patients/${patientId}`;

                            // Update the form method (for Laravel PUT method)
                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'PUT';
                            document.getElementById('patientForm').appendChild(methodField);

                            // Add CSRF token
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            document.getElementById('patientForm').appendChild(csrfToken);

                            // Show the edit modal
                            document.getElementById('editPatientModal').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        })
                        .catch(error => {
                            console.error('Error fetching patient data:', error);
                            // alert('Failed to load patient data. Please try again.');
                        });
                });
            });
        
        // Flash message using SweetAlert instead of auto-close
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#F91D7C'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#F91D7C'
            });
        @endif
    });
</script>


@php
    $activePage = 'patientsRecord'; // Set the active page for this specific view
@endphp