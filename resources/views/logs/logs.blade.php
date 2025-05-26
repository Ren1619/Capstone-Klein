@extends('layouts.app')

@section('title', 'Logs')
@section('header', 'Logs')

@section('content')

    <div class="p-5">
        <div id="logs-tabs" class="mb-10">
            <!-- Header Section -->
            <div
                class="w-full bg-white rounded-lg p-2 sm:p-3 md:px-7 md:py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
                <div class="w-full sm:w-52 relative">
                    <input type="text" id="searchInput" placeholder="Search current page..."
                        class="w-full h-9 px-2.5 py-1.5 pl-9 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-normal leading-none tracking-tight focus:outline-[#F91D7C] focus:outline-0.5" />
                    <div class="absolute left-2.5 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Time Filter Dropdown -->
                <div class="flex flex-row items-center justify-between gap-2 sm:gap-5 w-full sm:w-auto mt-2 sm:mt-0">
                    <div class="relative inline-block w-1/2 sm:w-32">
                        <form method="GET" action="{{ route('logs.index') }}" id="timeFilterForm">
                            <input type="hidden" name="tab" value="{{ $currentTab }}">
                            <select id="timeFilter" name="time_filter"
                                onchange="document.getElementById('timeFilterForm').submit()"
                                class="w-full h-9 px-2 sm:px-2.5 py-1.5 pr-6 sm:pr-8 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-semibold appearance-none focus:outline-[#F91D7C] focus:outline-2 truncate bg-transparent">
                                <option value="all_time" {{ request('time_filter') == 'all_time' ? 'selected' : '' }}>All Time
                                </option>
                                <option value="this_week" {{ request('time_filter') == 'this_week' ? 'selected' : '' }}>This
                                    Week</option>
                                <option value="this_month" {{ request('time_filter') == 'this_month' ? 'selected' : '' }}>This
                                    Month</option>
                                <option value="last_3_months" {{ request('time_filter') == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                <option value="last_year" {{ request('time_filter') == 'last_year' ? 'selected' : '' }}>Last
                                    Year</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-1 sm:right-2 flex items-center">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="px-5 py-3 bg-white rounded-lg shadow min-h-[670px]">
            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <div class="relative">
                    <div class="flex px-2 overflow-x-auto scrollbar-hide" id="tabs-carousel">
                        @php
                            $tabs = [
                                'all' => 'All Logs',
                                'patients' => 'Patients',
                                'appointments' => 'Appointments',
                                'services' => 'Services',
                                'pos' => 'Point of Sales',
                                'inventory' => 'Inventory',
                                'clinic' => 'Clinic Management'
                            ];
                        @endphp

                        @foreach($tabs as $tabKey => $tabLabel)
                            <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer tab-btn flex-shrink-0 
                                            {{ $currentTab == $tabKey ? 'active' : 'hover:bg-[#F91D7C]/10' }}"
                                data-tab="{{ $tabKey }}">
                                <a href="{{ route('logs.index', array_merge(request()->all(), ['tab' => $tabKey, 'page' => 1])) }}"
                                    class="text-xs sm:text-sm whitespace-nowrap {{ $currentTab == $tabKey ? 'text-[#F91D7C]' : '' }}">
                                    {{ $tabLabel }}
                                </a>
                                @if($currentTab == $tabKey)
                                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Logs Content -->
            <div class="mt-4">
                @if($logs->count() > 0)
                    <!-- Desktop View Table -->
                    <div class="hidden md:block">
                        <table class="w-full min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        <span class="inline-block mr-2 text-neutral-500">#</span>Timestamp
                                    </th>
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        Person
                                    </th>
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        Branch
                                    </th>
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        Action
                                    </th>
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="log-table-body">
                                @foreach($logs as $index => $log)
                                    <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5 log-row">
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span
                                                class="inline-block mr-2 text-neutral-500">{{ ($logs->currentPage() - 1) * $logs->perPage() + $index + 1 }}.</span>
                                            <span class="font-normal">{{ $log->timestamp->format('Y-m-d H:i:s') }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">
                                                @if($log->account)
                                                    {{ $log->account->first_name }} {{ $log->account->last_name }}
                                                @else
                                                    System
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">
                                                @if($log->account && $log->account->branch)
                                                    {{ $log->account->branch->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log->actions }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log->descriptions }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View Cards -->
                    <div class="md:hidden">
                        @foreach($logs as $index => $log)
                            <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5 log-row">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-poppins">
                                        <span
                                            class="inline-block mr-2 text-neutral-500">{{ ($logs->currentPage() - 1) * $logs->perPage() + $index + 1 }}.</span>
                                        <span class="font-normal">{{ $log->timestamp->format('Y-m-d H:i:s') }}</span>
                                    </div>
                                </div>
                                <div class="mt-1 text-sm font-poppins">
                                    <span class="font-semibold">
                                        @if($log->account)
                                            {{ $log->account->first_name }} {{ $log->account->last_name }}
                                        @else
                                            System
                                        @endif
                                    </span>
                                    <span class="font-normal"> -
                                        @if($log->account && $log->account->branch)
                                            {{ $log->account->branch->name }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                                <div class="mt-1 text-sm font-poppins">
                                    <span class="font-semibold">{{ $log->actions }}:</span>
                                    <span class="font-normal">{{ $log->descriptions }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Simple Pagination -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-neutral-500 mb-2 sm:mb-0">
                            Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} entries
                        </div>

                        <!-- Laravel's built-in pagination -->
                        <div class="pagination-wrapper">
                            {{ $logs->links('custom.pagination') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 text-lg">No logs found.</p>
                            <p class="text-gray-400 text-sm mt-1">Try a different filter or check other categories.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Simple JavaScript for search only -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');

            // Simple search within current page
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const searchTerm = this.value.toLowerCase();
                    const logRows = document.querySelectorAll('.log-row');

                    logRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>

@endsection

@php
$activePage = 'logs';
@endphp