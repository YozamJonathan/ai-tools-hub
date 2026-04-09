@extends('layouts.admin')
@section('title', 'Revenue — Admin')

@section('content')
    {{-- Main Content --}}
    <main class="admin-content">

        <div style="margin-bottom:28px">
            <h2 style="font-size:22px;font-weight:800">Revenue Dashboard</h2>
            <p style="color:var(--text2);font-size:14px;margin-top:4px">
                Track pro subscriptions and earnings
            </p>
        </div>

        {{-- ── KEY METRICS ── --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px">
            
            {{-- Total Active Revenue --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.05em">Active Revenue</span>
                    <span style="font-size:18px">💰</span>
                </div>
                <div style="font-size:24px;font-weight:800;color:var(--primary2)">
                    {{ number_format($totalRevenue / 1000, 1) }}K TZS
                </div>
                <div style="font-size:12px;color:var(--text3);margin-top:4px">
                    From active subscriptions
                </div>
            </div>

            {{-- Active Pro Users --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.05em">Pro Users</span>
                    <span style="font-size:18px">👥</span>
                </div>
                <div style="font-size:24px;font-weight:800;color:var(--accent2)">
                    {{ $activePro }}
                </div>
                <div style="font-size:12px;color:var(--text3);margin-top:4px">
                    Currently active
                </div>
            </div>

            {{-- This Month Revenue --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.05em">This Month</span>
                    <span style="font-size:18px">📊</span>
                </div>
                <div style="font-size:24px;font-weight:800;color:var(--amber)">
                    {{ number_format($monthRevenue / 1000, 1) }}K TZS
                </div>
                <div style="font-size:12px;color:var(--text3);margin-top:4px">
                    {{ now()->format('M Y') }}
                </div>
            </div>

            {{-- Lifetime Revenue --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.05em">Lifetime</span>
                    <span style="font-size:18px">🎯</span>
                </div>
                <div style="font-size:24px;font-weight:800;color:var(--accent)">
                    {{ number_format($lifetimeRevenue / 1000, 1) }}K TZS
                </div>
                <div style="font-size:12px;color:var(--text3);margin-top:4px">
                    All time total
                </div>
            </div>

        </div>

        {{-- ── REVENUE BY PAYMENT METHOD ── --}}
        @if($revenueByMethod->count() > 0)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px;margin-bottom:24px">
            <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Revenue by Payment Method</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(160px, 1fr));gap:12px">
                @foreach($revenueByMethod as $method)
                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:14px">
                    <div style="font-size:12px;color:var(--text2);text-transform:uppercase;font-weight:600;margin-bottom:6px">
                        {{ ucfirst($method->payment_method) }}
                    </div>
                    <div style="font-size:18px;font-weight:800;color:var(--primary2)">
                        {{ $method->count }}
                    </div>
                    <div style="font-size:11px;color:var(--text3);margin-top:4px">
                        {{ number_format($method->total / 1000, 1) }}K TZS
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── RECENT SUBSCRIPTIONS ── --}}
        @if($recentSubscriptions->count() > 0)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px;margin-bottom:24px">
            <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Recent Pro Subscriptions</h3>
            <div style="space-y:12px">
                @foreach($recentSubscriptions as $sub)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border)">
                    <div style="flex:1">
                        <div style="font-weight:600;color:var(--text);font-size:14px">
                            {{ $sub->user->name }}
                        </div>
                        <div style="font-size:12px;color:var(--text3);margin-top:2px">
                            {{ $sub->created_at->format('M d, Y · h:i A') }}
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-weight:700;color:var(--primary2);font-size:14px">
                            {{ number_format($sub->amount_tzs / 1000, 1) }}K TZS
                        </div>
                        <div style="font-size:11px;color:var(--text3);margin-top:2px">
                            {{ ucfirst($sub->payment_method) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── ALL SUBSCRIPTIONS TABLE ── --}}
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);overflow:hidden">
            <div style="padding:20px;border-bottom:1px solid var(--border)">
                <h3 style="font-size:16px;font-weight:700;margin:0">All Pro Subscriptions</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Started</th>
                        <th>Expires</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                    <tr>
                        <td>
                            <div style="font-weight:600;color:var(--text)">{{ $sub->user->name }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $sub->user->email }}</div>
                        </td>
                        <td style="color:var(--primary2);font-weight:700">
                            {{ number_format($sub->amount_tzs / 1000, 1) }}K TZS
                        </td>
                        <td>
                            <span style="font-size:13px;color:var(--text2);text-transform:capitalize">
                                {{ $sub->payment_method }}
                            </span>
                        </td>
                        <td style="font-size:13px;color:var(--text3)">
                            {{ $sub->started_at->format('M d, Y') }}
                        </td>
                        <td style="font-size:13px;color:var(--text3)">
                            @if($sub->expires_at)
                                {{ $sub->expires_at->format('M d, Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $sub->status }}" style="text-transform:capitalize">
                                {{ $sub->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--text3)">
                            No subscriptions yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:20px">
            {{ $subscriptions->links() }}
        </div>

    </main>
@endsection
