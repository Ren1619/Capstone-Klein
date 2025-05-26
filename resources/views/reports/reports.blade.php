@extends('layouts.app')

@section('title', 'Reports')
@section('header', 'Reports')

@section('content')
    <!-- Sales Dashboard Structure with Side-by-Side Reports -->
    <div class="w-full bg-neutral-100 p-3 md:p-5">
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
                    <p class="text-2xl font-medium" id="total-sales-amount">₱0</p>
                </div>
                <div class="w-48 h-24 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-500 text-sm">Total Transactions</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <p class="text-2xl font-medium" id="total-transactions">0</p>
                </div>
                <div class="w-48 h-24 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-500 text-sm">Active Branches</h3>
                        <div class="w-6 h-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-medium" id="active-branches">3</p>
                </div>
                <div class="w-48 h-24 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-500 text-sm">Average Sale</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <p class="text-2xl font-medium" id="average-sale">₱0</p>
                </div>
            </div>

            <!-- Period Selector -->
            <div class="mb-4">
                <div class="flex gap-2">
                    <select id="period-selector" class="border border-gray-300 rounded-md px-3 py-2">
                        <option value="month">This Month</option>
                        <option value="week">This Week</option>
                        <option value="today">Today</option>
                        <option value="year">This Year</option>
                    </select>
                    <button id="refresh-data" class="px-4 py-2 bg-[#F91D7C] text-white rounded-md hover:bg-[#D91A60]">
                        Refresh Data
                    </button>
                </div>
            </div>

            <!-- Combined Overall Sales Reports -->
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-black">Overall Sales Reports</h2>
                </div>

                <!-- Side-by-side reports -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Daily Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-normal">Daily Report</h3>
                            <div class="text-sm text-gray-500" id="daily-total">₱0</div>
                        </div>
                        <div class="h-56">
                            <canvas id="daily-chart"></canvas>
                        </div>
                    </div>

                    <!-- Weekly Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-normal">Weekly Report</h3>
                            <div class="text-sm text-gray-500" id="weekly-total">₱0</div>
                        </div>
                        <div class="h-56">
                            <canvas id="weekly-chart"></canvas>
                        </div>
                    </div>

                    <!-- Monthly Report -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-normal">Monthly Report</h3>
                            <div class="text-sm text-gray-500" id="monthly-total">₱0</div>
                        </div>
                        <div class="h-56">
                            <canvas id="monthly-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Comparison Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-normal">Branch Comparison</h3>
                    <select id="branch-comparison-period" class="border border-gray-300 rounded-md px-3 py-2">
                        <option value="month">This Month</option>
                        <option value="week">This Week</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
                <div class="h-64">
                    <canvas id="branch-chart"></canvas>
                </div>
            </div>

            <!-- Navigation Tabs for Branches -->
            <div class="mb-1">
                <h2 class="text-xl font-semibold text-black">Branch Sales</h2>
            </div>
            @include('reports/branch_sales')

        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#F91D7C] mr-3"></div>
                <span>Loading data...</span>
            </div>
        </div>
    </div>
@endsection

