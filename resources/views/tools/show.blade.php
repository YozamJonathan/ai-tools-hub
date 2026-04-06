
@extends('layouts.app')

@section('title', $tool->name)
@section('description', $tool->description)

@section('content')
<div class="detail-hero">
    <div class="detail-hero-inner">
        <div class="detail-icon">{{ $tool->emoji }}</div>
        <div class="detail-info">
            <div class="detail-name">{{ $tool->name }}</div>
            <div class="detail-meta">
                <span class="tool-cat-badge">
                    {{ $tool->category->icon }} {{ $tool->category->name }}
                </span>
                <span style="color:var(--amber)">★ {{ $tool->avg_rating }}</span>
                <span style="font-size:13px;color:var(--text3)">
                    {{ number_format($tool->vote_count) }} upvotes
                </span>
            </div>
            <p class="detail-desc">{{ $tool->description }}</p>
            <div class="detail-actions">
                <a href="{{ $tool->url }}" target="_blank" rel="noopener"
                   class="btn btn-primary">
                    Visit {{ $tool->name }} ↗
                </a>
                @auth
                <button class="btn btn-outline"
                        onclick="toggleSaveTool(this, {{ $tool->id }})">
                    {{ $userSaved ? '♥ Saved' : '♡ Save' }}
                </button>
                <button class="btn btn-outline"
                        onclick="toggleUpvote(this, {{ $tool->id }})">
                    ▲ {{ number_format($tool->vote_count) }}
                </button>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="btn btn-outline">Sign in to save</a>
                @endguest
            </div>
        </div>
    </div>
</div>

<main class="main-content">
    <div style="max-width:900px;margin:0 auto">

        {{-- Rate this tool --}}
        @auth
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px;margin-bottom:24px">
            <div style="font-weight:700;margin-bottom:12px">Rate this tool</div>
            <div style="display:flex;align-items:center;gap:12px">
                <div class="star-input" id="star-input">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" class="star-btn {{ $userRating && $userRating->stars >= $i ? 'active' : '' }}"
                            onclick="submitRating({{ $tool->id }}, {{ $i }})">★</button>
                    @endfor
                </div>
                @if($userRating)
                <span style="font-size:13px;color:var(--text3)">Your rating: {{ $userRating->stars }}/5</span>
                @endif
            </div>
        </div>
        @endauth

        {{-- Reviews --}}
        <div style="margin-bottom:32px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <div class="section-title">Community Reviews
                    <span class="section-title-accent">{{ $reviews->count() }} reviews</span>
                </div>
                @auth
                <button class="btn btn-sm btn-outline"
                        onclick="document.getElementById('review-form').scrollIntoView({behavior:'smooth'})">
                    Write a review
                </button>
                @endauth
            </div>

            @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-user">
                        <div class="review-avatar">{{ strtoupper($review->user->name[0]) }}</div>
                        <div>
                            <div class="review-name">{{ $review->user->name }}</div>
                            <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class="review-body">{{ $review->body }}</div>
            </div>
            @empty
            <div style="text-align:center;padding:32px;color:var(--text3)">
                No reviews yet. Be the first to review this tool!
            </div>
            @endforelse
        </div>

        {{-- Write Review Form --}}
        @auth
        <div id="review-form" style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:24px">
            <div style="font-family:var(--font-display);font-size:18px;font-weight:700;margin-bottom:16px">Write a Review</div>
            <form action="{{ route('reviews.store', $tool) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Your review</label>
                    <textarea name="body" class="form-input form-textarea"
                              placeholder="Share your honest experience with {{ $tool->name }}..."
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
        @endauth

        {{-- Ask Yozee --}}
        @auth
        <div style="margin-top:24px;background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:24px">
            <div style="font-family:var(--font-display);font-size:18px;font-weight:700;margin-bottom:8px">Ask Yozee</div>
            <p style="font-size:14px;color:var(--text2);margin-bottom:16px">Have a question about {{ $tool->name }}? Ask Yozee directly.</p>
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tool_id" value="{{ $tool->id }}">
                <div class="form-group">
                    <textarea name="message" class="form-input form-textarea"
                              placeholder="What would you like to know?" required></textarea>
                </div>
                <button type="submit" class="btn btn-outline">
                    Send question
                    @if(auth()->user()->isPro())
                    <span style="font-size:11px;color:var(--amber)">⚡ Priority reply</span>
                    @endif
                </button>
            </form>
        </div>
        @endauth

    </div>
</main>

@push('scripts')
<script>
function submitRating(toolId, stars) {
    // Highlight stars
    document.querySelectorAll('#star-input .star-btn').forEach((btn, i) => {
        btn.classList.toggle('active', i < stars);
    });
    // Send to backend
    fetch(`/tools/${toolId}/rate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ stars })
    })
    .then(r => r.json())
    .then(data => {
        console.log('New avg:', data.avg);
    });
}

function toggleUpvote(btn, toolId) {
    fetch(`/tools/${toolId}/upvote`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = `▲ ${data.count.toLocaleString()}`;
    });
}
</script>
@endpush
@endsection
