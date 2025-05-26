<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Pelaez Derm Clinic</title>
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
            </nav>
        </div>
    </header>

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
                        <span class="text-[#FF006E] text-3xl sm:text-4xl lg:text-5xl font-bold">Reset </span>
                        <span class="text-black text-3xl sm:text-4xl lg:text-5xl font-bold">Password</span>
                    </div>
                </div>

                <div class="w-full max-w-md flex flex-col justify-start items-start gap-3.5">
                    <!-- Display validation errors if any -->
                    @if ($errors->any())
                        <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.store') }}" class="w-full">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Input -->
                        <div class="w-full h-20 py-3.5 border-b border-black flex justify-start items-end">
                            <div class="flex justify-start items-center gap-2.5 w-full">
                                <div class="w-6 h-6 relative overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                    placeholder="Email" required autocomplete="email" autofocus
                                    class="w-full border-none focus:outline-none bg-transparent text-base font-normal leading-none" />
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="w-full h-20 py-3.5 border-b border-black flex justify-start items-end">
                            <div class="flex justify-start items-center gap-2.5 w-full">
                                <div class="w-6 h-6 relative overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" placeholder="New Password" required
                                    autocomplete="new-password"
                                    class="w-full border-none focus:outline-none bg-transparent text-base font-normal leading-none" />
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="w-full h-20 py-3.5 border-b border-black flex justify-start items-end">
                            <div class="flex justify-start items-center gap-2.5 w-full">
                                <div class="w-6 h-6 relative overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    required autocomplete="new-password"
                                    class="w-full border-none focus:outline-none bg-transparent text-base font-normal leading-none" />
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="w-full h-20 py-3.5 flex flex-col justify-center items-center gap-3.5">
                            <button type="submit"
                                class="w-full h-10 px-4 py-1 bg-[#FF006E] hover:bg-[#e0005e] rounded-md flex justify-center items-center text-white text-sm font-semibold leading-none tracking-tight transition duration-200">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>