<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Import Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .services-container::-webkit-scrollbar {
            height: 6px;
        }

        .services-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .services-container::-webkit-scrollbar-thumb {
            background: #FF006E;
            border-radius: 10px;
        }

        .services-container::-webkit-scrollbar-thumb:hover {
            background: #d10058;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>

<body class="font-poppins bg-neutral-100">
    <!-- Header -->

    <!-- Header -->
    <!-- <header class="w-full h-20 bg-white flex flex-col justify-center items-start overflow-hidden border-b border-neutral-200"> -->
    <header
        class="w-full h-20 bg-white border-b border-neutral-200 fixed top-0 left-0 right-0 z-50 flex flex-col justify-center items-start overflow-hidden">

        <div class="self-stretch flex-1 inline-flex justify-between items-center">
            <!-- Logo with Menu Icon for Mobile -->
            <div class="px-10 self-stretch py-6 flex justify-center items-center gap-2.5">
                <!-- Mobile Menu Button on the left side -->
                <button id="menu-toggle" class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="w-4 h-8 md:block hidden">
                    <img src="{{ asset('icons/pelaez_logo_icon.svg') }}" alt="Pelaez Derm Clinic">
                </div>
                <div class="text-black text-base font-normal leading-none">Pelaez Derm Clinic</div>
            </div>

            <!-- Navigation - Desktop -->
            <nav class="hidden md:flex px-10 h-11 justify-start items-center gap-12 pr-20">
                <a href="/#home"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Home</a>
                <a href="/#about"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    About</a>
                <a href="/#services"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Services</a>
                <a href="/#branches"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Branches</a>
                <a href="/#contact"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Contact</a>

                <!-- Appointment Dropdown Container -->
                <div id="appointmentDropdown"
                    class="relative inline-block text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    <button id="dropdownButton"
                        class="flex items-center gap-2 text-base font-normal leading-none tracking-tight">
                        <span>Appointment</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </nav>
        </div>
    </header>


    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu"
        class="hidden fixed inset-y-0 left-0 z-[60] transform w-64 bg-white border-r border-neutral-200 flex-col md:hidden">
        <!-- Close button for mobile -->
        <button id="close-sidebar" class="absolute top-4 right-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Logo -->
        <div class="px-9 py-6 border-b border-neutral-200 flex items-center gap-2.5">
            <div class="w-4 h-8">
                <img src="{{ asset('icons/pelaez_logo_icon.svg') }}" alt="Pelaez Derm Clinic">
            </div>
            <div class="text-black text-base font-normal leading-none">Pelaez Derm Clinic</div>
        </div>

        <!-- Menu Links -->
        <div class="flex flex-col gap-[5px] mt-4">
            <a href="/#home" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Home</div>
            </a>
            <a href="/#about" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">About</div>
            </a>
            <a href="/#services" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Services</div>
            </a>
            <a href="/#branches" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Branches</div>
            </a>
            <a href="/#contact" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Contact</div>
            </a>

            <!-- Appointment options in mobile menu -->
            <div class="mt-2 border-t border-neutral-200 pt-2">
                <div class="p-3.5 text-black text-sm font-medium leading-none">Appointment</div>
                <button  class="addAppointmentBtn p-3.5 pl-10 flex items-center hover:bg-[#F91D7C]/10">
                    <div class="text-black text-sm font-normal leading-none">Book an appointment</div>
                </button>
                <button class="cancelAppointmentBtn p-3.5 pl-10 flex items-center hover:bg-[#F91D7C]/10">
                    <div class="text-black text-sm font-normal leading-none">Cancel appointment</div>
                </button>
                <button class="visitFeedbackBtn p-3.5 pl-10 flex items-center hover:bg-[#F91D7C]/10">
                    <div class="text-black text-sm font-normal leading-none">Appointment Feedback</div>
                </button>
            </div>
        </div>
    </div>

    <!-- Dropdown Menu positioned at the document root level -->
    <div id="dropdownMenu"
        class="hidden fixed z-[9999] bg-white border border-neutral-200 rounded-[5px] p-[5px] shadow-lg w-48">
        <button 
            class="addAppointmentBtn block w-full px-3 py-2.5 rounded-[5px] text-black text-xs font-normal hover:bg-[#F91D7C]/10 hover:text-[#FF006E] transition-all">
            Book an appointment
        </button>
        <button
            class="cancelAppointmentBtn block w-full px-3 py-2.5 rounded-[5px] text-black text-xs font-normal hover:bg-[#F91D7C]/10 hover:text-[#FF006E] transition-all">
            Cancel appointment
        </button>
        <button
            class="visitFeedbackBtn block w-full px-3 py-2.5 rounded-[5px] text-black text-xs font-normal hover:bg-[#F91D7C]/10 hover:text-[#FF006E] transition-all">
            Appointment Feedback
        </button>
    </div>


    <!-- Overlay for mobile when sidebar is open -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Main Content - Centered from top to bottom -->
    <div class="main-content flex-1 w-full bg-neutral-100 flex justify-center items-center p-4">
        <div class="w-full max-w-6xl bg-white grid grid-cols-1 md:grid-cols-2 shadow-md rounded-lg overflow-hidden">
            <!-- Image Section - Using grid and full height approach -->
            <div class="h-full min-h-full">
                <img class="w-full h-full object-cover" src="{{ asset('images/signin_img.png') }}"
                    alt="Pelaez Derm Clinic" />
            </div>

            <!-- Form Section -->
            <div class="px-6 sm:px-12 lg:px-24 py-8 flex flex-col justify-center items-center gap-3.5">
                <div class="w-full flex justify-center items-start">
                    <div class="text-center">
                        <span class="text-[#FF006E] text-3xl sm:text-4xl lg:text-5xl font-bold">Sign </span>
                        <span class="text-black text-3xl sm:text-4xl lg:text-5xl font-bold">In</span>
                    </div>
                </div>

                <div class="w-full max-w-md flex flex-col justify-start items-start gap-3.5">
                    <!-- Email Input -->
                    <div class="w-full h-20 py-3.5 border-b border-black flex justify-start items-end">
                        <div class="flex justify-start items-center gap-2.5 w-full">
                            <div class="w-6 h-6 relative overflow-hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" placeholder="Email"
                                class="w-full border-none focus:outline-none bg-transparent text-base font-normal leading-none" />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="w-full h-20 py-3.5 border-b border-black flex justify-start items-end">
                        <div class="flex justify-start items-center gap-2.5 w-full">
                            <div class="w-6 h-6 relative overflow-hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" placeholder="Password"
                                class="w-full border-none focus:outline-none bg-transparent text-base font-normal leading-none" />
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="w-full h-20 py-3.5 flex flex-col justify-center items-center gap-3.5">
                        <a href="{{ url('/dashboard') }}"
                            class="w-full h-10 px-4 py-1 bg-[#FF006E] hover:bg-[#e0005e] rounded-md flex justify-center items-center text-white text-sm font-semibold leading-none tracking-tight transition duration-200">
                            Sign In
                        </a>
                    </div>

                    <!-- Forgot Password -->
                    <div class="w-full text-center text-black text-sm font-light hover:text-[#FF006E] cursor-pointer">
                        Forgot Password?
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle mobile menu visibility
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');

            mobileMenu.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });

        // Close mobile menu
        document.getElementById('close-sidebar').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');

            mobileMenu.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        // Close mobile menu when clicking overlay
        document.getElementById('overlay').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');

            mobileMenu.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            // Function to position the dropdown directly below the button
            function positionDropdown() {
                const buttonRect = dropdownButton.getBoundingClientRect();

                // Position the dropdown below the button and aligned with the left edge
                dropdownMenu.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                dropdownMenu.style.left = (buttonRect.left + window.scrollX) + 'px';

                // Ensure the dropdown is fully visible within the viewport
                const dropdownRect = dropdownMenu.getBoundingClientRect();
                const viewportWidth = window.innerWidth;

                // If dropdown would overflow the right edge of the viewport, align it with the right edge of the button instead
                if (buttonRect.left + dropdownRect.width > viewportWidth) {
                    dropdownMenu.style.left = (buttonRect.right - dropdownRect.width + window.scrollX) + 'px';
                }
            }

            dropdownButton.addEventListener('click', function (event) {
                event.stopPropagation();

                // Position the dropdown before showing it
                positionDropdown();

                // Toggle visibility
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking anywhere else
            document.addEventListener('click', function (event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Reposition dropdown on window resize
            window.addEventListener('resize', function () {
                if (!dropdownMenu.classList.contains('hidden')) {
                    positionDropdown();
                }
            });
        });
    </script>
</body>

</html>

@include("landing page/modal/cancel_appointment")
@include("landing page/modal/visit_feedback")
@include('appointments.modals.appointment-modal')