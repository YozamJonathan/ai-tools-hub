<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Verify Email</h2>
        <p class="text-gray-400 text-sm">Check your email for verification link</p>
    </div>

    <div class="mb-6 p-4 bg-slate-800 border border-slate-700 rounded-lg">
        <p class="text-gray-300 text-sm">
            {{ __('Thanks for signing up! We\'ve sent a verification link to your email. Please check your inbox and click the link to verify your account. If you didn\'t receive it, we\'ll send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-green-900/30 border border-green-700 rounded-lg">
            <p class="text-green-400 text-sm font-medium">
                {{ __('A new verification link has been sent to your email!') }}
            </p>
        </div>
    @endif

    <div class="mt-8 space-y-3">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white font-medium rounded-lg border border-slate-700 transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
