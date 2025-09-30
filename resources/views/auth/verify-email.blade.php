@if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    button {
    min-width: 100px;
    position: relative;
    }
    button .button-text {
        visibility: visible;
    }
    button.loading .button-text {
        visibility: hidden; 
    }
    button .loading-spinner {
        display: none;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    button.loading .loading-spinner {
        display: inline-flex;
    }
</style>
<x-guest-layout>
    <div class="mb-4 text-sm text-black-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form id="resendForm" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button>
                    Verification Email
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
    <script src="{{ asset('js/verify.js') }}"></script>
</x-guest-layout>
