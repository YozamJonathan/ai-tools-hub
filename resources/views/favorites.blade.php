
@extends('layouts.app')
@section('title', 'My Favorites')

@section('content')
<main class="main-content">
    <div class="main-inner">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px">
            <div>
                <h1 style="font-size:28px;font-weight:800;margin-bottom:4px">My Collections</h1>
                <p style="color:var(--text2);font-size:14px">
                    {{ $collections->count() }} collections ·
                    {{ $collections->sum(fn($c) => $c->tools->count()) }} tools saved
                </p>
            </div>
            <form action="{{ route('collections.store') }}" method="POST" style="display:flex;gap:8px">
                @csrf
                <input type="text" name="name" class="form-input" placeholder="New collection name..."
                       style="width:200px" required>
                <button type="submit" class="btn btn-outline">+ Create</button>
            </form>
        </div>

        @forelse($collections as $collection)
        <div style="margin-bottom:40px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                <div style="font-family:var(--font-display);font-size:18px;font-weight:700">
                    {{ $collection->name }}
                    <span style="font-size:14px;color:var(--text3);font-weight:400">
                        ({{ $collection->tools->count() }} tools)
                    </span>
                </div>
            </div>

            @if($collection->tools->count() > 0)
            <div class="tools-grid">
                @foreach($collection->tools as $tool)
                @include('partials.tool-card', ['tool' => $tool])
                @endforeach
            </div>
            @else
            <div class="empty-state" style="padding:32px">
                <div class="empty-icon">♡</div>
                <div class="empty-title">No tools saved yet</div>
                <div class="empty-sub">
                    <a href="{{ route('home') }}" style="color:var(--primary2)">Browse tools</a> and save your favorites
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">♡</div>
            <div class="empty-title">No collections yet</div>
            <div class="empty-sub">Create a collection above and start saving tools</div>
        </div>
        @endforelse
    </div>
</main>
@endsection
