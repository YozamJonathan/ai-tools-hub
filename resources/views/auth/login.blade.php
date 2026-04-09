<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Welcome back</h2>
        <p class="text-gray-400 text-sm">Sign in to your account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
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
                autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" 
                class="block mt-2 w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-600 bg-slate-800 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-400 hover:text-gray-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Sign In Button -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition mt-6">
            {{ __('Sign In') }}
        </button>
    </form>

    <div class="mt-6 border-t border-slate-700 pt-6">
        <p class="text-center text-sm text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                Sign up here
            </a>
        </p>

        @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-gray-400">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif
    </div>
</x-guest-layout>
