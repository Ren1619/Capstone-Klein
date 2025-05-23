@extends('layouts.app')

@section('header', 'Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
                    <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="first_name" class="block font-medium text-sm text-gray-700">First Name</label>
                            <input id="first_name" name="first_name" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ old('first_name', Auth::user()->first_name) }}" required autofocus />
                            @error('first_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block font-medium text-sm text-gray-700">Last Name</label>
                            <input id="last_name" name="last_name" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ old('last_name', Auth::user()->last_name) }}" required />
                            @error('last_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_number" class="block font-medium text-sm text-gray-700">Contact
                                Number</label>
                            <input id="contact_number" name="contact_number" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ old('contact_number', Auth::user()->contact_number) }}" required />
                            @error('contact_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" name="email" type="email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ old('email', Auth::user()->email) }}" required />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">Save</button>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-gray-600">Saved.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
                    <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay
                        secure.</p>

                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block font-medium text-sm text-gray-700">Current
                                Password</label>
                            <input id="current_password" name="current_password" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block font-medium text-sm text-gray-700">New Password</label>
                            <input id="password" name="password" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm
                                Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">Save</button>

                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-gray-600">Saved.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Two Factor Authentication') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Add additional security to your account using two factor authentication.') }}
            </p>
        </header>

        @if(!auth()->user()->two_factor_secret)
            {{-- Enable 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Enable Two-Factor') }}
                    </x-primary-button>
                </div>
            </form>
        @else
            {{-- Disable 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf
                @method('DELETE')

                <div>
                    <x-danger-button>
                        {{ __('Disable Two-Factor') }}
                    </x-danger-button>
                </div>
            </form>

            @if(session('status') == 'two-factor-authentication-enabled')
                {{-- Show QR Code --}}
                <div class="mt-4">
                    <p class="font-semibold text-sm text-gray-800">
                        {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                    </p>

                    <div class="mt-4">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                </div>
            @endif

            {{-- Show Recovery Codes --}}
            <div class="mt-4">
                <p class="font-semibold text-sm text-gray-800">
                    {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                </p>

                <div class="bg-gray-100 rounded p-3 mt-2">
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            </div>

            {{-- Regenerate Recovery Codes --}}
            <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}" class="mt-4">
                @csrf

                <div>
                    <x-secondary-button>
                        {{ __('Regenerate Recovery Codes') }}
                    </x-secondary-button>
                </div>
            </form>
        @endif
    </section>
@endsection