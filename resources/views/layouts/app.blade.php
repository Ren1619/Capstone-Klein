<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="font-poppins bg-neutral-100">
    <div class="flex h-screen w-full overflow-hidden">

        <!-- Sidebar (hidden on small screens by default) -->
        <div id="sidebar"
            class="fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-all duration-300 md:relative md:translate-x-0 w-64 bg-white border-r border-neutral-200 flex flex-col">

            <!-- Logo -->
            <div class="px-9 py-6 border-b border-neutral-200 flex items-center gap-2.5">
                <div class="w-4 h-8">
                    <img src="{{ asset('icons/pelaez_logo_icon.svg') }}" alt="Pelaez Derm Clinic">
                </div>
                <div class="text-black text-base font-normal leading-none">Pelaez Derm Clinic</div>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                <div class="flex flex-col gap-[5px] mt-4">

                    @php
                        // manullay sets the active menu
                        $activePage = $activePage ?? 'dashboard';

                        // Define menu items with their page identifiers and icons
                        $menuItems = [
                            ['id' => 'dashboard', 'name' => 'Dashboard', 'icon' => 'dashboard_icon.svg', 'url' => '/dashboard'],
                            ['id' => 'patientsRecord', 'name' => 'Patients Record', 'icon' => 'patients_record_icon.svg', 'url' => '/patientsRecord'],
                            ['id' => 'appointments', 'name' => 'Appointments', 'icon' => 'appointment_icon.svg', 'url' => '/appointments'],
                            ['id' => 'services', 'name' => 'Services', 'icon' => 'services_icon.svg', 'url' => '/services'],
                            ['id' => 'pos', 'name' => 'Point of Sale', 'icon' => 'pos_icon.svg', 'url' => '/pos'],
                            ['id' => 'inventory', 'name' => 'Inventory', 'icon' => 'inventory_icon.svg', 'url' => '/inventory'],
                            ['id' => 'staffs', 'name' => 'Staffs', 'icon' => 'staff_icon.svg', 'url' => '/staffs'],
                            ['id' => 'branches', 'name' => 'Branches', 'icon' => 'clinics_icon.svg', 'url' => '/branches'],
                            ['id' => 'feedbacks', 'name' => 'Feedbacks', 'icon' => 'feedbacks_icon.svg', 'url' => '/feedbacks'],
                            ['id' => 'reports', 'name' => 'Reports', 'icon' => 'report_icon.svg', 'url' => '/reports'],
                            ['id' => 'logs', 'name' => 'Logs', 'icon' => 'logs_icon.svg', 'url' => '/logs'],
                        ];
                    @endphp


                    @foreach ($menuItems as $item)
                                    <a href="{{ $item['url'] }}" class="{{ $activePage == $item['id']
                        ? 'p-3.5 bg-[#F91D7C]/10 border-l-[5px] border-[#F91D7C] flex items-center gap-3.5'
                        : 'p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10' }}">
                                        <div class="w-6 h-6 relative">
                                            <div class="w-6 h-6">
                                                <img src="{{ asset('icons/' . $item['icon']) }}" alt="{{ $item['name'] }}">
                                            </div>
                                        </div>
                                        <div class="text-black text-sm font-normal leading-none">{{ $item['name'] }}</div>
                                    </a>
                    @endforeach

                </div>

                <!-- Logout at bottom -->
                <div class="mt-auto mb-4">
                    <a href={{ url('/login') }} class="p-3.5 flex items-center gap-3.5 hover:bg-pink-600/10">
                        <div class="w-6 h-6 relative">
                            <div class="w-6 h-6">
                                <img src="{{ asset('icons/logout_icon.svg') }}" alt="Log out">
                            </div>
                        </div>
                        <div class="text-black text-sm font-normal leading-none">Log out</div>
                    </a>
                </div>
            </div>

            <!-- Close button for mobile -->
            <button id="close-sidebar" class="absolute top-4 right-4 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full md:w-auto">
            <!-- Header -->
            <div class="h-20 p-3.5 border-b border-neutral-200 bg-white flex justify-between items-center">
                <div class="flex items-center">
                    <!-- Menu toggle for mobile -->
                    <button id="menu-toggle" class="mr-4 md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="text-black text-xl font-semibold leading-tight tracking-tight">
                        @yield('header', 'Dashboard')</div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="w-6 h-6 relative overflow-hidden">
                        <div class="w-6 h-6">
                            <img src="{{ asset('icons/notification_icon.svg') }}" alt="Notifications">
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full overflow-hidden">
                            <img src="{{ asset('images/images.png') }}" alt="Profile"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="text-black text-sm font-normal leading-none hidden sm:block">Admin Name</div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="flex-1 p-5 bg-neutral-100 overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Overlay for mobile when sidebar is open -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    @yield('scripts')
    <script>
        // Toggle sidebar visibility
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        // Close sidebar
        document.getElementById('close-sidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
    <script src="{{ asset('js/clinic-search.js') }}"></script>
    <script src="{{ asset('js/product-search.js') }}"></script>
    <script src="{{ asset('js/service-search.js') }}"></script>
</body>

</html>