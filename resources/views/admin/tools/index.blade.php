@extends('layouts.app')
@section('title', 'Manage Tools — Admin')

@section('content')
<div class="admin-layout">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <nav class="admin-nav">
            <a class="admin-nav-item" href="{{ route('admin.dashboard') }}">
                <span class="admin-nav-icon">📊</span> Dashboard
            </a>
            <a class="admin-nav-item active" href="{{ route('admin.tools.index') }}">
                <span class="admin-nav-icon">🛠</span> Tools
            </a>
            <a class="admin-nav-item" href="{{ route('admin.suggestions.index') }}">
                <span class="admin-nav-icon">💡</span> Suggestions
            </a>
            <a class="admin-nav-item" href="{{ route('admin.reviews.index') }}">
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

    {{-- Main Content --}}
    <main class="admin-content">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
            <h2 style="font-size:22px;font-weight:800">Manage Tools</h2>
            <a href="{{ route('admin.tools.create') }}" class="btn btn-primary">+ Add Tool</a>
        </div>

        @if(session('success'))
        <div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            ✓ {{ session('success') }}
        </div>
        @endif

        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);overflow:hidden">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Category</th>
                        <th>Rating</th>
                        <th>Votes</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tools as $tool)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span style="font-size:20px">{{ $tool->emoji }}</span>
                                <div>
                                    <div style="font-weight:600;color:var(--text)">{{ $tool->name }}</div>
                                    <div style="font-size:11px;color:var(--text3)">{{ $tool->url }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $tool->category->name ?? '—' }}</td>
                        <td style="color:var(--amber)">★ {{ $tool->avg_rating }}</td>
                        <td>{{ number_format($tool->vote_count) }}</td>
                        <td>
                            <span class="badge badge-{{ $tool->status }}">{{ $tool->status }}</span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('admin.tools.edit', $tool) }}"
                                   class="btn btn-sm btn-outline">Edit</a>
                                <form action="{{ route('admin.tools.destroy', $tool) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete {{ $tool->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background:var(--accent2)20;color:var(--accent2);border:1px solid var(--accent2)30;padding:7px 14px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--text3)">
                            No tools yet. <a href="{{ route('admin.tools.create') }}" style="color:var(--primary2)">Add the first one →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:20px">
            {{ $tools->links() }}
        </div>

    </main>
</div>
@endsection