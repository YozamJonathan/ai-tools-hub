@extends('layouts.app')
@section('title', 'Reviews — Admin')

@section('content')
<div class="admin-layout">

    <aside class="admin-sidebar">
        <nav class="admin-nav">
            <a class="admin-nav-item" href="{{ route('admin.dashboard') }}">
                <span class="admin-nav-icon">📊</span> Dashboard
            </a>
            <a class="admin-nav-item" href="{{ route('admin.tools.index') }}">
                <span class="admin-nav-icon">🛠</span> Tools
            </a>
            <a class="admin-nav-item" href="{{ route('admin.suggestions.index') }}">
                <span class="admin-nav-icon">💡</span> Suggestions
            </a>
            <a class="admin-nav-item active" href="{{ route('admin.reviews.index') }}">
                <span class="admin-nav-icon">⭐</span> Reviews
            </a>
            <a class="admin-nav-item" href="{{ route('admin.messages.index') }}">
                <span class="admin-nav-icon">💬</span> Messages
            </a>
            <a class="admin-nav-item" href="{{ route('home') }}">
                <span class="admin-nav-icon">🌐</span> View Site ↗
            </a>
        </nav>
    </aside>

    <main class="admin-content">

        <div style="margin-bottom:24px">
            <h2 style="font-size:22px;font-weight:800">Community Reviews</h2>
            <p style="color:var(--text2);font-size:14px;margin-top:4px">
                Approve or reject reviews before they go live
            </p>
        </div>

        @if(session('success'))
        <div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            ✓ {{ session('success') }}
        </div>
        @endif

        @forelse($reviews as $review)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px;margin-bottom:12px">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap">

                <div style="flex:1;min-width:260px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap">
                        <div style="width:36px;height:36px;border-radius:50%;background:var(--primary-glow);border:1px solid var(--primary)30;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--primary2);flex-shrink:0">
                            {{ strtoupper($review->user->name[0]) }}
                        </div>
                        <div>
                            <span style="font-weight:600;font-size:14px">{{ $review->user->name }}</span>
                            <span style="font-size:13px;color:var(--text3);margin-left:8px">on</span>
                            <span style="font-weight:600;color:var(--primary2);margin-left:4px">
                                {{ $review->tool->name }}
                            </span>
                        </div>
                        <span class="badge badge-{{ $review->status }}">{{ $review->status }}</span>
                        <span style="font-size:12px;color:var(--text3)">
                            {{ $review->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p style="font-size:14px;color:var(--text2);line-height:1.5">
                        "{{ $review->body }}"
                    </p>
                </div>

                @if($review->status === 'pending')
                <div style="display:flex;gap:8px;flex-shrink:0">
                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                        @csrf
                        <button type="submit"
                                style="background:var(--accent)20;color:var(--accent);border:1px solid var(--accent)30;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">
                            ✕ Reject
                        </button>
                    </form>
                </div>
                @else
                <div style="font-size:12px;color:var(--text3);padding-top:4px">
                    {{ ucfirst($review->status) }}
                </div>
                @endif

            </div>
        </div>
        @empty
        <div style="text-align:center;padding:64px 24px">
            <div style="font-size:48px;margin-bottom:16px">⭐</div>
            <div style="font-size:18px;font-weight:700;margin-bottom:8px">No reviews yet</div>
            <div style="font-size:14px;color:var(--text2)">
                When users write reviews they will appear here for approval
            </div>
        </div>
        @endforelse

        <div style="margin-top:20px">
            {{ $reviews->links() }}
        </div>

    </main>
</div>
@endsection