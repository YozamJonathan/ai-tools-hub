
@extends('layouts.app')

@section('title', 'AI Tools Hub')

@section('content')

{{-- Category Bar --}}
<div class="category-bar">
    <div class="category-bar-inner">
        <a href="{{ route('home') }}"
           class="cat-tab {{ !request('category') ? 'active' : '' }}">
            <span class="cat-tab-emoji">✦</span> All Tools
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}"
           class="cat-tab {{ request('category') === $cat->slug ? 'active' : '' }}">
            <span class="cat-tab-emoji">{{ $cat->icon }}</span>
            {{ $cat->name }}
            <span style="font-size:11px;color:var(--text3)">({{ $cat->tools_count }})</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Hero --}}
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-badge">
        <div class="hero-badge-dot"></div>
        Updated weekly
    </div>
    <h1>
        Discover the best<br>
        <span class="gradient-text">AI tools</span> for your work
    </h1>
    <p class="hero-sub">
        Browse hundreds of AI tools. Save favorites, read real reviews,
        and learn with Pro tutorials.
    </p>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-num">{{ \App\Models\Tool::approved()->count() }}+</div>
            <div class="hero-stat-label">AI Tools</div>
        </div>
        <div class="hero-divider"></div>
        <div class="hero-stat">
            <div class="hero-stat-num">{{ \App\Models\Category::count() }}</div>
            <div class="hero-stat-label">Categories</div>
        </div>
        <div class="hero-divider"></div>
        <div class="hero-stat">
            <div class="hero-stat-num">{{ number_format(\App\Models\User::count()) }}</div>
            <div class="hero-stat-label">Members</div>
        </div>
        <div class="hero-divider"></div>
        <div class="hero-stat">
            <div class="hero-stat-num">{{ \App\Models\Review::where('status','approved')->count() }}</div>
            <div class="hero-stat-label">Reviews</div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<main class="main-content">
    <div class="main-inner">

        {{-- New tools banner --}}
        @if($newTools->count() > 0)
        <div class="new-banner">
            <div class="new-banner-badge">🆕 This Week</div>
            <div class="new-banner-text">
                <strong>{{ $newTools->count() }} new AI tools</strong> added this week
                — including {{ $newTools->take(3)->pluck('name')->join(', ') }}.
            </div>
            <div class="new-banner-count">+{{ $newTools->count() }}</div>
        </div>
        @endif

        {{-- Trending --}}
        @if($trending->count() > 0)
        <div class="section">
            <div class="section-header">
                <div class="section-title">🔥 Trending Now
                    <span class="section-title-accent">Most upvoted</span>
                </div>
            </div>
            <div class="trending-row">
                @foreach($trending as $i => $tool)
                <a href="{{ route('tools.show', $tool) }}" class="trending-card">
                    <div class="trending-rank {{ $i < 3 ? 'top' : '' }}">#{{ $i+1 }}</div>
                    <div class="trending-info">
                        <div class="trending-name">{{ $tool->name }}</div>
                        <div class="trending-meta">{{ number_format($tool->vote_count) }} upvotes</div>
                    </div>
                    <div class="trending-icon">{{ $tool->emoji }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- All tools grid --}}
        <div class="section">
            <div class="section-header">
                <div class="section-title">
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ ucfirst(request('category')) }} Tools
                    @else
                        All Tools
                    @endif
                    <span class="section-title-accent">{{ $tools->total() }} tools</span>
                </div>
            </div>

            @if($tools->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <div class="empty-title">No tools found</div>
                <div class="empty-sub">Try a different search or category</div>
            </div>
            @else
            <div class="tools-grid card-stagger">
                @foreach($tools as $tool)
                @include('partials.tool-card', ['tool' => $tool])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="margin-top:32px">
                {{ $tools->withQueryString()->links() }}
            </div>
            @endif
        </div>

        {{-- Pro Upsell --}}
        @guest
        <div class="pro-upsell">
            <div class="pro-badge" style="font-size:12px;padding:5px 14px;margin-bottom:16px;display:inline-flex">
                ⚡ Pro
            </div>
            <h2 style="font-size:28px;margin-bottom:8px">Level up with Pro</h2>
            <p style="color:var(--text2);font-size:15px;max-width:480px;margin:0 auto 20px">
                AI tutorials, engineering books, tool comparisons — all in one place.
            </p>
            <div class="pro-upsell-price">
                5,000 <span>TZS/month</span>
            </div>
            <p style="color:var(--text3);font-size:13px;margin-bottom:24px">≈ $1.94 USD · Cancel anytime</p>
            <a href="{{ route('register') }}" class="btn btn-accent btn-lg">Start free →</a>
        </div>
        @endguest

    </div>
</main>

@endsection 
