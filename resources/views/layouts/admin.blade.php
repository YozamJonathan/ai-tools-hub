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
            position: sticky;
            top: 0;
            z-index: 999;
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

        @media (max-width: 768px) {
            .admin-top-navbar {
                padding: 0 16px;
            }

            .admin-user-details {
                display: none;
            }

            .admin-navbar-title {
                display: none;
            }

            .admin-navbar-logo {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

{{-- ── ADMIN TOP NAVBAR ── --}}
<div class="admin-top-navbar">
    <div class="admin-navbar-left">
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

{{-- ── FLASH MESSAGES ── --}}
@if(session('success'))
<div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 24px;font-size:14px;text-align:center;position:sticky;top:70px;z-index:999">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:var(--accent2)15;border:1px solid var(--accent2)40;color:var(--accent2);padding:12px 24px;font-size:14px;text-align:center;position:sticky;top:70px;z-index:999">
    ✕ {{ session('error') }}
</div>
@endif

{{-- ── PAGE CONTENT (Admin Views) ── --}}
@yield('content')

@stack('scripts')
</body>
</html>
