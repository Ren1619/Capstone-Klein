<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaez Derm Clinic - Your Skin, Hair, and Nail Specialist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Import Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Swiper JS for carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!-- Leaflet CSS for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        #mobile-menu {
            display: none;

        }

        #mobile-menu.show {
            display: flex !important;

        }


        @media (min-width: 768px) {
            #mobile-menu {
                display: none !important;
            }
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #FF006E !important;
        }

        .swiper-pagination-bullet-active {
            background: #FF006E !important;
        }

        html {
            scroll-behavior: smooth;
        }

        .map-instructions {
            max-width: 200px;
            font-size: 12px;
            background-color: rgba(255, 255, 255, 0.9);
            border-left: 3px solid #FF006E;
        }

        @media (max-width: 640px) {
            .swiper-pagination {
                bottom: 0 !important;
            }

            /* Make pagination bullets more visible on mobile */
            .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
            }
        }

        /* Style swiper navigation buttons */
        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.2rem !important;
            color: #FF006E;
            font-weight: bold;
        }

        @media (min-width: 640px) {

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 1.5rem !important;
            }
        }

        .swiper-button-next,
        .swiper-button-prev {
            background-color: rgba(255, 255, 255, 0.8);
            width: 30px !important;
            height: 30px !important;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 640px) {

            .swiper-button-next,
            .swiper-button-prev {
                width: 35px !important;
                height: 35px !important;
            }
        }
    </style>
</head>

