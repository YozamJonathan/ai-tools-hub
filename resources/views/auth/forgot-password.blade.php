<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Reset Password</h2>
        <p class="text-gray-400 text-sm">Enter your email and we'll send you a link to reset your password</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition mt-6">
            {{ __('Send Reset Link') }}
        </button>
    </form>

    <div class="mt-6 border-t border-slate-700 pt-6 text-center">
        <p class="text-sm text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                Back to login
            </a>
        </p>
    </div>
</x-guest-layout>
