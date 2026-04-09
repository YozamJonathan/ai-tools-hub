{{-- ============================================================ --}}
{{-- Admin Layout - used for admin panel (no navbar/footer)     --}}
{{-- ============================================================ --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — AI Tools Hub</title>
    <meta name="description" content="Admin dashboard for AI Tools Hub management">
    <meta name="theme-color" content="#07080f">
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Your custom CSS from the zip --}}
    <link rel="stylesheet" href="/css/style.css">
    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        /* Admin Layout - Complete Restructure */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        /* Admin Top Navbar */
        .admin-top-navbar {
            background: var(--bg2);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
            z-index: 1000;
        }

        .admin-navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-navbar-logo {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary2);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-navbar-logo-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
        }

        .admin-navbar-title {
            font-size: 14px;
            color: var(--text2);
            padding-left: 16px;
            border-left: 1px solid var(--border);
        }

        .admin-navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            background: var(--surface2);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .admin-user-details {
            display: flex;
            flex-direction: column;
        }

        .admin-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .admin-user-role {
            font-size: 11px;
            color: var(--text3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: var(--accent)20;
            border: 1px solid var(--accent)40;
            color: var(--accent2);
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .admin-logout-btn:hover {
            background: var(--accent)30;
            border-color: var(--accent)60;
        }

        .admin-logout-btn i {
            font-size: 14px;
        }

        /* Admin Container - Sidebar + Content */
        .admin-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Admin Sidebar */
        .admin-sidebar {
            width: 240px;
            background: var(--bg2);
            border-right: 1px solid var(--border);
            padding: 24px 16px;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--btn-radius);
            font-size: 14px;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .admin-nav-item:hover {
            color: var(--text);
            background: var(--surface);
        }

        .admin-nav-item.active {
            color: var(--primary2);
            background: var(--primary-glow);
        }

        .admin-nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        /* Admin Main Content */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Flash Messages */
        .admin-messages {
            flex-shrink: 0;
            z-index: 999;
        }

        .admin-messages > div {
            padding: 12px 24px;
            font-size: 14px;
            text-align: center;
        }

        /* Admin Content Area */
        .admin-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* Scrollbar Styling */
        .admin-sidebar::-webkit-scrollbar,
        .admin-content::-webkit-scrollbar {
            width: 8px;
        }

        .admin-sidebar::-webkit-scrollbar-track,
        .admin-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb,
        .admin-content::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb:hover,
        .admin-content::-webkit-scrollbar-thumb:hover {
            background: var(--text3);
        }

        /* Hamburger Menu */
        .admin-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text2);
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 8px;
            margin-left: -8px;
        }

        .admin-hamburger:hover {
            color: var(--text);
        }

        /* Mobile Sidebar Overlay */
        .admin-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .admin-sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 900px) {
            .admin-top-navbar {
                padding: 0 16px;
            }

            .admin-navbar-logo {
                font-size: 16px;
            }

            .admin-navbar-title {
                display: none;
            }

            .admin-hamburger {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .admin-user-details {
                display: none;
            }

            /* Sidebar positioned fixed/absolute on mobile */
            .admin-sidebar {
                position: fixed;
                top: 70px;
                left: -240px;
                width: 240px;
                height: calc(100vh - 70px);
                background: var(--bg2);
                border-right: 1px solid var(--border);
                padding: 24px 16px;
                overflow-y: auto;
                transition: left 0.3s ease;
                z-index: 1000;
            }

            .admin-sidebar.active {
                left: 0;
            }

            .admin-container {
                flex-direction: row;
            }

            .admin-main {
                flex: 1;
                overflow: hidden;
            }

            .admin-content {
                padding: 20px;
            }
        }

        @media (max-width: 640px) {
            .admin-top-navbar {
                padding: 0 12px;
                height: 60px;
            }

            .admin-navbar-logo {
                font-size: 14px;
                gap: 6px;
            }

            .admin-navbar-logo-dot {
                width: 6px;
                height: 6px;
            }

            .admin-logout-btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            .admin-logout-btn i {
                font-size: 12px;
            }

            .admin-sidebar {
                top: 60px;
                height: calc(100vh - 60px);
                width: 200px;
                left: -200px;
            }

            .admin-content {
                padding: 12px;
            }

            /* Responsive table */
            .data-table {
                font-size: 12px;
            }

            .data-table th,
            .data-table td {
                padding: 8px !important;
            }

            .btn {
                padding: 6px 12px !important;
                font-size: 12px !important;
            }

            .form-input {
                font-size: 14px;
            }
        }
    </style>

</head>
<body>

{{-- ── ADMIN TOP NAVBAR ── --}}
<div class="admin-top-navbar">
    <div class="admin-navbar-left">
        <button class="admin-hamburger" onclick="toggleAdminSidebar()" title="Toggle Menu">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="admin-navbar-logo">
            <div class="admin-navbar-logo-dot"></div>
            AI Tools Hub
        </a>
        <span class="admin-navbar-title">Admin Dashboard</span>
    </div>

    <div class="admin-navbar-right">
        <div class="admin-user-info">
            <div class="admin-user-avatar">
                {{ strtoupper(auth()->user()->name[0]) }}
            </div>
            <div class="admin-user-details">
                <div class="admin-user-name">{{ auth()->user()->name }}</div>
                <div class="admin-user-role">Administrator</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="admin-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </div>
</div>

{{-- ── SIDEBAR OVERLAY (MOBILE) ── --}}
<div class="admin-sidebar-overlay" onclick="toggleAdminSidebar()"></div>

{{-- ── ADMIN CONTAINER ── --}}
<div class="admin-container">
    
    {{-- ── SIDEBAR ── --}}
    <aside class="admin-sidebar">
        <nav class="admin-nav">
            <a class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="admin-nav-icon">📊</span> Dashboard
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.tools.*') ? 'active' : '' }}" href="{{ route('admin.tools.index') }}">
                <span class="admin-nav-icon">🛠</span> Tools
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.suggestions.*') ? 'active' : '' }}" href="{{ route('admin.suggestions.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--btn-radius);font-size:14px;font-weight:500;color:var(--text2);cursor:pointer;transition:var(--transition);text-decoration:none">
                <span class="admin-nav-icon">💡</span> Suggestions
                @if($pending_suggestions > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--amber)20;color:var(--amber);padding:2px 7px;border-radius:100px;font-weight:700">{{ $pending_suggestions }}</span>
                @endif
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--btn-radius);font-size:14px;font-weight:500;color:var(--text2);cursor:pointer;transition:var(--transition);text-decoration:none">
                <span class="admin-nav-icon">⭐</span> Reviews
                @if($pending_reviews > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--amber)20;color:var(--amber);padding:2px 7px;border-radius:100px;font-weight:700">{{ $pending_reviews }}</span>
                @endif
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--btn-radius);font-size:14px;font-weight:500;color:var(--text2);cursor:pointer;transition:var(--transition);text-decoration:none">
                <span class="admin-nav-icon">💬</span> Messages
                @if($pending_messages > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--accent2)20;color:var(--accent2);padding:2px 7px;border-radius:100px;font-weight:700">{{ $pending_messages }}</span>
                @endif
            </a>
            <div style="height:1px;background:var(--border);margin:12px 0"></div>
            <a class="admin-nav-item {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}" href="{{ route('admin.revenue.index') }}">
                <span class="admin-nav-icon">💰</span> Revenue
            </a>
            <a class="admin-nav-item" href="{{ route('home') }}">
                <span class="admin-nav-icon">🌐</span> View Site ↗
            </a>
        </nav>
    </aside>

    {{-- ── MAIN CONTENT AREA ── --}}
    <div class="admin-main">
        
        {{-- ── FLASH MESSAGES ── --}}
        @if(session('success') || session('error'))
        <div class="admin-messages">
            @if(session('success'))
            <div style="background:var(--accent)15;border-bottom:1px solid var(--accent)40;color:var(--accent)">
                ✓ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div style="background:var(--accent2)15;border-bottom:1px solid var(--accent2)40;color:var(--accent2)">
                ✕ {{ session('error') }}
            </div>
            @endif
        </div>
        @endif

        {{-- ── PAGE CONTENT ── --}}
        <div class="admin-content">
            @yield('content')
        </div>

    </div>

</div>

@stack('scripts')

<script>
    // Mobile Sidebar Toggle
    function toggleAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('.admin-sidebar-overlay');
        
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Close sidebar when a nav item is clicked on mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 900) {
            const navItems = document.querySelectorAll('.admin-nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Close sidebar after clicking a link on mobile
                    const sidebar = document.querySelector('.admin-sidebar');
                    const overlay = document.querySelector('.admin-sidebar-overlay');
                    
                    if (sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('.admin-sidebar-overlay');
        
        // Reset sidebar on desktop
        if (window.innerWidth > 900) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
    });
</script>

</body>
</html>