<body class="font-poppins bg-white">

    <!-- Header -->
    <header
        class="w-full h-20 bg-white flex flex-col justify-center items-start overflow-hidden border-b border-neutral-200 fixed top-0 left-0 z-50 shadow-sm">

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
                <a href="#home"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Home</a>
                <a href="#about"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    About</a>
                <a href="#services"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Services</a>
                <a href="#branches"
                    class="text-black text-base font-normal leading-tight hover:text-[#FF006E] hover:font-medium transition-all border-b-2 border-transparent hover:border-[#FF006E]">
                    Branches</a>
                <a href="#contact"
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
            <a href="#home" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Home</div>
            </a>
            <a href="#about" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">About</div>
            </a>
            <a href="#services" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
                <div class="w-6 h-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="text-black text-sm font-normal leading-none">Services</div>
            </a>
            <a href="#branches" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
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
            <a href="#contact" class="p-3.5 flex items-center gap-3.5 hover:bg-[#F91D7C]/10">
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
                <button id="mobileAppointmentBtn" class="p-3.5 pl-10 flex items-center hover:bg-[#F91D7C]/10">
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
        <button id="dropdownAppointmentBtn"
            class="block w-full px-3 py-2.5 rounded-[5px] text-black text-xs font-normal hover:bg-[#F91D7C]/10 hover:text-[#FF006E] transition-all">
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

    <!-- Main Content - Top margin equals header height -->
    <main class="w-full">
        <!-- Hero Section - Directly under header with no gap -->
        <section id="home" class="relative h-[500px] sm:h-[600px] md:h-[650px] lg:h-[800px] w-full overflow-hidden">
            <!-- Single image solution with better mobile handling -->
            <img src="{{ asset('images/landingpage_img.png') }}" alt="Pelaez Derm Clinic"
                class="absolute inset-0 w-full h-full object-cover object-center md:object-[center_30%]">
            <div
                class="absolute inset-0 flex flex-col justify-center px-4 sm:px-6 md:px-16 py-6 sm:py-10 gap-3 sm:gap-5 bg-gradient-to-r from-black/60 to-black/30">
                <div class="max-w-3xl">
                    <h1
                        class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight md:leading-tight tracking-[1px] sm:tracking-[2px] mb-2 sm:mb-4">
                        <span class="text-[#FF006E]">Pelaez</span> Derm Clinic
                    </h1>
                    <h2
                        class="text-white text-lg sm:text-xl md:text-2xl lg:text-3xl font-medium leading-relaxed mb-1 sm:mb-2">
                        Your skin, hair and nail specialist
                    </h2>
                    <p class="text-white text-base sm:text-lg md:text-xl font-medium mb-5 sm:mb-8">
                        Dermatologist - Aesthetic - Laser Clinic
                    </p>

                    <button id="heroAppointmentBtn"
                        class="inline-block bg-[#FF006E] hover:bg-[#FF006E]/90 text-white font-semibold px-6 sm:px-8 py-2 sm:py-3 text-sm sm:text-base rounded-md transition-all transform hover:scale-105 shadow-lg">
                        Book an Appointment
                    </button>
                </div>
        </section>
        <section id="about">
            <!-- About Doctor Section -->
            <section class="bg-white w-full py-10 md:py-16">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-8 md:gap-12">
                        <div class="flex-1 flex flex-col justify-center items-start gap-4 md:gap-6">
                            <h2
                                class="text-black text-xl sm:text-2xl md:text-3xl font-bold leading-tight tracking-wider">
                                <span class="text-[#FF006E]">Meet</span> Dr. Rona Grace Pelaez
                            </h2>
                            <div class="w-full text-black text-sm sm:text-base font-normal leading-relaxed">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation
                                ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit
                                in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                                cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                            <a href="{{ url('/about') }}"
                                class="inline-flex items-center text-[#FF006E] font-medium hover:underline text-sm sm:text-base">
                                Learn more about Dr. Pelaez
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        <div
                            class="w-full max-w-xs sm:max-w-sm md:w-96 h-64 sm:h-80 md:h-96 flex justify-center items-center mt-6 md:mt-0">
                            <img src="{{ asset('images/dr_img.png') }}" alt="Dr. Rona Grace Pelaez"
                                class="w-full h-full object-cover shadow-lg rounded-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                        </div>
                    </div>
                </div>
            </section>

            <!-- About Clinic Section -->
            <section class="bg-neutral-50 w-full py-10 md:py-16">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row-reverse justify-between items-center gap-8 md:gap-12">
                        <div class="flex-1 flex flex-col justify-center items-start gap-4 md:gap-6">
                            <h2
                                class="text-black text-xl sm:text-2xl md:text-3xl font-bold leading-tight tracking-wider">
                                About <span class="text-[#FF006E]">Pelaez Derm Clinic</span>
                            </h2>
                            <div class="w-full text-black text-sm sm:text-base font-normal leading-relaxed">
                                The Pelaez Derm Clinic, established in 2009 by Dr. Rona Villasor Pelaez and Dr. Hilbert
                                Pelaez, has grown into a trusted dermatology practice in Bukidnon. With three branches
                                strategically located in Valencia City, Malaybalay City, and Maramag, the clinic serves
                                a diverse patient base across these areas. It offers a range of dermatological services,
                                including consultations, medical and cosmetic treatments, and skincare procedures
                                tailored
                                to address various skin conditions. Over the years, the clinic has built a reputation
                                for
                                quality care, leveraging the expertise of its medical professionals to provide
                                personalized
                                and effective dermatological solutions.
                            </div>
                            <a href="{{ url('/about') }}"
                                class="inline-flex items-center text-[#FF006E] font-medium hover:underline text-sm sm:text-base">
                                Learn more about our clinic
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        <div
                            class="w-full max-w-xs sm:max-w-sm md:w-96 h-64 sm:h-80 md:h-96 flex justify-center items-center mt-6 md:mt-0">
                            <img src="{{ asset('images/building_img.jpg') }}" alt="Pelaez Derm Clinic"
                                class="w-full h-full object-cover shadow-lg rounded-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                        </div>
                    </div>
                </div>
            </section>
        </section>


        <!-- Services Section -->
        <section id="services" class="relative w-full py-10 sm:py-12 md:py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2
                    class="text-center text-black text-2xl sm:text-3xl md:text-4xl font-bold leading-tight tracking-wider mb-8 sm:mb-10 md:mb-12">
                    Our <span class="text-[#FF006E]">Services</span>
                </h2>

                <!-- Swiper Carousel -->
                <div class="swiper servicesSwiper">
                    <div class="swiper-wrapper pb-10 sm:pb-12">
                        <!-- Service Cards -->
                        @php
                            $services = [
                                [
                                    'title' => 'Acne/Pimple Treatment',
                                    'image' => 'images/acne_treatment_img.png',
                                    'description' => 'Effective treatments for various types of acne, from mild to severe, tailored to your specific skin needs.'
                                ],
                                [
                                    'title' => 'Aesthetic Treatment',
                                    'image' => 'images/aesthetic_treatment_img.png',
                                    'description' => 'Non-invasive procedures designed to enhance your natural beauty and improve overall skin appearance.'
                                ],
                                [
                                    'title' => 'Anti-Aging Treatment',
                                    'image' => 'images/anti_aging_img.png',
                                    'description' => 'Advanced treatments to reduce signs of aging, including fine lines, wrinkles, and loss of skin elasticity.'
                                ],
                                [
                                    'title' => 'Medical Facial',
                                    'image' => 'images/medical_facial_img.png',
                                    'description' => 'Specialized facials that go beyond the standard spa treatment, targeting specific skin concerns with medical-grade products.'
                                ],
                                [
                                    'title' => 'Injectables',
                                    'image' => 'images/injectables_img.png',
                                    'description' => 'Safe and effective injectable treatments to restore volume, smooth wrinkles, and rejuvenate your appearance.'
                                ],
                                [
                                    'title' => 'Aesthetic',
                                    'image' => 'images/aesthetic_img.png',
                                    'description' => 'Non-invasive procedures designed to enhance your natural beauty and improve overall skin appearance.'
                                ],
                                [
                                    'title' => 'Laser - IPL or Diode',
                                    'image' => 'images/laser_img.png',
                                    'description' => 'Cutting-edge laser treatments for hair removal, pigmentation, vascular lesions, and skin rejuvenation.'
                                ],
                                [
                                    'title' => 'Dermatological Treatment',
                                    'image' => 'images/dermatological_treatment_img.png',
                                    'description' => 'Comprehensive care for various skin conditions including eczema, psoriasis, rosacea, and other dermatological concerns.'
                                ]
                            ];
                        @endphp

                        @foreach ($services as $service)
                            <div class="swiper-slide px-0.5 sm:px-1 md:px-2 py-2">
                                <div
                                    class="h-[400px] sm:h-[450px] md:h-[520px] bg-white shadow-lg rounded-lg flex flex-col hover:shadow-xl transition-all transform hover:scale-[1.02]">
                                    <div class="h-40 sm:h-48 md:h-64 overflow-hidden rounded-t-lg">
                                        <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-3 sm:p-4 md:p-6 flex flex-col gap-2 sm:gap-3 md:gap-4 flex-1">
                                        <h3
                                            class="text-[#FF006E] text-base sm:text-lg md:text-xl font-semibold leading-tight">
                                            {{ $service['title'] }}
                                        </h3>
                                        <p
                                            class="text-black text-xs sm:text-sm md:text-base font-normal leading-relaxed flex-grow line-clamp-4 sm:line-clamp-none">
                                            {{ $service['description'] }}
                                        </p>
                                        <a href="{{ url('/services') }}"
                                            class="inline-flex items-center text-[#FF006E] text-xs sm:text-sm md:text-base font-medium hover:underline mt-1 sm:mt-2">
                                            Learn more
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>



        <!-- Branches Section with Map -->
        <section id="branches" class="bg-neutral-50 w-full py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-center text-black text-3xl md:text-4xl font-bold leading-tight tracking-wider mb-12">
                    Our <span class="text-[#FF006E]">Branches</span>
                </h2>
                <!-- Branch Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @php
                        $branches = [
                            [
                                'name' => 'Valencia Branch',
                                'image' => 'images/building_img.jpg',
                                'address' => 'Roque building at the back of AGT Gas Station, T.N Pepito Street, Poblacion, Valencia, Philippines',
                                'phone' => '0953 542 4222',
                                'lat' => '7.9038',
                                'lng' => '125.0941',
                                'facebookPage' => 'https://www.facebook.com/share/18TnRiTpMK/'
                            ],
                            [
                                'name' => 'Maramag Branch',
                                'image' => 'images/building_img.jpg',
                                'address' => '2nd floor-Bautista building, Purok 1, South Poblacion, Maramag, 8714 Maramag, Philippines',
                                'phone' => '0905 075 9423',
                                'lat' => '7.7608',
                                'lng' => '125.0074',
                                'facebookPage' => 'https://www.facebook.com/share/18xjWJt5Fd/'
                            ],
                            [
                                'name' => 'Malaybalay Branch',
                                'image' => 'images/building_img.jpg',
                                'address' => '3rd Floor of 7C\'s Hardware, Infront of RD Pawnshop near Gaisano Mall,Fortich St., Sayre Highway, Malaybalay City',
                                'phone' => '0975 276 1417',
                                'lat' => '8.1576',
                                'lng' => '125.0875',
                                'facebookPage' => 'https://www.facebook.com/share/1WMRuFcg9L/'
                            ]
                        ];
                    @endphp

                    @foreach ($branches as $index => $branch)
                        <div
                            class="bg-white flex flex-col h-full rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all transform hover:scale-[1.02]">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset($branch['image']) }}" alt="{{ $branch['name'] }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-6 flex flex-col gap-3 flex-1">
                                <h3 class="text-[#FF006E] text-xl font-semibold leading-tight">{{ $branch['name'] }}</h3>
                                <p class="text-black text-base font-normal pt-10">{{ $branch['address'] }}</p>
                                <p class="text-black text-base font-semibold pt-10">{{ $branch['phone'] }}</p>

                                <div class="flex flex-col gap-3 mt-3">
                                    <button
                                        class="branchButton inline-flex items-center text-[#FF006E] font-medium hover:underline"
                                        data-lat="{{ $branch['lat'] }}" data-lng="{{ $branch['lng'] }}"
                                        data-name="{{ $branch['name'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        View on map
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Map Container with Street View -->
                <div class="relative">
                    <div id="map" class="w-full h-96 rounded-lg shadow-md"></div>
                    <div id="street-view" class="hidden w-full h-96 rounded-lg shadow-md"></div>
                    <button id="back-to-map"
                        class="hidden absolute top-3 right-3 z-20 bg-[#FF006E] text-white py-2 px-4 rounded-md shadow-md hover:bg-[#FF006E]/90 transition-colors font-medium">
                        × Close Street View
                    </button>
                </div>
            </div>
        </section>

        <!-- Contact Us Section -->
        <section id="contact" class="bg-white w-full py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-center text-black text-3xl md:text-4xl font-bold leading-tight tracking-wider mb-12">
                    <span class="text-[#FF006E]">Contact</span> Us
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Contact Form -->
                    <div class="bg-white p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
                        <h2 class="text-3xl font-bold mb-4">
                            <span class="text-[#FF006E]">Drop</span> us a message!
                        </h2>
                        <p class="text-black text-base mb-6">
                            All fields with <span class="text-[#FF006E]">*</span> are required.
                        </p>

                        <form action="#" method="POST" class="space-y-5">
                            @csrf
                            <!-- Name Fields -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Name<span class="text-[#FF006E]">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <input type="text" name="first_name" placeholder="First Name" required
                                            class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-10">
                                    </div>
                                    <div>
                                        <input type="text" name="middle_name" placeholder="Middle Name"
                                            class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-10">
                                    </div>
                                    <div>
                                        <input type="text" name="last_name" placeholder="Last Name" required
                                            class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-10">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Contact Number<span class="text-[#FF006E]">*</span>
                                    </label>
                                    <input type="text" name="phone" placeholder="+63" required
                                        class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-10">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email
                                    </label>
                                    <input type="email" name="email" placeholder="sample@gmail.com"
                                        class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-10">
                                </div>
                            </div>

                            <!-- Message -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Message<span class="text-[#FF006E]">*</span>
                                </label>
                                <textarea name="message" placeholder="Write your message here..." required
                                    class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF006E] focus:border-transparent h-32 resize-none"></textarea>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="bg-[#FF006E] text-white py-3 px-8 rounded font-semibold hover:bg-[#FF006E]/90 transition-all duration-300 shadow-md">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white p-8 rounded-lg shadow-lg flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl md:text-3xl font-bold mb-6">
                                Need assistance? <span class="text-[#FF006E]">Reach</span> out to us!
                            </h3>
                            <p class="text-black text-base mb-8">
                                Feel free to reach out to us for any inquiries or assistance. Our friendly team is here
                                to help you with all your dermatological needs.
                            </p>

                            <div class="flex flex-col gap-8 mb-8">
                                <!-- Phone Numbers -->
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#FF006E]/10 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FF006E]"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-black text-lg font-medium mb-2">Phone</h4>
                                        <p class="text-black text-base font-normal mb-2">Valencia: <span
                                                class="font-medium text-[#FF006E]">0953 542 4222</span></p>
                                        <p class="text-black text-base font-normal mb-2">Maramag: <span
                                                class="font-medium text-[#FF006E]">0905 075 9423</span></p>
                                        <p class="text-black text-base font-normal">Malaybalay: <span
                                                class="font-medium text-[#FF006E]">0975 276 1417</span></p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#FF006E]/10 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FF006E]"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-black text-lg font-medium mb-2">Email</h4>
                                        <p class="text-black text-base font-normal">pelaezderm_clinic@yahoo.com.ph</p>
                                    </div>
                                </div>

                                <!-- Social Media -->
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#FF006E]/10 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FF006E]"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-black text-lg font-medium mb-2">Facebook</h4>
                                        <p class="text-black text-base font-normal mb-2">
                                            <a href="https://www.facebook.com/share/18TnRiTpMK/" target="_blank"
                                                class="text-black hover:underline hover:text-[#FF006E]">
                                                Pelaez DERM Clinic (Valencia)
                                            </a>
                                        </p>
                                        <p class="text-black text-base font-normal mb-2">
                                            <a href="https://www.facebook.com/share/18xjWJt5Fd/" target="_blank"
                                                class="text-black] hover:underline hover:text-[#FF006E]">
                                                Pelaez Derm Clinic-Maramag branch
                                            </a>
                                        </p>
                                        <p class="text-black text-base font-normal">
                                            <a href="https://www.facebook.com/share/1WMRuFcg9L/" target="_blank"
                                                class="text-black hover:underline hover:text-[#FF006E]">
                                                Pelaez Derm Clinic-Malaybalay branch
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="w-full py-16 bg-[#FF006E]/5">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to transform your skin?</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto">Schedule an appointment with our experienced dermatologists
                    today and take the first step towards healthier, more beautiful skin.</p>
                <button id="ctaAppointmentBtn"
                    class="inline-block bg-[#FF006E] hover:bg-[#FF006E]/90 text-white font-semibold px-8 py-3 rounded-md transition-all transform hover:scale-105 shadow-lg">
                    Book Your Consultation
                </button>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white w-full border-t border-neutral-200">
            <div class="container mx-auto px-4 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Logo and Info -->
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-2.5 mb-4">
                            <div class="w-6 h-12">
                                <img src="{{ asset('icons/pelaez_logo_icon.svg') }}" alt="Pelaez Derm Clinic"
                                    class="w-full h-full">
                            </div>
                            <div class="text-black text-lg font-medium">Pelaez Derm Clinic</div>
                        </div>
                        <p class="text-black text-sm mb-4">
                            Your trusted dermatology clinic in Bukidnon, providing quality skin, hair, and nail care
                            since 2009.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-span-1">
                        <h3 class="text-black text-lg font-medium mb-4">Quick Links</h3>
                        <ul class="flex flex-col gap-2">
                            <li><a href="#home" class="text-black text-sm hover:text-[#FF006E]">Home</a></li>
                            <li><a href="#about" class="text-black text-sm hover:text-[#FF006E]">About</a>
                            </li>
                            <li><a href="#services" class="text-black text-sm hover:text-[#FF006E]">Services</a></li>
                            <li><a href="#branches" class="text-black text-sm hover:text-[#FF006E]">Branches</a></li>
                            <li><a href="#contact" class="text-black text-sm hover:text-[#FF006E]">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-span-1">
                        <h3 class="text-black text-lg font-medium mb-4">Contact Us</h3>
                        <ul class="flex flex-col gap-2">
                            <li class="text-black text-sm">Valencia: 0953 542 4222</li>
                            <li class="text-black text-sm">Maramag: 0905 075 9423</li>
                            <li class="text-black text-sm">Malaybalay: 0975 276 1417</li>
                            <li class="text-black text-sm">pelaezderm_clinic@yahoo.com.ph</li>
                        </ul>
                    </div>

                    <!-- Business Hours -->
                    <div class="col-span-1">
                        <h3 class="text-black text-lg font-medium mb-4">Business Hours</h3>
                        <ul class="flex flex-col gap-2">
                            <li class="text-black text-sm">Monday - Saturday: 9:00 AM - 5:00 PM</li>
                            <li class="text-black text-sm">Sunday: Closed</li>
                        </ul>
                    </div>
                </div>

                <div class="h-px bg-neutral-200 my-6"></div>

                <div class="flex flex-col md:flex-row justify-center items-center">
                    <p class="text-black text-sm">
                        © {{ date('Y') }} Pelaez Derm Clinic. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </main>

    <!-- Appointment Schedule Modal -->
    <div id="appointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Modal Background Overlay -->
            <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 pb-0">
                    <h3 class="text-2xl font-bold">
                        <span class="text-[#F91D7C]">Set</span> your preferred schedule
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn" onclick="closeAppointmentModalDirect()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <form id="appointmentForm">
                        <div class="mb-4">
                            <p class="text-sm mb-2">
                                All fields with <span class="text-red-500">*</span> are required.
                            </p>
                        </div>
                        
                        <!-- Name Fields -->
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input 
                                        type="text" 
                                        id="firstName" 
                                        name="firstName" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        placeholder="First Name*" 
                                        required>
                                </div>
                                <div>
                                    <input 
                                        type="text" 
                                        id="lastName" 
                                        name="lastName" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        placeholder="Last Name*" 
                                        required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Fields -->
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input 
                                        type="tel" 
                                        id="phoneNumber" 
                                        name="phoneNumber" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        placeholder="Phone Number*" 
                                        required>
                                </div>
                                <div>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        placeholder="Email">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date and Time -->
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input 
                                            type="date" 
                                            id="appointmentDate" 
                                            name="appointmentDate" 
                                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                            required>
                                    </div>
                                </div>
                                <div>
                                    <select 
                                        id="preferredTime" 
                                        name="preferredTime" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        required>
                                        <option value="" disabled selected>Preferred Time</option>
                                        <option value="9:00 AM">9:00 AM</option>
                                        <option value="10:00 AM">10:00 AM</option>
                                        <option value="11:00 AM">11:00 AM</option>
                                        <option value="1:00 PM">1:00 PM</option>
                                        <option value="2:00 PM">2:00 PM</option>
                                        <option value="3:00 PM">3:00 PM</option>
                                        <option value="4:00 PM">4:00 PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Branch and Type -->
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <select 
                                        id="preferredBranch" 
                                        name="preferredBranch" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        required>
                                        <option value="" disabled selected>Preferred Branch</option>
                                        <option value="Main Branch">Main Branch</option>
                                        <option value="North Branch">North Branch</option>
                                        <option value="East Branch">East Branch</option>
                                        <option value="South Branch">South Branch</option>
                                    </select>
                                </div>
                                <div>
                                    <select 
                                        id="appointmentType" 
                                        name="appointmentType" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                        required>
                                        <option value="" disabled selected>Appointment Type</option>
                                        <option value="Consultation">Consultation</option>
                                        <option value="Treatment/Service">Treatment/Service</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Concerns -->
                        <div class="mb-4">
                            <textarea 
                                id="concerns" 
                                name="concerns" 
                                rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                                placeholder="Concerns"></textarea>
                        </div>
                        
                        <!-- Button Actions -->
                        <div class="grid grid-cols-2 gap-4">
                            <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                                Confirm
                            </button>
                            <button type="button" id="cancelBtn" onclick="closeAppointmentModalDirect()" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnmvKg4JauGAuTL3MbPVSa0X4t_NJ5Nbc&libraries=places&callback=initMap">
    </script>

    <script>
        // Open and close modal functions
        function openAppointmentModalDirect() {
            const modal = document.getElementById('appointmentModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAppointmentModalDirect() {
            const modal = document.getElementById('appointmentModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                const form = document.getElementById('appointmentForm');
                if (form) form.reset();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded - setting up mobile menu');

            // Get references to DOM elements
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeSidebar = document.getElementById('close-sidebar');
            const overlay = document.getElementById('overlay');

            // Log element status for debugging
            console.log('Menu toggle found:', !!menuToggle);
            console.log('Mobile menu found:', !!mobileMenu);

            // Make sure mobile menu is hidden initially (using our CSS approach)
            if (mobileMenu) {
                mobileMenu.classList.remove('show');
                console.log('Mobile menu hidden by removing show class');
            }

            if (overlay) {
                overlay.style.display = 'none';
            }

            // Toggle mobile menu visibility
            if (menuToggle) {
                menuToggle.addEventListener('click', function (e) {
                    console.log('Menu toggle clicked');

                    if (mobileMenu) {
                        // Use the show class instead of removing hidden
                        mobileMenu.classList.add('show');
                        console.log('Added show class to mobile menu');
                    }

                    if (overlay) {
                        overlay.style.display = 'block';
                    }
                });
            }

            // Close mobile menu when X button is clicked
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function (e) {
                    console.log('Close button clicked');

                    if (mobileMenu) {
                        mobileMenu.classList.remove('show');
                    }

                    if (overlay) {
                        overlay.style.display = 'none';
                    }
                });
            }

            // Close mobile menu when clicking overlay
            if (overlay) {
                overlay.addEventListener('click', function () {
                    console.log('Overlay clicked');

                    if (mobileMenu) {
                        mobileMenu.classList.remove('show');
                    }

                    overlay.style.display = 'none';
                });
            }
        });

        // Initialize Swiper
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Swiper with responsive settings
            const servicesSwiper = new Swiper('.servicesSwiper', {
                slidesPerView: 1,
                spaceBetween: 5,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    // when window width is >= 640px (sm)
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    // when window width is >= 768px (md)
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    // when window width is >= 1024px (lg)
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    // when window width is >= 1280px (xl)
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    }
                }
            });
        });

        function initMap() {
            // Branch data with precise Street View parameters
            const branches = [
                {
                    name: 'Valencia Branch',
                    position: { lat: 7.9038, lng: 125.0941 },
                    address: 'Roque building at the back of AGT Gas Station, T.N Pepito Street, Poblacion, Valencia',
                    phone: '0953 542 4222',
                    facebookPage: 'https://www.facebook.com/share/18TnRiTpMK/',
                    streetViewParams: {
                        position: { lat: 7.907155084994278, lng: 125.0932244622533 },
                        pov: { heading: 36.34, pitch: -10.58 }
                    }
                },
                {
                    name: 'Maramag Branch',
                    position: { lat: 7.7608, lng: 125.0074 },
                    address: '2nd floor-Bautista building, Purok 1, South Poblacion, Maramag',
                    phone: '0905 075 9423',
                    facebookPage: 'https://www.facebook.com/share/18xjWJt5Fd/',
                    streetViewParams: {
                        position: { lat: 7.760589105806614, lng: 125.0017060108167 },
                        pov: { heading: 339.75, pitch: 4.08 }
                    }
                },
                {
                    name: 'Malaybalay Branch',
                    position: { lat: 8.1576, lng: 125.0875 },
                    address: '3rd Floor of 7C\'s Hardware, Infront of RD Pawnshop near Gaisano Mall,Fortich St., Sayre Highway, Malaybalay City',
                    phone: '0975 276 1417',
                    facebookPage: 'https://www.facebook.com/share/1WMRuFcg9L/',
                    streetViewParams: {
                        position: { lat: 8.15456586184749, lng: 125.1281803858265 },
                        pov: { heading: 258.35, pitch: 5.77 }
                    }
                }
            ];

            // Create the map centered at Bukidnon
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 7.9406, lng: 125.0630 }, // Center point between branches
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                fullscreenControl: true,
                streetViewControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP,
                        google.maps.MapTypeId.SATELLITE,
                        google.maps.MapTypeId.HYBRID,
                        google.maps.MapTypeId.TERRAIN
                    ]
                }
            });

            // Create Street View panorama with proper configuration
            const streetView = new google.maps.StreetViewPanorama(
                document.getElementById("street-view"), {
                visible: false,
                enableCloseButton: true,
                addressControl: true,
                fullscreenControl: true,
                zoomControl: true,
                panControl: true
            }
            );

            // Link the map to the Street View
            map.setStreetView(streetView);

            // Add custom markers for each branch
            const markers = [];
            branches.forEach((branch, index) => {
                // Create custom marker
                const marker = new google.maps.Marker({
                    position: branch.position,
                    map: map,
                    title: branch.name,
                    animation: google.maps.Animation.DROP, // Add animation
                    icon: {
                        url: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png',
                        scaledSize: new google.maps.Size(40, 40),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(20, 40)
                    }
                });

                markers.push(marker);

                // Create info window content
                const infoContent = `
            <div style="min-width: 220px; padding: 10px;">
                <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #FF006E;">${branch.name}</h3>
                <p style="margin-bottom: 5px; font-size: 14px;">${branch.address}</p>
                <p style="margin-bottom: 12px; font-size: 14px;">${branch.phone}</p>
                <div style="display: flex; gap: 8px;">
                    <a href="#" onclick="showStreetView(${index}); return false;" style="flex: 1; display: inline-block; background-color: #FF006E; color: white; padding: 8px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; text-align: center;">
                        Street View
                    </a>
                    <a href="${branch.facebookPage}" target="_blank" style="flex: 1; display: inline-block; background-color: #1877F2; color: white; padding: 8px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; text-align: center;">
                        Facebook
                    </a>
                </div>
            </div>
            `;

                // Create info window
                const infowindow = new google.maps.InfoWindow({
                    content: infoContent,
                    maxWidth: 300
                });

                // Add click event to marker
                marker.addListener("click", () => {
                    // Close other info windows if open
                    closeAllInfoWindows();

                    // Open this info window
                    infowindow.open(map, marker);
                });

                // Store the info window with the marker
                marker.infoWindow = infowindow;
            });

            // Function to close all info windows
            function closeAllInfoWindows() {
                markers.forEach(marker => {
                    if (marker.infoWindow) {
                        marker.infoWindow.close();
                    }
                });
            }

            // Define a global function to show street view
            window.showStreetView = function (index) {
                const branch = branches[index];

                // Determine Street View position and POV
                const streetViewPosition = branch.streetViewParams?.position || branch.position;
                const streetViewPov = branch.streetViewParams?.pov || { heading: 0, pitch: 0 };

                // Check if Street View is available at this location
                const streetViewService = new google.maps.StreetViewService();

                streetViewService.getPanorama({ location: streetViewPosition, radius: 50 }, (data, status) => {
                    if (status === "OK") {
                        // Show Street View
                        document.getElementById("map").style.display = "none";
                        document.getElementById("street-view").style.display = "block";
                        document.getElementById("back-to-map").classList.remove("hidden");

                        // Set Street View position and POV
                        streetView.setPosition(data.location.latLng);
                        streetView.setPov(streetViewPov);
                        streetView.setVisible(true);
                    } else {
                        // No Street View available
                        alert("Street View is not available at this location.");

                        // Center map on location
                        map.setCenter(branch.position);
                        map.setZoom(18);
                    }
                });
            };

            // Add button click event to go back to map
            document.getElementById("back-to-map").addEventListener("click", function () {
                document.getElementById("street-view").style.display = "none";
                document.getElementById("map").style.display = "block";
                this.classList.add("hidden");
            });

            // Handle "View on map" buttons from branch cards
            document.querySelectorAll('.branchButton').forEach((button, index) => {
                button.addEventListener('click', function () {
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));
                    const position = { lat: lat, lng: lng };

                    // Center map on location with animation
                    map.panTo(position);
                    map.setZoom(18);

                    // Open marker info window
                    setTimeout(() => {
                        closeAllInfoWindows();
                        markers[index].infoWindow.open(map, markers[index]);
                    }, 500);

                    // After a short delay, show street view
                    setTimeout(() => {
                        window.showStreetView(index);
                    }, 1500);
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            // Function to position the dropdown directly below the button
            function positionDropdown() {
                const buttonRect = dropdownButton.getBoundingClientRect();

                // Position the dropdown using fixed positioning
                // This way it stays relative to the viewport, not the document
                dropdownMenu.style.position = 'fixed';
                dropdownMenu.style.top = buttonRect.bottom + 'px';
                dropdownMenu.style.left = buttonRect.left + 'px';

                // Ensure the dropdown is fully visible within the viewport
                const dropdownRect = dropdownMenu.getBoundingClientRect();
                const viewportWidth = window.innerWidth;

                // If dropdown would overflow the right edge of the viewport, align it with the right edge of the button instead
                if (buttonRect.left + dropdownRect.width > viewportWidth) {
                    dropdownMenu.style.left = (buttonRect.right - dropdownRect.width) + 'px';
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

            // Reposition dropdown on window resize or scroll
            window.addEventListener('resize', function () {
                if (!dropdownMenu.classList.contains('hidden')) {
                    positionDropdown();
                }
            });

            // Also reposition on scroll to keep the dropdown attached to the button
            window.addEventListener('scroll', function () {
                if (!dropdownMenu.classList.contains('hidden')) {
                    positionDropdown();
                }
            });

            // Setup appointment buttons
            console.log('Landing page: Initializing appointment buttons');
            
            // Define the IDs we want to target
            const appointmentButtonIds = [
                'addAppointmentBtn',         // Main button ID from dashboard (if present)
                'heroAppointmentBtn',        // Hero section button
                'ctaAppointmentBtn',         // CTA section button
                'mobileAppointmentBtn',      // Mobile menu button
                'dropdownAppointmentBtn'     // Dropdown menu button
            ];
            
            // Add click handler to each button by ID
            appointmentButtonIds.forEach(id => {
                const button = document.getElementById(id);
                
                if (button) {
                    console.log(`Landing page: Found button with ID ${id}`);
                    
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log(`Button ${id} clicked`);
                        openAppointmentModalDirect();
                    });
                }
            });
        });
    </script>
</body>

</html>