@extends('layouts.app')

@section('title', 'Branches')
@section('header', 'Branches')

@section('content')
    <div class="min-h-full bg-neutral-100 p-2 sm:p-5 flex flex-col">
        <div class="flex-1 flex flex-col gap-3 sm:gap-5">
            <!-- Search and Action Bar -->
            <div
                class="bg-white rounded-lg p-3 sm:px-7 sm:py-3.5 flex flex-col sm:flex-row justify-between items-center gap-3">
                <form method="GET" action="{{ route('branches.index') }}" class="w-full sm:w-64">
                    <div class="px-2.5 py-1.5 rounded-md border border-neutral-200 flex items-center">
                        <img src="{{ asset('icons/search_icon.svg') }}" alt="Search Icon">
                        <input type="text" id="branchSearchInput" name="search" value="{{ request('search') }}"
                            class="flex-1 bg-transparent outline-none text-sm ml-2" placeholder="Search Branch...">
                    </div>
                </form>
                <div class="w-full sm:w-auto flex justify-end">
                    <button onclick="openBranchModalDirect()"
                        class="h-10 px-4 py-1 bg-[#F91D7C] hover:bg-[#F91D7C]/90 rounded-md flex items-center gap-2 text-white text-sm font-semibold">
                        <img src="{{ asset('icons/add_icon.svg') }}" alt="Add Icon">
                        <span>Branch</span>
                    </button>
                </div>
            </div>

            <!-- Table Content -->
            <div class="flex-1 flex flex-col gap-3 sm:gap-5">
                <!-- Desktop Table View -->
                <div class="hidden sm:block bg-white rounded-lg p-3 sm:px-7 sm:py-3.5">
                    <div class="overflow-x-auto">
                        @if($branches->count() > 0)
                            <table class="w-full">
                                <thead>
                                    <tr class="text-neutral-500 text-sm border-b border-neutral-200">
                                        <th class="text-left py-3 px-2 w-1/4">Branch</th>
                                        <th class="text-left py-3 px-2 w-1/3">Address</th>
                                        <th class="text-left py-3 px-2 w-1/6">Contact</th>
                                        <th class="text-center py-3 px-2 w-1/12">Status</th>
                                        <th class="text-center py-3 px-2 w-1/12">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($branches as $branch)
                                        <tr class="border-b border-neutral-200 hover:bg-gray-50">
                                            <td class="py-3 px-2">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-10 h-10 rounded-md border border-neutral-200 flex justify-center items-center">
                                                        <img src="{{ asset('icons/branch_icon.svg') }}" alt="Branch Icon"
                                                            class="w-6 h-6">
                                                    </div>
                                                    <span class="font-medium">{{ $branch->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-2 text-sm">{{ $branch->address }}</td>
                                            <td class="py-3 px-2 text-sm">{{ $branch->contact }}</td>
                                            <td class="py-3 px-2 text-center">
                                                <span
                                                    class="inline-block px-2 py-1 rounded-md text-xs font-medium
                                                                                    {{ $branch->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ ucfirst($branch->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-2">
                                                <div class="flex justify-center items-center gap-2">
                                                    <button onclick="openBranchModal('{{ $branch->branch_ID }}')"
                                                        class="text-green-600 hover:text-green-800 transition-colors"
                                                        title="Edit Branch">
                                                        <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                                    </button>
                                                    <form action="{{ route('branches.destroy', $branch->branch_ID) }}" method="POST"
                                                        class="inline" data-confirm-delete="{{ $branch->name }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors"
                                                            title="Delete Branch">
                                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete"
                                                                class="w-5 h-5">
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="py-12 text-center">
                                <p class="text-gray-500 mb-4">
                                    @if(request('search'))
                                        No branches found matching "{{ request('search') }}".
                                    @else
                                        No branches found.
                                    @endif
                                </p>
                                @if(request('search'))
                                    <a href="{{ route('branches.index') }}" class="text-blue-600 hover:underline">Clear search</a>
                                @else
                                    <button onclick="openBranchModalDirect()" class="text-blue-600 hover:underline">Add your first
                                        branch</button>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($branches instanceof \Illuminate\Pagination\LengthAwarePaginator && $branches->hasPages())
                        <div class="mt-4 pt-4 border-t border-neutral-200">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }} of
                                    {{ $branches->total() }} results
                                </div>
                                <div>
                                    {{ $branches->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Mobile Card View -->
                <div class="sm:hidden flex flex-col gap-3">
                    @forelse($branches as $branch)
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-medium text-lg">{{ $branch->name }}</h3>
                                    <span
                                        class="inline-block mt-1 px-2 py-1 rounded-md text-xs font-medium
                                                            {{ $branch->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($branch->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="openBranchModal('{{ $branch->branch_ID }}')"
                                        class="text-green-600 hover:text-green-800" title="Edit Branch">
                                        <img src="{{ asset('icons/edit_icon.svg') }}" alt="Edit" class="w-5 h-5">
                                    </button>
                                    <form action="{{ route('branches.destroy', $branch->branch_ID) }}" method="POST"
                                        class="inline" data-confirm-delete="{{ $branch->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Branch">
                                            <img src="{{ asset('icons/delete_icon.svg') }}" alt="Delete" class="w-5 h-5">
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Address:</span>
                                    <span class="ml-2">{{ $branch->address }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Contact:</span>
                                    <span class="ml-2">{{ $branch->contact }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Hours:</span>
                                    <span class="ml-2">{{ $branch->operating_hours_start }} -
                                        {{ $branch->operating_hours_end }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                            <p class="text-gray-500 mb-4">
                                @if(request('search'))
                                    No branches found matching "{{ request('search') }}".
                                @else
                                    No branches found.
                                @endif
                            </p>
                            @if(request('search'))
                                <a href="{{ route('branches.index') }}" class="text-blue-600 hover:underline">Clear search</a>
                            @else
                                <button onclick="openBranchModalDirect()" class="text-blue-600 hover:underline">Add your first
                                    branch</button>
                            @endif
                        </div>
                    @endforelse

                    <!-- Mobile Pagination -->
                    @if($branches instanceof \Illuminate\Pagination\LengthAwarePaginator && $branches->hasPages())
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-center text-sm text-gray-600 mb-3">
                                Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }} of {{ $branches->total() }}
                                results
                            </div>
                            <div class="flex justify-center">
                                {{ $branches->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Include the branch modal -->
    @include('branches.modal.add_clinic')

@endsection

@section('scripts')
    <script>
        // Initialize SweetAlert for delete confirmations
        document.addEventListener('DOMContentLoaded', function () {
            // Setup delete confirmations
            document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const branchName = this.getAttribute('data-confirm-delete');
                    const form = this;

                    confirmDelete(branchName, function () {
                        form.submit();
                    });
                });
            });
        });
    </script>
@endsection

@php
    $activePage = 'branches';
@endphp