@php
    $activePage = 'reports';
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Global chart instances
    let dailyChart, weeklyChart, monthlyChart, branchChart;

    // Initialize when document is loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize all components
        initializeCharts();
        loadOverviewData();
        loadAllChartData();

        // Event listeners
        document.getElementById('period-selector').addEventListener('change', function () {
            loadOverviewData();
        });

        document.getElementById('branch-comparison-period').addEventListener('change', function () {
            loadBranchComparison();
        });

        document.getElementById('refresh-data').addEventListener('click', function () {
            loadOverviewData();
            loadAllChartData();
        });
    });

    // Show/hide loading overlay
    function showLoading() {
        document.getElementById('loading-overlay').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('loading-overlay').classList.add('hidden');
    }

    // Format currency
    function formatCurrency(amount) {
        return '₱' + parseFloat(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Load overview statistics
    async function loadOverviewData() {
        const period = document.getElementById('period-selector').value;

        try {
            const response = await fetch(`/api/sales/reports/overview?period=${period}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Update overview cards
            document.getElementById('total-sales-amount').textContent = formatCurrency(data.total_sales || 0);
            document.getElementById('total-transactions').textContent = (data.total_count || 0).toLocaleString();
            document.getElementById('active-branches').textContent = data.active_branches || 3;
            document.getElementById('average-sale').textContent = formatCurrency(data.average_sale || 0);
        } catch (error) {
            console.error('Error loading overview data:', error);
            // Set default values on error
            document.getElementById('total-sales-amount').textContent = formatCurrency(0);
            document.getElementById('total-transactions').textContent = '0';
            document.getElementById('active-branches').textContent = '3';
            document.getElementById('average-sale').textContent = formatCurrency(0);
        }
    }

    // Initialize chart instances
    function initializeCharts() {
        // Daily Chart
        const dailyCtx = document.getElementById('daily-chart').getContext('2d');
        dailyChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Daily Sales',
                    data: [],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: getChartOptions('currency')
        });

        // Weekly Chart
        const weeklyCtx = document.getElementById('weekly-chart').getContext('2d');
        weeklyChart = new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Weekly Sales',
                    data: [],
                    backgroundColor: 'rgba(16, 185, 129, 0.7)'
                }]
            },
            options: getChartOptions('currency')
        });

        // Monthly Chart
        const monthlyCtx = document.getElementById('monthly-chart').getContext('2d');
        monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [],
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: getChartOptions('currency')
        });

        // Branch Chart
        const branchCtx = document.getElementById('branch-chart').getContext('2d');
        branchChart = new Chart(branchCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Sales by Branch',
                    data: [],
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)'
                    ]
                }]
            },
            options: getChartOptions('currency')
        });
    }

    // Get chart options
    function getChartOptions(type) {
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        if (type === 'currency') {
            options.scales.y.ticks = {
                callback: function (value) {
                    return formatCurrency(value);
                }
            };

            // Also add tooltip formatting
            options.plugins.tooltip = {
                callbacks: {
                    label: function (context) {
                        return formatCurrency(context.raw);
                    }
                }
            };
        }

        return options;
    }

    // Load all chart data
    async function loadAllChartData() {
        showLoading();
        try {
            await Promise.all([
                loadChartData('daily'),
                loadChartData('weekly'),
                loadChartData('monthly'),
                loadBranchComparison()
            ]);
        } catch (error) {
            console.error('Error loading chart data:', error);
        } finally {
            hideLoading();
        }
    }

    // Load chart data for specific period
    async function loadChartData(period) {
        try {
            const response = await fetch(`/api/sales/reports/chart-data?period=${period}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            if (!data || !Array.isArray(data)) {
                console.error(`Invalid data format for ${period}:`, data);
                return;
            }

            const labels = data.map(item => item.label || '');
            const values = data.map(item => parseFloat(item.total || 0));
            const total = values.reduce((a, b) => a + b, 0);

            // Update total display
            const totalElement = document.getElementById(`${period}-total`);
            if (totalElement) {
                totalElement.textContent = formatCurrency(total);
            }

            // Update chart based on period
            switch (period) {
                case 'daily':
                    if (dailyChart) {
                        dailyChart.data.labels = labels;
                        dailyChart.data.datasets[0].data = values;
                        dailyChart.update();
                    }
                    break;
                case 'weekly':
                    if (weeklyChart) {
                        weeklyChart.data.labels = labels;
                        weeklyChart.data.datasets[0].data = values;
                        weeklyChart.update();
                    }
                    break;
                case 'monthly':
                    if (monthlyChart) {
                        monthlyChart.data.labels = labels;
                        monthlyChart.data.datasets[0].data = values;
                        monthlyChart.update();
                    }
                    break;
            }
        } catch (error) {
            console.error(`Error loading ${period} chart data:`, error);
            // Set default empty data on error
            const totalElement = document.getElementById(`${period}-total`);
            if (totalElement) {
                totalElement.textContent = formatCurrency(0);
            }
        }
    }

    // Load branch comparison data
    async function loadBranchComparison() {
        const period = document.getElementById('branch-comparison-period').value;

        try {
            const response = await fetch(`/api/sales/reports/branch-comparison?period=${period}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            if (!data || !Array.isArray(data)) {
                console.error('Invalid branch comparison data:', data);
                return;
            }

            const labels = data.map(item => item.label || '');
            const values = data.map(item => parseFloat(item.total || 0));

            if (branchChart) {
                branchChart.data.labels = labels;
                branchChart.data.datasets[0].data = values;
                branchChart.update();
            }
        } catch (error) {
            console.error('Error loading branch comparison data:', error);
            // Set default empty data on error
            if (branchChart) {
                branchChart.data.labels = ['Valencia Branch', 'Malaybalay Branch', 'Maramag Branch'];
                branchChart.data.datasets[0].data = [0, 0, 0];
                branchChart.update();
            }
        }
    }

    // Make functions globally available for branch sales
    window.formatCurrency = formatCurrency;
    window.showLoading = showLoading;
    window.hideLoading = hideLoading;
</script>