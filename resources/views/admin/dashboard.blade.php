
@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')

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
@endsection