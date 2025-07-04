@extends('layouts.app')

@section('title', 'Feedback')
@section('header', 'Feedback')

@section('content')
    <div class="w-full bg-neutral-100 p-3 md:p-5">
        <div class="flex flex-col w-full gap-4 md:gap-7">
            <!-- Summary Rating Cards Section -->
            <div class="flex gap-4">
                <!-- Weekly Average Card -->
                <div class="w-48 h-24 bg-white rounded-lg p-3 shadow-sm hover:bg-[#F91D7C]/10 transition-colors">
                    <h3 class="text-neutral-500 text-sm font-medium mb-2">Weekly Average</h3>
                    <div class="flex items-center">
                        <span class="text-2xl font-medium mr-3">{{ number_format($weeklyAverage, 1) }}</span>
                        <div class="flex gap-1">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($weeklyAverage))
                                    <svg class="w-5 h-5 text-[#F91D7C]" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif ($i < $weeklyAverage)
                                    <svg class="w-5 h-5 text-[#F91D7C] opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Monthly Average Card -->
                <div class="w-48 h-24 bg-white rounded-lg p-3 shadow-sm hover:bg-[#F91D7C]/10 transition-colors">
                    <h3 class="text-neutral-500 text-sm font-medium mb-2">Monthly Average</h3>
                    <div class="flex items-center">
                        <span class="text-2xl font-medium mr-3">{{ number_format($monthlyAverage, 1) }}</span>
                        <div class="flex gap-1">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($monthlyAverage))
                                    <svg class="w-5 h-5 text-[#F91D7C]" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif ($i < $monthlyAverage)
                                    <svg class="w-5 h-5 text-[#F91D7C] opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Table Section -->
            <div class="w-full bg-white rounded-lg p-3 md:px-7 md:py-3.5 flex flex-col">
                <table class="w-full feedback-table">
                    <!-- Table Header -->
                    <thead>
                        <tr class="border-b border-neutral-200">
                            <th class="text-left pb-3 text-neutral-500 text-base font-normal">Appointment Code</th>
                            <th class="text-center pb-3 text-neutral-500 text-base font-normal">Rating</th>
                            <th class="text-left pb-3 text-neutral-500 text-base font-normal">Date</th>
                        </tr>
                    </thead>

                    <!-- Table Rows -->
                    <tbody>
                        @forelse($feedbacks as $feedback)
                            <tr class="border-b border-neutral-200 hover:bg-[#F91D7C]/10 cursor-pointer transition-all"
                                data-feedback-id="{{ $feedback->feedback_ID }}">
                                <td class="py-3 text-black text-base font-normal">APP-{{ $feedback->appointment_ID }}</td>
                                <td class="py-3">
                                    <div class="flex justify-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $feedback->rating)
                                                <svg class="w-5 h-5 text-[#F91D7C]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-3 text-black text-base font-normal flex justify-between items-center">
                                    {{ $feedback->created_at->format('F d, Y') }}
                                    <span class="text-[#F91D7C] flex items-center view-indicator">
                                        <span class="mr-1">View</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="3" class="py-5 text-center text-gray-500">No feedbacks found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center pt-4">
                    <div class="text-sm text-gray-600">
                        Showing {{ $feedbacks->firstItem() ?? 0 }} to {{ $feedbacks->lastItem() ?? 0 }} of
                        {{ $feedbacks->total() ?? 0 }} results
                    </div>
                    <div class="pagination-container">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the Feedback Modal -->
    @include('feedbacks.modals.feedback-modal')

    <!-- JavaScript for Feedback Table -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all feedback table rows (excluding empty state row)
            const feedbackRows = document.querySelectorAll('.feedback-table tbody tr:not(.empty-row)');

            // Add click event listeners to each row
            feedbackRows.forEach(row => {
                row.addEventListener('click', function () {
                    // Get the feedback ID from data attribute
                    const feedbackId = this.dataset.feedbackId;

                    if (feedbackId) {
                        // Add visual feedback on click
                        this.classList.add('bg-[#F91D7C]/20');

                        // Remove highlight after a short delay
                        setTimeout(() => {
                            this.classList.remove('bg-[#F91D7C]/20');
                        }, 300);

                        // Open the feedback modal with the feedback ID
                        if (window.feedbackFunctions && typeof window.feedbackFunctions.open === 'function') {
                            window.feedbackFunctions.open(feedbackId);
                        } else {
                            console.error('Feedback functions not available. Make sure feedback-modal.blade.php is included.');
                        }
                    }
                });

                // Add keyboard accessibility
                row.addEventListener('keydown', function (e) {
                    // Trigger click on Enter or Space
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });

                // Make rows focusable for keyboard navigation
                row.setAttribute('tabindex', '0');

                // Add hover effect indication on view button
                row.addEventListener('mouseenter', function () {
                    const viewIndicator = this.querySelector('.view-indicator');
                    if (viewIndicator) {
                        viewIndicator.classList.add('font-medium');
                    }
                });

                row.addEventListener('mouseleave', function () {
                    const viewIndicator = this.querySelector('.view-indicator');
                    if (viewIndicator) {
                        viewIndicator.classList.remove('font-medium');
                    }
                });
            });
        });
    </script>
@endsection

@php
    $activePage = 'feedbacks';
@endphp