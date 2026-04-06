
@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-layout">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text3);padding:0 12px;margin-bottom:12px">Overview</div>
        <nav class="admin-nav">
            <a class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <span class="admin-nav-icon">📊</span> Dashboard
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.tools.*') ? 'active' : '' }}"
               href="{{ route('admin.tools.index') }}">
                <span class="admin-nav-icon">🛠</span> Tools
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.suggestions.*') ? 'active' : '' }}"
               href="{{ route('admin.suggestions.index') }}">
                <span class="admin-nav-icon">💡</span> Suggestions
                @if($stats['pending_suggestions'] > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--amber)20;color:var(--amber);padding:2px 7px;border-radius:100px;font-weight:700">{{ $stats['pending_suggestions'] }}</span>
                @endif
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"
               href="{{ route('admin.reviews.index') }}">
                <span class="admin-nav-icon">⭐</span> Reviews
                @if($stats['pending_reviews'] > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--amber)20;color:var(--amber);padding:2px 7px;border-radius:100px;font-weight:700">{{ $stats['pending_reviews'] }}</span>
                @endif
            </a>
            <a class="admin-nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
               href="{{ route('admin.messages.index') }}">
                <span class="admin-nav-icon">💬</span> Messages
                @if($stats['pending_messages'] > 0)
                <span style="margin-left:auto;font-size:11px;background:var(--accent2)20;color:var(--accent2);padding:2px 7px;border-radius:100px;font-weight:700">{{ $stats['pending_messages'] }}</span>
                @endif
            </a>
        </nav>

        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text3);padding:0 12px;margin:24px 0 12px">Site</div>
        <nav class="admin-nav">
            <a class="admin-nav-item" href="{{ route('home') }}" target="_blank">
                <span class="admin-nav-icon">🌐</span> View Site ↗
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <main class="admin-content">
        <div style="margin-bottom:28px">
            <h2 style="font-size:24px;font-weight:800;margin-bottom:4px">
                Good {{ now()->format('G') < 12 ? 'morning' : (now()->format('G') < 17 ? 'afternoon' : 'evening') }}, Yozee 👋
            </h2>
            <p style="color:var(--text2);font-size:14px">Here's what's happening on AI Tools Hub.</p>
        </div>

        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-card-label">Total Tools</div>
                <div class="stat-card-value" style="color:var(--primary2)">{{ $stats['tools'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Members</div>
                <div class="stat-card-value" style="color:var(--accent)">{{ number_format($stats['users']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Pro Subscribers</div>
                <div class="stat-card-value" style="color:var(--amber)">{{ $stats['pro_users'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Monthly Revenue</div>
                <div class="stat-card-value" style="color:var(--accent2)">{{ number_format($stats['revenue_tzs']) }}</div>
                <div class="stat-card-change" style="color:var(--text3)">TZS</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            {{-- Pending items --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="font-family:var(--font-display);font-weight:700;font-size:16px;margin-bottom:16px">Needs attention</div>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <a href="{{ route('admin.suggestions.index') }}" style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--surface2);border-radius:10px">
                        <span style="font-size:14px">💡 {{ $stats['pending_suggestions'] }} pending suggestions</span>
                        <span style="color:var(--amber);font-size:12px;font-weight:700">Review →</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--surface2);border-radius:10px">
                        <span style="font-size:14px">⭐ {{ $stats['pending_reviews'] }} reviews awaiting approval</span>
                        <span style="color:var(--amber);font-size:12px;font-weight:700">Review →</span>
                    </a>
                    <a href="{{ route('admin.messages.index') }}" style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--surface2);border-radius:10px">
                        <span style="font-size:14px">💬 {{ $stats['pending_messages'] }} unanswered messages</span>
                        <span style="color:var(--accent2);font-size:12px;font-weight:700">Reply →</span>
                    </a>
                </div>
            </div>

            {{-- Top tools --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="font-family:var(--font-display);font-weight:700;font-size:16px;margin-bottom:16px">Top tools</div>
                <div style="display:flex;flex-direction:column;gap:8px">
                    @foreach($topTools as $i => $tool)
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="color:var(--text3);font-size:13px;width:16px">{{ $i+1 }}</span>
                        <span style="font-size:16px">{{ $tool->emoji }}</span>
                        <span style="font-size:14px;flex:1">{{ $tool->name }}</span>
                        <span style="font-size:12px;color:var(--text3)">{{ number_format($tool->vote_count) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@endsection