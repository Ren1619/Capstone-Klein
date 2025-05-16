@extends('layouts.app')

@section('title', 'Services')
@section('header', 'Services')

@section('content')
    <div class="p-5 bg-neutral-100 min-h-screen">
        <div class="flex flex-col gap-5">
            <!-- Search and Controls Bar -->
            <div
                class="h-auto sm:h-16 px-4 sm:px-7 py-3.5 bg-white rounded-lg flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0">
                <!-- Search Box -->
                <div class="w-full sm:w-52 px-2.5 py-1.5 rounded border border-gray-200 flex items-center gap-2">
                    <img src="{{ asset('icons/search_icon.svg') }}" alt="Search Icon">
                    <input type="text" id="serviceSearch" placeholder="Search Services..."
                        class="text-sm text-gray-500 focus:outline-none w-full">
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-5 mt-2 sm:mt-0">
                    <button type="button" onclick="openCategoryModal()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] rounded flex items-center gap-2 hover:bg-[#F91D7C]/90 transition-colors">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Category Icon">
                        <span class="text-white text-sm font-semibold">Category</span>
                    </button>

                    <button type="button" onclick="openServiceModal()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] rounded flex items-center gap-2 hover:bg-[#F91D7C]/90 transition-colors">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Service Icon">
                        <span class="text-white text-sm font-semibold">Service</span>
                    </button>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Services Table -->
            <div class="bg-white rounded-lg overflow-x-auto">
                <div class="px-7 py-3.5 min-w-max">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 text-gray-500 font-normal text-base w-[455px] min-w-[300px]">
                                    Services</th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base w-44 min-w-[150px]">Category
                                </th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base w-32 min-w-[100px]">Price</th>
                                <th class="text-center py-3 text-gray-500 font-normal text-base w-32 min-w-[100px]">Status
                                </th>
                                <th class="text-left py-3 text-gray-500 font-normal text-base w-24 min-w-[80px]">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr class="border-b border-gray-200">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3.5">
                                            <div
                                                class="w-12 h-12 bg-gray-200 rounded border border-gray-200 flex items-center justify-center">
                                                <img class="w-10 h-10 object-contain" src="{{ asset('images/service-placeholder.png') }}"
                                                    alt="{{ $service->name }}" />
                                            </div>
                                            <span class="text-black text-base">{{ $service->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-black text-base">{{ $service->category->category_name }}</td>
                                    <td class="py-4 text-black text-base">₱ {{ number_format($service->price, 2) }}</td>
                                    <td class="py-4 text-center">
                                        <span class="inline-block px-3 py-2 rounded text-sm {{ $service->status == 'active' ? 'bg-green-500/30 text-green-600' : 'bg-red-700/30 text-red-700' }}">
                                            {{ $service->status }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-3.5">
                                            <button type="button" onclick="editService('{{ $service->service_ID }}')"
                                                class="text-green-600 hover:text-green-700">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit Icon">
                                            </button>
                                            <form action="{{ route('services.destroy', $service->service_ID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700">
                                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete Icon">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No services found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-7 py-3.5 flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0">
                    <div class="text-black text-sm">
                        Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of {{ $services->total() ?? 0 }} results
                    </div>
                    <div class="flex items-center gap-2.5 mt-2 sm:mt-0">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('services.modals.add-modal')
    @include('services.modals.addServiceCategory')


    {{-- JavaScript for handling service actions --}}
    <script>
        function searchServices() {
            const searchQuery = document.getElementById('serviceSearch').value.toLowerCase();

            const rows = document.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const nameCell = row.querySelector('td:first-child span');

                if (nameCell) {
                    const serviceName = nameCell.textContent.trim().toLowerCase();

                    if (serviceName.includes(searchQuery)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Update results count
            const resultsCount = document.querySelector('.text-black.text-sm');
            if (resultsCount) {
                resultsCount.textContent = `Showing 1 to ${visibleCount} of ${visibleCount} results`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('serviceSearch');

            if (searchInput) {
                searchInput.addEventListener('input', searchServices);
            }
        });
    </script>
@endsection

@php
    $activePage = 'services'; // Set the active page for this specific view
@endphp