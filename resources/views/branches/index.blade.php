@extends('layouts.app')

@section('title', 'Branches')
@section('header', 'Branches')

@section('content')
    <div class="min-h-full bg-neutral-100 p-2 sm:p-5 flex flex-col">
        <div class="flex-1 flex flex-col gap-3 sm:gap-5">
            <!-- Search and Action Bar -->
            <div
                class="bg-white rounded-lg p-3 sm:px-7 sm:py-3.5 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="w-full sm:w-64 px-2.5 py-1.5 rounded-md border border-neutral-200 flex items-center">
                    <img src="{{ asset('icons/search_icon.svg') }}" alt="Search Icon">
                    <input type="text" id="clinicSearchInput" class="flex-1 bg-transparent outline-none text-sm ml-2"
                        placeholder="Search Clinic...">
                </div>
                <div class="w-full sm:w-auto flex justify-end">
                    <button id="openModalBtn" onclick="openClinicModalDirect()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] hover:bg-[#F91D7C]/90 rounded-md flex items-center gap-2 text-white text-sm font-semibold">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Icon">
                        <span>Branch</span>
                    </button>
                </div>
            </div>

            <!-- Alert for success message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table/Card Content -->
            <div class="flex-1 flex flex-col gap-3 sm:gap-5">
                <!-- Desktop Table View (hidden on mobile) -->
                <div class="hidden sm:block bg-white rounded-lg p-3 sm:px-7 sm:py-3.5">
                    <div class="overflow-x-auto">
                        <div class="min-w-full">
                            <!-- Table Header -->
                            <div class="grid grid-cols-12 gap-2 text-neutral-500 text-sm py-2 border-b border-neutral-200">
                                <div class="col-span-3">Branch</div>
                                <div class="col-span-5">Address</div>
                                <div class="col-span-2">Contact</div>
                                <div class="col-span-1 text-center">Status</div>
                                <div class="col-span-1 text-center">Action</div>
                            </div>

                            <!-- Table Rows -->
                            <div class="flex flex-col">
                                @forelse($branches as $index => $branch)
                                    <div
                                        class="grid grid-cols-12 gap-2 text-black text-sm py-3 border-b border-neutral-200 items-center">
                                        <div class="col-span-3 flex items-center gap-2">
                                            <div
                                                class="w-12 h-12 rounded-md border border-neutral-200 flex justify-center items-center">
                                                <img src="{{ asset('icons/branch_icon.svg') }}" alt="Branch Icon">
                                            </div>
                                            <span class="truncate">{{ $branch->name }}</span>
                                        </div>
                                        <div class="col-span-5 truncate">{{ $branch->address }}</div>
                                        <div class="col-span-2">{{ $branch->contact }}</div>
                                        <div class="col-span-1 flex justify-center">
                                            <div
                                                class="px-2 py-1 {{ $branch->status == 'active' ? 'bg-green-500/30' : 'bg-red-500/30' }} rounded-md text-center">
                                                <span
                                                    class="{{ $branch->status == 'active' ? 'text-green-700' : 'text-red-700' }} text-xs">{{ $branch->status }}</span>
                                            </div>
                                        </div>
                                        <div class="col-span-1 flex justify-center items-center gap-2">
                                            <button type="button" onclick="openClinicModal('{{ $branch->branch_ID }}')"
                                                class="text-green-600 hover:text-green-800">
                                                <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit Branch">
                                            </button>
                                            <form action="{{ route('branches.destroy', $branch->branch_ID) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete Branch">
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-4 text-center text-gray-500">No branches found.</div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            @if($branches instanceof \Illuminate\Pagination\LengthAwarePaginator && $branches->count() > 0)
                                <div
                                    class="flex flex-col sm:flex-row justify-between items-center py-4 border-t border-neutral-200 mt-2">
                                    <div class="text-black text-sm mb-3 sm:mb-0">
                                        Showing {{ $branches->firstItem() ?? 0 }} to {{ $branches->lastItem() ?? 0 }} of
                                        {{ $branches->total() ?? 0 }} results
                                    </div>
                                    <div class="flex items-center gap-2">
                                        {{ $branches->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View (visible only on mobile) -->
                <div class="sm:hidden flex flex-col gap-3">
                    @forelse($branches as $index => $branch)
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center">
                                    <span class="text-gray-600 mr-2">{{ $loop->iteration }}.</span>
                                    <span class="font-medium">{{ $branch->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="openClinicModal('{{ $branch->branch_ID }}')"
                                        class="text-green-600 hover:text-green-800">
                                        <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                    </button>
                                    <form action="{{ route('branches.destroy', $branch->branch_ID) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete" class="w-5 h-5">
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-sm">
                                <div class="text-gray-500">Address</div>
                                <div>{{ $branch->address }}</div>

                                <div class="text-gray-500">Contact</div>
                                <div>{{ $branch->contact }}</div>

                                <div class="text-gray-500">Status</div>
                                <div>
                                    <div
                                        class="inline-block px-2 py-1 {{ $branch->status == 'active' ? 'bg-green-500/30' : 'bg-red-500/30' }} rounded-md">
                                        <span
                                            class="{{ $branch->status == 'active' ? 'text-green-700' : 'text-red-700' }} text-xs">{{ $branch->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg p-4 shadow-sm text-center text-gray-500">
                            No branches found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('branches.modal.add_clinic')
@endsection

@php
    $activePage = 'branches'; // Set the active page for this specific view
@endphp