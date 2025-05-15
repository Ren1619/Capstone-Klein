@extends('layouts.app')

@section('title', 'Reports')
@section('header', 'Reports')

@section('content')




    <!-- Sales Dashboard Structure with Side-by-Side Reports -->
    <div class=" w-full bg-neutral-100 p-3 md:p-5">
        <div class="flex flex-col w-full gap-4 md:gap-7">


            <!-- Overview Cards -->
            <div class="flex gap-4 mb-6">
                <div class="w-48 h-24 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-500 text-sm">Total Sales</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-medium">₱600,000</p>
                </div>
                <div class="w-48 h-24 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-500 text-sm">Branches</h3>
                        <div class="w-6 h-6">
                            <img src="{{ asset('icons/branch_icon.svg') }}" alt="Branch">
                        </div>
                    </div>
                    <p class="text-2xl font-medium">3</p>
                </div>
            </div>

            <!-- Combined Overall Sales Reports -->
            <div class="mb-8">
                <!-- <h2 class="text-xl font-semibold text-black mb-4">Overall Sales Reports</h2> -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-black">Overall Sales Reports</h2>
                </div>

                <!-- Side-by-side reports -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Daily Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-normal mb-3">Daily Report</h3>
                        <div class="h-56">
                            <canvas class="daily-chart"></canvas>
                        </div>
                    </div>

                    <!-- Weekly Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-normal mb-3">Weekly Report</h3>
                        <div class="h-56">
                            <canvas class="weekly-chart"></canvas>
                        </div>
                    </div>

                    <!-- Monthly Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-normal mb-3">Monthly Report</h3>
                        <div class="h-56">
                            <canvas class="monthly-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Comparison Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-normal mb-4">Branch Comparison</h3>
                <div class="h-64">
                    <canvas class="branch-chart"></canvas>
                </div>
            </div>

            <!-- Navigation Tabs for Branches -->
            <div class="mb-1">
                <h2 class="text-xl font-semibold text-black">Branch Sales</h2>
            </div>
            @include('reports/branch_sales')




        </div>
    </div>






@endsection

@php
    $activePage = 'reports';
@endphp

<script>
    // Initialize charts when document is loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Function to initialize charts based on class and configuration
        function initializeChart(chartClass, config) {
            const chartElements = document.getElementsByClassName(chartClass);

            for (let i = 0; i < chartElements.length; i++) {
                const ctx = chartElements[i].getContext('2d');
                new Chart(ctx, config);
            }
        }

        // Daily Sales Chart Configuration
        const dailyChartConfig = {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Daily Sales',
                    data: [4200, 3800, 5100, 5800, 4700, 6200, 5500],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        };

        // Weekly Sales Chart Configuration
        const weeklyChartConfig = {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Weekly Sales',
                    data: [28000, 32000, 34000, 38000],
                    backgroundColor: 'rgba(16, 185, 129, 0.7)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        };

        // Monthly Sales Chart Configuration
        const monthlyChartConfig = {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [120000, 130000, 145000, 160000, 153000, 168000],
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        };

        // Branch Comparison Chart Configuration
        const branchChartConfig = {
            type: 'bar',
            data: {
                labels: ['Valencia Branch', 'Malaybalay Branch', 'Maramag Branch'],
                datasets: [{
                    label: 'Total Sales by Branch',
                    data: [160000, 140000, 120000],
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        };

        // Initialize charts
        initializeChart('daily-chart', dailyChartConfig);
        initializeChart('weekly-chart', weeklyChartConfig);
        initializeChart('monthly-chart', monthlyChartConfig);
        initializeChart('branch-chart', branchChartConfig);
    });
</script>