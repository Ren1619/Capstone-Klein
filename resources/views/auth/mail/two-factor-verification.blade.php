<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two-Factor Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Two-Factor Authentication</h1>
            <p class="text-gray-600 mt-2">Please enter the verification code sent to your email</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-sm font-medium text-red-600 bg-red-50 p-3 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <input id="code" type="text" name="code"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF006E] focus:border-[#FF006E]"
                    required autofocus autocomplete="off" inputmode="numeric" pattern="[0-9]*" maxlength="6">
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('two-factor.send') }}"
                    onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                    class="text-sm text-[#FF006E] hover:text-[#e0005e] underline">
                    Resend Code
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-[#FF006E] hover:bg-[#e0005e] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF006E]">
                    Verify
                </button>
            </div>
        </form>

        <!-- Separate form for resending code -->
        <form id="resend-form" method="POST" action="{{ route('two-factor.send') }}" class="hidden">
            @csrf
        </form>
    </div>
</body>

</html>