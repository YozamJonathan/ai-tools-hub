{{-- ============================================================ --}}
{{-- The master layout - all pages extend this                  --}}
{{-- ============================================================ --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Tools Hub') — Discover & Master AI</title>
    <meta name="description" content="@yield('description', 'The best AI tools directory. Discover, save, and learn about hundreds of AI tools.')">
    <meta name="theme-color" content="#07080f">
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Your custom CSS from the zip --}}
    <link rel="stylesheet" href="/css/style.css">
    @stack('styles')
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-700" x-data="{ mobileMenuOpen: false }" @keydown.escape="mobileMenuOpen = false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Left: Logo + Hamburger -->
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button (md:hidden = hidden on ≥768px) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800 transition">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-white hover:text-gray-100">
                    <div class="w-2 h-2 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50"></div>
                    AI Tools Hub
                </a>
            </div>

            <!-- Center: Search Bar (hidden on mobile) -->
            <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 max-w-md mx-4">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search AI tools..."
                           class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                    <span class="absolute right-3 top-2.5 text-gray-500">⌕</span>
                </div>
            </form>

            <!-- Right: Desktop Nav + Auth (hidden on mobile, shown on md+) -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3 py-2 text-gray-300 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm {{ request()->routeIs('home') ? 'text-white bg-slate-800' : '' }}">Tools</a>
                <a href="/library" class="px-3 py-2 text-gray-300 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm">Library <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded ml-1">Pro</span></a>
                
                @auth
                <a href="{{ route('favorites') }}" class="px-3 py-2 text-gray-300 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm {{ request()->routeIs('favorites') ? 'text-white bg-slate-800' : '' }}">Saved</a>
                
                <a href="{{ route('messages') }}" class="relative px-3 py-2 text-gray-300 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm {{ request()->routeIs('messages*') ? 'text-white bg-slate-800' : '' }}">
                    Messages
                    @php $unreadCount = auth()->check() ? auth()->user()->messages()->where('status', 'replied')->whereNull('read_at')->count() : 0; @endphp
                    @if($unreadCount > 0)
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">{{ $unreadCount }}</span>
                    @endif
                </a>
                @endauth
                
                <a href="{{ route('suggest') }}" class="px-3 py-2 text-gray-300 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm {{ request()->routeIs('suggest') ? 'text-white bg-slate-800' : '' }}">Suggest</a>
            </div>

            <!-- Right: Auth Buttons (hidden on mobile) -->
            <div class="hidden md:flex items-center gap-2">
                @guest
                <a href="{{ route('login') }}" class="px-3 py-2 text-gray-300 hover:text-white border border-slate-700 rounded-lg transition hover:bg-slate-800 text-sm">Sign in</a>
                <a href="{{ route('register') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-sm">Join free</a>
                @endguest

                @auth
                <div class="flex items-center gap-2 pl-3 border-l border-slate-700">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-xs text-blue-400 hover:text-blue-300">Admin ↗</a>
                    @endif
                    <span class="text-xs text-gray-300">
                        Hi, <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->isPro())
                        <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded ml-1">Pro</span>
                        @endif
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-2 py-1 text-xs text-gray-300 hover:text-white border border-slate-700 rounded transition hover:bg-slate-800">Logout</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Category Filter Bar (Sticky below nav, only on home/tools page) -->
    @if(request()->routeIs('home'))
    <div class="border-t border-slate-700 bg-slate-900/50 backdrop-blur sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 overflow-x-auto py-3 scrollbar-hide">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-1.5 {{ !request('category') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800' }} rounded-full transition whitespace-nowrap text-sm font-medium">
                    <span>✦</span>
                    All Tools
                </a>
                
                @php
                    $allCategories = \App\Models\Category::withCount('tools')->get();
                @endphp
                
                @forelse($allCategories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}" class="inline-flex items-center gap-2 px-4 py-1.5 {{ request('category') === $cat->slug ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800' }} rounded-full transition whitespace-nowrap text-sm font-medium">
                    <span>{{ $cat->icon }}</span>
                    {{ $cat->name }}
                </a>
                @empty
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- Mobile Menu (only visible when mobileMenuOpen=true AND on mobile screen) -->
    <div x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" class="md:hidden bg-slate-800 border-t border-slate-700 max-h-[calc(100vh-64px)] overflow-y-auto">
        <div class="px-4 py-4 space-y-2">
            <!-- Search on mobile -->
            <form action="{{ route('home') }}" method="GET" class="mb-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search AI tools..."
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition text-sm">
                    <span class="absolute right-3 top-2.5 text-gray-500">⌕</span>
                </div>
            </form>

            <!-- Mobile Nav Links -->
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition text-sm {{ request()->routeIs('home') ? 'text-white bg-slate-700' : '' }}">Tools</a>
            <a href="/library" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition text-sm">Library <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded ml-1">Pro</span></a>
            
            @auth
            <a href="{{ route('favorites') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition text-sm {{ request()->routeIs('favorites') ? 'text-white bg-slate-700' : '' }}">Saved</a>
            
            <a href="{{ route('messages') }}" @click="mobileMenuOpen = false" class="flex justify-between items-center px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition text-sm {{ request()->routeIs('messages*') ? 'text-white bg-slate-700' : '' }}">
                Messages
                @if($unreadCount > 0)
                <span class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount }}</span>
                @endif
            </a>
            @endauth
            
            <a href="{{ route('suggest') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition text-sm {{ request()->routeIs('suggest') ? 'text-white bg-slate-700' : '' }}">Suggest</a>

            <hr class="my-4 border-slate-700">

            <!-- Mobile Auth -->
            @guest
            <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-center text-gray-300 hover:text-white border border-slate-600 rounded-lg transition hover:bg-slate-700 text-sm">Sign in</a>
            <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-center bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-sm">Join free</a>
            @endguest

            @auth
            <div class="space-y-2 text-sm text-gray-300">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 text-blue-400 hover:text-blue-300 text-xs">Admin ↗</a>
                @endif
                <div class="px-4 py-2 text-xs">
                    Hi, <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->isPro())
                    <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded ml-1">Pro</span>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-gray-300 hover:text-white border border-slate-600 rounded-lg transition hover:bg-slate-700 text-sm">Logout</button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>

{{-- Page Content --}}

{{-- ── FLASH MESSAGES ── --}}
@if(session('success'))
<div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 24px;font-size:14px;text-align:center">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:var(--accent2)15;border:1px solid var(--accent2)40;color:var(--accent2);padding:12px 24px;font-size:14px;text-align:center">
    ✕ {{ session('error') }}
</div>
@endif

{{-- ── PAGE CONTENT ── --}}
@yield('content')

{{-- ── FOOTER ── --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="footer-logo">
                <div class="nav-logo-dot"></div>
                AI Tools Hub
            </div>
            <p class="footer-desc">
                The go-to directory for discovering and learning about AI tools.
                Built for students, creators, and developers.
            </p>
            <div class="footer-social">
                <a class="footer-social-btn" href="https://instagram.com" target="_blank">📸</a>
                <a class="footer-social-btn" href="mailto:hello@aitoolshub.com">✉</a>
                <a class="footer-social-btn" href="#">🌐</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Platform</div>
            <div class="footer-links">
                <a class="footer-link" href="{{ route('home') }}">Browse Tools</a>
                <a class="footer-link" href="/library">Pro Library</a>
                @auth
                <a class="footer-link" href="{{ route('favorites') }}">My Favorites</a>
                @endauth
                <a class="footer-link" href="{{ route('suggest') }}">Suggest a Tool</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Community</div>
            <div class="footer-links">
                @guest
                <a class="footer-link" href="{{ route('login') }}">Sign In</a>
                <a class="footer-link" href="{{ route('register') }}">Create Account</a>
                @endguest
                @auth
                <a class="footer-link" href="{{ route('messages') }}">Ask Yozee</a>
                @endauth
            </div>
        </div>
        <div>
            <div class="footer-col-title">Built by Yozee</div>
            <div class="footer-links">
                <a class="footer-link" href="https://instagram.com" target="_blank">Instagram →</a>
                <a class="footer-link" href="#">Portfolio →</a>
                <a class="footer-link" href="mailto:hello@aitoolshub.com">Contact</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} AI Tools Hub · Built with passion by Yozee</span>
        <span>Dar es Salaam, Tanzania 🇹🇿</span>
    </div>
</footer>

{{-- ── NOTIFICATION TOAST CONTAINER ── --}}
<div id="notification-toast" style="position:fixed;top:20px;right:20px;z-index:10000;display:none;background:var(--accent);color:white;padding:16px 24px;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,0.15);animation:slideIn 0.3s ease;max-width:320px">
    <div style="display:flex;align-items:center;gap:12px">
        <span style="font-size:18px">🔔</span>
        <div>
            <div style="font-weight:700;font-size:14px" id="toast-message">New message</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:2px" id="toast-details"></div>
        </div>
    </div>
</div>

@stack('scripts')

<script>
// Real-time Notification System
@auth
(function() {
    let lastUnreadCount = 0;
    let isPolling = true;

    // Show notification toast
    function showNotification(message, details = '') {
        const toast = document.getElementById('notification-toast');
        const msgEl = document.getElementById('toast-message');
        const detailsEl = document.getElementById('toast-details');

        msgEl.textContent = message;
        detailsEl.textContent = details;

        toast.style.display = 'flex';

        // Auto-hide after 5 seconds
        setTimeout(() => {
            toast.style.display = 'none';
        }, 5000);
    }

    // Check for unread notifications
    async function checkNotifications() {
        if (!isPolling) return;

        try {
            const response = await fetch('{{ route("notifications.unread") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) return;

            const data = await response.json();
            const currentUnreadCount = data.unread_messages || 0;

            // Update navbar badge
            const badge = document.querySelector('[id="message-badge"]');
            if (badge) {
                if (currentUnreadCount > 0) {
                    badge.textContent = currentUnreadCount;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }

            // Show notification if new unread messages
            if (currentUnreadCount > lastUnreadCount && lastUnreadCount > 0) {
                const newMessages = currentUnreadCount - lastUnreadCount;
                showNotification(
                    `You have ${newMessages} new repl${newMessages === 1 ? 'y' : 'ies'}`,
                    'Click on Messages to view'
                );
            }

            lastUnreadCount = currentUnreadCount;
        } catch (error) {
            console.error('Notification error:', error);
        }
    }

    // Initial check
    checkNotifications();

    // Poll every 5 seconds
    setInterval(checkNotifications, 5000);

    // Stop polling when page is hidden
    document.addEventListener('visibilitychange', function() {
        isPolling = !document.hidden;
        if (isPolling) {
            checkNotifications();
        }
    });
})();
@endauth
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes pulse-badge {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(var(--accent-rgb), 0.7);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(var(--accent-rgb), 0);
    }
}
</style>

</body>
</html>