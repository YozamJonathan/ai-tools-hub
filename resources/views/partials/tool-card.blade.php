@php
    $savedToolIds = auth()->check()
        ? auth()->user()->collections()->with('tools')->get()
                ->flatMap(fn($c) => $c->tools->pluck('id'))->unique()
        : collect();
    $isSaved = $savedToolIds->contains($tool->id);
@endphp

<div class="tool-card">
    @if($tool->vote_count > 1000)
    <div class="tool-trending-badge">Trending</div>
    @endif

    <div class="tool-card-top">
        <div class="tool-icon">{{ $tool->emoji }}</div>
        <div class="tool-actions">
            @if($tool->created_at->isAfter(now()->subWeek()))
            <span style="background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);font-size:10px;font-weight:700;padding:3px 8px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase">New</span>
            @endif

            @auth
            <button class="tool-action-btn {{ $isSaved ? 'saved' : '' }}"
                    onclick="toggleSaveTool(this, {{ $tool->id }})"
                    title="{{ $isSaved ? 'Remove from saved' : 'Save tool' }}">
                {{ $isSaved ? '♥' : '♡' }}
            </button>
            @endauth

            <a href="{{ $tool->url }}" target="_blank" rel="noopener"
               class="tool-action-btn" title="Open tool" onclick="event.stopPropagation()">↗</a>
        </div>
    </div>

    <a href="{{ route('tools.show', $tool) }}">
        <div class="tool-name">{{ $tool->name }}</div>
    </a>

    <div class="tool-desc">{{ $tool->description }}</div>

    <div class="tool-card-footer">
        <div class="tool-cat-badge">
            {{ $tool->category->icon }} {{ $tool->category->name }}
        </div>
        <div class="tool-rating">
            <span class="tool-rating-stars">★</span>
            <span class="tool-rating-num">{{ $tool->avg_rating }}</span>
            <span class="tool-rating-count">({{ number_format($tool->vote_count) }})</span>
        </div>
    </div>
</div>

