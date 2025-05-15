@extends('layouts.app')

@section('title', 'Logs')
@section('header', 'Logs')

@section('content')

    <div class="p-5">
        <div id="logs-tabs" class="mb-10">
            <!-- Header Section -->
            <div
                class="w-full bg-white rounded-lg p-2 sm:p-3 md:px-7 md:py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
                <!-- Search bar -->
                <div class="w-full sm:w-52 relative">
                    <input type="text" placeholder="Search..."
                        class="w-full h-9 px-2.5 py-1.5 pl-9 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-normal leading-none tracking-tight focus:outline-[#F91D7C] focus:outline-0.5" />
                    <div class="absolute left-2.5 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Dropdown and button  -->
                <div class="flex flex-row items-center justify-between gap-2 sm:gap-5 w-full sm:w-auto mt-2 sm:mt-0">
                    <!-- Dropdown -->
                    <div class="relative inline-block w-1/2 sm:w-32">
                        <div class="relative">
                            <select id="timeFilter" name="time_filter"
                                class="w-full h-9 px-2 sm:px-2.5 py-1.5 pr-6 sm:pr-8 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-200 text-xs sm:text-sm font-semibold appearance-none focus:outline-[#F91D7C] focus:outline-2 truncate bg-transparent">
                                <option value="all_time">All Time</option>
                                <option value="this_week">This Week</option>
                                <option value="this_month">This Month</option>
                                <option value="last_3_months">Last 3 Months</option>
                                <option value="last_year">Last Year</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-1 sm:right-2 flex items-center">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content - With increased height -->
        <div class="px-5 py-3 bg-white rounded-lg shadow min-h-[670px]">
            @php
                // Common log data structure - Updated for derm clinic with same number of entries in each category
                $logCategories = [
                    'all' => [
                        ['timestamp' => '2025-04-24 10:30:21', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Updated patient record #1045 - Added skin sensitivity notes', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-24 10:15:12', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new appointment for Acne Treatment - Patient #1057', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-24 10:05:15', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new dermatological product: CeraVe Hydrating Cleanser', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-24 09:55:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Processed payment for service: Micro-needling Session - ₱3,500', 'ip' => '192.168.1.48'],
                        ['timestamp' => '2025-04-24 09:45:22', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Updated patient facial analysis photos', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-24 09:30:18', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new prescription: Tretinoin 0.025% for patient #1078', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-24 09:20:45', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Modified treatment plan for patient #1092 - Rosacea management', 'ip' => '192.168.1.48'],
                        ['timestamp' => '2025-04-24 09:10:33', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new package: 6 sessions laser hair removal - ₱15,000', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-24 08:55:12', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated clinic operating hours for Holy Week', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-24 08:45:05', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Registered new patient #1103 - Initial consultation for acne', 'ip' => '192.168.1.45']
                    ],
                    'patients' => [
                        ['timestamp' => '2025-04-24 10:30:21', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Updated patient record #1045 - Added skin sensitivity notes', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-24 09:45:22', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Updated patient facial analysis photos', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-24 09:20:45', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Modified treatment plan for patient #1092 - Rosacea management', 'ip' => '192.168.1.48'],
                        ['timestamp' => '2025-04-24 08:45:05', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Registered new patient #1103 - Initial consultation for acne', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 15:40:33', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new patient record #1102 - Eczema evaluation', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 13:25:18', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated patient #1087 allergies - Added hyaluronic acid', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 10:15:27', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Added progress photos to patient #1076 acne treatment', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 14:20:33', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated medical history for patient #1091 - Added new allergies', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 11:30:15', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Created new patient assessment form for melasma treatment', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 09:30:18', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Added before/after photos to patient #1045', 'ip' => '192.168.1.49']
                    ],
                    'appointments' => [
                        ['timestamp' => '2025-04-24 10:15:12', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new appointment for Acne Treatment - Patient #1057', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-24 08:30:22', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Rescheduled chemical peel appointment for patient #1072', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 16:25:33', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Booked laser therapy session for patient #1084', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 14:30:22', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Confirmed appointment #2088 for patient #1064 - IPL treatment', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-23 11:15:47', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Sent appointment reminder for tomorrow\'s sessions', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 09:20:15', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Scheduled follow-up consultation for patient #1079', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 15:40:52', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Rescheduled Hydrafacial appointment for patient #1058', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 13:55:23', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Created appointment for new patient consultation - #1098', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 09:10:45', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Canceled appointment #2079 for patient #1032 - Patient request', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-22 08:35:13', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Created follow-up appointment for patient #1090 - Post-treatment check', 'ip' => '192.168.1.45']
                    ],
                    'services' => [
                        ['timestamp' => '2025-04-24 09:10:33', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new package: 6 sessions laser hair removal - ₱15,000', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-24 08:45:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Added new service: Hydrafacial Premium - ₱4,500', 'ip' => '192.168.1.48'],
                        ['timestamp' => '2025-04-23 16:10:15', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated protocol for CO2 Fractional Laser treatment', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 13:20:15', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Updated service price: Teen Acne Treatment - ₱2,500', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 11:35:26', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Added service description to Microdermabrasion', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 09:25:42', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new service: Custom Facial for Sensitive Skin - ₱3,000', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 16:55:08', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Created new service package: Anti-aging Comprehensive Care - ₱25,000', 'ip' => '192.168.1.49'],
                        ['timestamp' => '2025-04-22 14:22:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Updated facial treatment descriptions and protocols', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 11:40:15', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Modified LED Light Therapy treatment duration - 30 minutes', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 09:15:22', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Added before/after photos to Micro-needling service page', 'ip' => '192.168.1.46']
                    ],
                    'pos' => [
                        ['timestamp' => '2025-04-24 09:55:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Processed payment for service: Micro-needling Session - ₱3,500', 'ip' => '192.168.1.48'],
                        ['timestamp' => '2025-04-24 08:20:26', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Applied 10% discount to invoice #3045 - Loyalty program', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 15:35:12', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Processed payment for product bundle: Acne Care Kit - ₱4,200', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 14:10:26', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Created invoice #3042 for patient #1064 - Multiple products', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 10:35:42', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Processed refund for cancelled appointment #2079', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 08:50:18', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Generated end-of-day sales report for April 22', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 16:25:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Processed payment for service package: Brightening Facial Series - ₱12,000', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 13:45:29', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Issued gift certificate #GC-2025-042 - ₱5,000', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 11:35:51', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Processed payment for product: COSRX AHA/BHA Toner - ₱1,250', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 09:22:15', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Created invoice #3039 for patient #1056 - Comprehensive facial', 'ip' => '192.168.1.45']
                    ],
                    'inventory' => [
                        ['timestamp' => '2025-04-24 10:05:15', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new dermatological product: CeraVe Hydrating Cleanser', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-24 09:30:18', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Added new prescription: Tretinoin 0.025% for patient #1078', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-24 08:15:33', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Updated inventory count after monthly audit', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 15:25:42', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated stock quantity for item #4023: Paula\'s Choice BHA Liquid', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 13:15:22', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Ordered restock of The Ordinary Niacinamide Serum - 30 units', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 10:40:15', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Received shipment of Avène products - 45 items', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 16:30:27', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new product category: Acne-specific cleansers', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 13:20:45', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Set low stock alerts for premium sunscreens', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 09:40:33', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Marked item #4019 as discontinued: Skinceuticals Blemish+Age serum', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 08:55:18', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Added new product line: Bioderma Sensibio collection', 'ip' => '192.168.1.47']
                    ],
                    'clinic' => [
                        ['timestamp' => '2025-04-24 08:55:12', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated clinic operating hours for Holy Week', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-24 08:30:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Updated treatment room assignment for aestheticians', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-24 08:10:26', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Generated daily appointment schedule', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-23 15:10:26', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Generated monthly clinic performance report', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-23 12:45:22', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Scheduled equipment maintenance for laser machines', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-23 10:30:15', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Updated patient consent forms for new treatments', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 16:20:15', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated clinic protocols for COVID-19 safety measures', 'ip' => '192.168.1.47'],
                        ['timestamp' => '2025-04-22 13:40:33', 'person' => 'Earl Francis Philip Amoy', 'branch' => 'Branch A - Valencia Branch', 'action' => 'Added new treatment room for microdermabrasion', 'ip' => '192.168.1.45'],
                        ['timestamp' => '2025-04-22 11:25:42', 'person' => 'Klein Allen', 'branch' => 'Branch B - Malaybalay Branch', 'action' => 'Submitted monthly supplies requisition form', 'ip' => '192.168.1.46'],
                        ['timestamp' => '2025-04-22 10:15:33', 'person' => 'Melbert A. Buligan', 'branch' => 'Branch C - Maramag Branch', 'action' => 'Updated contact information for Branch C', 'ip' => '192.168.1.47']
                    ]
                ];

                // Count data for pagination text
                $logCounts = [
                    'all' => 42,
                    'patients' => 18,
                    'appointments' => 15,
                    'services' => 12,
                    'pos' => 22,
                    'inventory' => 17,
                    'clinic' => 10
                ];

                // Tab titles for export buttons
                $tabTitles = [
                    'all' => 'All',
                    'patients' => 'Patients',
                    'appointments' => 'Appointments',
                    'services' => 'Services',
                    'pos' => 'POS',
                    'inventory' => 'Inventory',
                    'clinic' => 'Clinic'
                ];
            @endphp

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <div class="relative">
                    <!-- Tabs Container with Horizontal Scroll -->
                    <div class="flex px-2 overflow-x-auto scrollbar-hide" id="tabs-carousel">
                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer tab-btn active flex-shrink-0"
                            data-tab="all">
                            <button class="text-xs sm:text-sm text-[#F91D7C] whitespace-nowrap">All Logs</button>
                            <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]"></div>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="patients">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Patients Record</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="appointments">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Appointments</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="services">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Services</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="pos">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Point of Sales</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 mr-1 sm:mr-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="inventory">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Inventory</button>
                        </div>

                        <div class="relative px-3 sm:px-4 py-2 cursor-pointer hover:bg-[#F91D7C]/10 tab-btn flex-shrink-0"
                            data-tab="clinic">
                            <button class="text-xs sm:text-sm whitespace-nowrap">Clinic Management</button>
                        </div>
                    </div>

                    <!-- Left Arrow (hidden by default, shown when scrollable) -->
                    <button id="scroll-left"
                        class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Right Arrow (hidden by default, shown when scrollable) -->
                    <button id="scroll-right"
                        class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tab Contents -->
            @foreach($logCategories as $tabId => $logs)
                <div id="{{ $tabId }}-content" class="tab-content {{ $tabId !== 'all' ? 'hidden' : '' }}">
                    <!-- Desktop View Table -->
                    <div class="hidden md:block">
                        <table class="w-full min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th
                                        class="pb-3 pt-3 text-left text-neutral-500 text-sm md:text-base font-normal font-poppins whitespace-nowrap">
                                        <span class="inline-block mr-2 text-neutral-500">{{ '#' }}</span>
                                        Timestamp
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
                                        IP Address
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $index => $log)
                                    <tr class="border-b border-gray-200 hover:bg-[#F91D7C]/5">
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                            <span class="font-normal">{{ $log['timestamp'] }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log['person'] }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log['branch'] }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log['action'] }}</span>
                                        </td>
                                        <td class="py-3 text-black text-sm md:text-base font-normal font-poppins">
                                            <span class="font-normal">{{ $log['ip'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View Cards -->
                    <div class="md:hidden">
                        @foreach($logs as $index => $log)
                            <div class="border-b border-gray-200 py-3 hover:bg-[#F91D7C]/5">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-poppins">
                                        <span class="inline-block mr-2 text-neutral-500">{{ $index + 1 }}.</span>
                                        <span class="font-normal">{{ $log['timestamp'] }}</span>
                                    </div>
                                </div>
                                <div class="mt-1 text-sm font-poppins">
                                    <span class="font-semibold">{{ $log['person'] }}</span>
                                    <span class="font-normal"> - {{ $log['branch'] }}</span>
                                </div>
                                <div class="mt-1 text-sm font-poppins">
                                    <span class="font-normal">{{ $log['action'] }}</span>
                                </div>
                                <div class="mt-1 text-sm font-poppins text-neutral-500">
                                    <span class="font-normal">IP: {{ $log['ip'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-neutral-500 mb-2 sm:mb-0">
                            Showing 1 to {{ count($logs) }} of {{ $logCounts[$tabId] }} entries
                        </div>
                        <div class="flex items-center">
                            <button class="px-3 py-1 border border-gray-300 rounded-l-md hover:bg-[#F91D7C]/10">
                                Previous
                            </button>
                            <button class="px-3 py-1 border-t border-b border-gray-300 bg-[#F91D7C] text-white">
                                1
                            </button>
                            <button class="px-3 py-1 border-t border-b border-gray-300 hover:bg-[#F91D7C]/10">
                                2
                            </button>
                            <button class="px-3 py-1 border-t border-b border-gray-300 hover:bg-[#F91D7C]/10">
                                3
                            </button>
                            <button class="px-3 py-1 border border-gray-300 rounded-r-md hover:bg-[#F91D7C]/10">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            const tabsContainer = document.getElementById('tabs-carousel');
            const scrollLeftBtn = document.getElementById('scroll-left');
            const scrollRightBtn = document.getElementById('scroll-right');

            // Set initial active tab (first tab)
            const firstTabBtn = tabBtns[0];
            if (firstTabBtn) {
                firstTabBtn.classList.add('active');
                const button = firstTabBtn.querySelector('button');
                if (button) button.classList.add('text-[#F91D7C]');

                // Add pink underline to initial active tab
                const underline = document.createElement('div');
                underline.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                firstTabBtn.appendChild(underline);
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabBtns.forEach(b => {
                        b.classList.remove('active');
                        const button = b.querySelector('button');
                        if (button) button.classList.remove('text-[#F91D7C]');

                        // Remove pink underline if it exists
                        const underline = b.querySelector('div.absolute');
                        if (underline) {
                            underline.remove();
                        }
                    });

                    // Add active class to clicked button
                    btn.classList.add('active');

                    // Add pink text color
                    const button = btn.querySelector('button');
                    if (button) button.classList.add('text-[#F91D7C]');

                    // Add pink underline to active tab
                    const underline = document.createElement('div');
                    underline.className = 'absolute bottom-0 left-0 w-full h-0.5 bg-[#F91D7C]';
                    btn.appendChild(underline);

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show the selected tab content
                    const tabId = btn.getAttribute('data-tab');
                    const selectedTab = document.getElementById(`${tabId}-content`);
                    if (selectedTab) selectedTab.classList.remove('hidden');
                });
            });

            // Check if scrolling is needed
            function checkScroll() {
                if (tabsContainer.scrollWidth > tabsContainer.clientWidth) {
                    // Content is wider than container, show arrows
                    scrollRightBtn.classList.remove('hidden');

                    // Only show left arrow if not at the beginning
                    if (tabsContainer.scrollLeft > 0) {
                        scrollLeftBtn.classList.remove('hidden');
                    } else {
                        scrollLeftBtn.classList.add('hidden');
                    }

                    // Only show right arrow if not at the end
                    if (tabsContainer.scrollLeft + tabsContainer.clientWidth < tabsContainer.scrollWidth) {
                        scrollRightBtn.classList.remove('hidden');
                    } else {
                        scrollRightBtn.classList.add('hidden');
                    }
                } else {
                    // Content fits, hide arrows
                    scrollLeftBtn.classList.add('hidden');
                    scrollRightBtn.classList.add('hidden');
                }
            }

            // Scroll left when left arrow is clicked
            scrollLeftBtn.addEventListener('click', function () {
                tabsContainer.scrollBy({ left: -100, behavior: 'smooth' });
            });

            // Scroll right when right arrow is clicked
            scrollRightBtn.addEventListener('click', function () {
                tabsContainer.scrollBy({ left: 100, behavior: 'smooth' });
            });

            // Check scroll position on scroll
            tabsContainer.addEventListener('scroll', checkScroll);

            // Check on resize
            window.addEventListener('resize', checkScroll);

            // Initial check
            checkScroll();
        });
    </script>

@endsection


@php
$activePage = 'logs'; // Set the active page for this specific view
@endphp