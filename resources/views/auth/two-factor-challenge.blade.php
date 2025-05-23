<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application or one of your recovery codes.') }}
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="mt-4" x-data="{ recovery: false }">
                <x-input-label for="code" :value="__('Code')" x-show="! recovery" />
                <x-text-input id="code" 
                              class="block mt-1 w-full"
                              type="text"
                              inputmode="numeric"
                              name="code"
                              autofocus
                              autocomplete="one-time-code"
                              x-show="! recovery" />

                <x-input-label for="recovery_code" :value="__('Recovery Code')" x-show="recovery" />
                <x-text-input id="recovery_code" 
                              class="block mt-1 w-full"
                              type="text"
                              name="recovery_code"
                              x-show="recovery" />

                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button"
                        class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-data=""
                        x-on:click="$el.innerText = recovery ? 'Use an authentication code' : 'Use a recovery code'; recovery = !recovery">
                    {{ __('Use a recovery code') }}
                </button>

                <x-primary-button class="ml-4">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>