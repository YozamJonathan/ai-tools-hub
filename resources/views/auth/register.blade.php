<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Create Account</h2>
        <p class="text-gray-400 text-sm">Join AI Tools Hub to save favorites and access Pro features</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="passwordValidator()">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" 
                class="block mt-2 w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password with Real-time Strength Meter -->
        <div>
            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" />
                    <span class="text-xs px-2 py-1 rounded" :class="{
                        'bg-red-900/30 text-red-400': strength === 'weak',
                        'bg-yellow-900/30 text-yellow-400': strength === 'fair',
                        'bg-blue-900/30 text-blue-400': strength === 'good',
                        'bg-green-900/30 text-green-400': strength === 'strong',
                        'text-gray-500': !password
                    }">
                        <span x-text="password ? strength.charAt(0).toUpperCase() + strength.slice(1) : 'Password'"></span>
                    </span>
                </div>

                <input id="password" 
                    type="password"
                    name="password"
                    @input="password = $el.value; checkStrength()"
                    x-model="password"
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="block mt-2 w-full px-4 py-2 bg-slate-800 rounded-lg text-white placeholder-gray-500 focus:outline-none transition"
                    :class="{
                        'border-2 border-red-500 focus:border-red-500': strength === 'weak',
                        'border-2 border-yellow-500 focus:border-yellow-500': strength === 'fair',
                        'border-2 border-blue-500 focus:border-blue-500': strength === 'good',
                        'border-2 border-green-500 focus:border-green-500': strength === 'strong',
                        'border border-slate-700': !password
                    }" />

                <!-- Strength Meter -->
                <div class="mt-3 space-y-2">
                    <!-- Visual Bar -->
                    <div class="h-1.5 bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-300" 
                            :class="{
                                'w-1/4 bg-red-500': strength === 'weak',
                                'w-2/4 bg-yellow-500': strength === 'fair',
                                'w-3/4 bg-blue-500': strength === 'good',
                                'w-full bg-green-500': strength === 'strong',
                                'w-0': !password
                            }">
                        </div>
                    </div>

                    <!-- Requirements Checklist -->
                    <div class="text-xs space-y-1">
                        <div class="flex items-center gap-2" :class="length8 ? 'text-green-400' : 'text-gray-500'">
                            <svg class="w-4 h-4" :class="{'hidden': !length8}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span :class="{'hidden': !length8}" class="hidden">✓</span>
                            <span>At least 8 characters (<span x-text="password.length"></span> of 8)</span>
                        </div>

                        <div class="flex items-center gap-2" :class="hasUppercase ? 'text-green-400' : 'text-gray-500'">
                            <svg class="w-4 h-4" :class="{'hidden': !hasUppercase}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span :class="{'hidden': !hasUppercase}" class="hidden">✓</span>
                            <span>Uppercase letter (A-Z)</span>
                        </div>

                        <div class="flex items-center gap-2" :class="hasLowercase ? 'text-green-400' : 'text-gray-500'">
                            <svg class="w-4 h-4" :class="{'hidden': !hasLowercase}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span :class="{'hidden': !hasLowercase}" class="hidden">✓</span>
                            <span>Lowercase letter (a-z)</span>
                        </div>

                        <div class="flex items-center gap-2" :class="hasNumber ? 'text-green-400' : 'text-gray-500'">
                            <svg class="w-4 h-4" :class="{'hidden': !hasNumber}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span :class="{'hidden': !hasNumber}" class="hidden">✓</span>
                            <span>Number (0-9)</span>
                        </div>

                        <div class="flex items-center gap-2" :class="hasSpecial ? 'text-green-400' : 'text-gray-500'">
                            <svg class="w-4 h-4" :class="{'hidden': !hasSpecial}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span :class="{'hidden': !hasSpecial}" class="hidden">✓</span>
                            <span>Special char (!@#$%^&*)</span>
                        </div>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" 
                class="block mt-2 w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition"
                type="password"
                name="password_confirmation" 
                @input="passwordMatch = $el.value === password"
                x-model="passwordConfirm"
                required 
                autocomplete="new-password"
                placeholder="••••••••" />
            <div x-show="passwordConfirm" class="mt-2 text-xs" :class="passwordMatch ? 'text-green-400' : 'text-red-400'">
                <span x-show="!passwordMatch">❌ Passwords do not match</span>
                <span x-show="passwordMatch">✓ Passwords match</span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Sign Up Button (disabled if weak password or mismatch) -->
        <button type="submit" 
            class="w-full px-4 py-2 font-medium rounded-lg transition"
            :class="(strength === 'strong' && passwordMatch) ? 'bg-blue-600 hover:bg-blue-700 text-white cursor-pointer' : 'bg-slate-700 text-gray-400 cursor-not-allowed opacity-50'"
            :disabled="strength !== 'strong' || (passwordConfirm && !passwordMatch)">
            <span x-show="!password || strength !== 'strong'">Create Strong Password</span>
            <span x-show="password && strength === 'strong' && !passwordConfirm">{{ __('Sign Up') }}</span>
            <span x-show="password && strength === 'strong' && passwordConfirm && !passwordMatch">Passwords Don't Match</span>
            <span x-show="password && strength === 'strong' && passwordConfirm && passwordMatch">{{ __('Sign Up') }}</span>
        </button>
    </form>

    <div class="mt-6 border-t border-slate-700 pt-6 text-center">
        <p class="text-sm text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                Sign in here
            </a>
        </p>
    </div>

    <!-- Alpine.js Password Validator -->
    <script>
        function passwordValidator() {
            return {
                password: '',
                passwordConfirm: '',
                passwordMatch: false,
                strength: '',
                length8: false,
                hasUppercase: false,
                hasLowercase: false,
                hasNumber: false,
                hasSpecial: false,

                checkStrength() {
                    const pwd = this.password;
                    
                    // Check individual requirements
                    this.length8 = pwd.length >= 8;
                    this.hasUppercase = /[A-Z]/.test(pwd);
                    this.hasLowercase = /[a-z]/.test(pwd);
                    this.hasNumber = /[0-9]/.test(pwd);
                    this.hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pwd);

                    // Calculate strength
                    const checks = [this.length8, this.hasUppercase, this.hasLowercase, this.hasNumber, this.hasSpecial];
                    const metRequirements = checks.filter(Boolean).length;

                    if (pwd.length === 0) {
                        this.strength = '';
                    } else if (pwd.length < 8) {
                        this.strength = 'weak';
                    } else if (metRequirements === 1 || metRequirements === 2) {
                        this.strength = 'weak';
                    } else if (metRequirements === 3) {
                        this.strength = 'fair';
                    } else if (metRequirements === 4) {
                        this.strength = 'good';
                    } else if (metRequirements === 5) {
                        this.strength = 'strong';
                    }
                }
            }
        }
    </script>
</x-guest-layout>
