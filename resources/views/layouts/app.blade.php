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
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="nav-logo-dot"></div>
            AI Tools Hub
        </a>

        <form action="{{ route('home') }}" method="GET" class="nav-search">
            <span class="nav-search-icon">⌕</span>
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Search AI tools...">
        </form>

        <div class="nav-links">
            <a href="{{ route('home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Tools
            </a>
            <a href="/library"
               class="nav-link">
                Library <span class="pro-badge">Pro</span>
            </a>
            @auth
            <a href="{{ route('favorites') }}"
               class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}">
                Saved
            </a>
            @endauth
            <a href="{{ route('suggest') }}"
               class="nav-link {{ request()->routeIs('suggest') ? 'active' : '' }}">
                Suggest
            </a>
        </div>

        @guest
        <div style="display:flex;align-items:center;gap:8px">
            <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Sign in</a>
            <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Join free</a>
        </div>
        @endguest

        @auth
        <div style="display:flex;align-items:center;gap:12px">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               style="font-size:13px;color:var(--primary2)">Admin ↗</a>
            @endif
            <span style="font-size:14px;color:var(--text2)">
                Hi, <strong style="color:var(--text)">{{ auth()->user()->name }}</strong>
                @if(auth()->user()->isPro())
                <span class="pro-badge" style="margin-left:6px">Pro</span>
                @endif
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-btn nav-btn-ghost">Logout</button>
            </form>
        </div>
        @endauth
    </div>
</nav>

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

@stack('scripts')
</body>
</html>