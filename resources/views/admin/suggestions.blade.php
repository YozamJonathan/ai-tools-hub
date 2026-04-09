@extends('layouts.admin')
@section('title', 'Suggestions — Admin')

@section('content')

    <main class="admin-content">

        <div style="margin-bottom:24px">
            <h2 style="font-size:22px;font-weight:800">Tool Suggestions</h2>
            <p style="color:var(--text2);font-size:14px;margin-top:4px">
                Review and approve community-suggested tools
            </p>
        </div>

        @if(session('success'))
        <div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            ✓ {{ session('success') }}
        </div>
        @endif

        @forelse($suggestions as $suggestion)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:20px;margin-bottom:12px">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap">

                <div style="flex:1;min-width:260px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                        <span style="font-family:var(--font-display);font-size:17px;font-weight:700">
                            {{ $suggestion->tool_name }}
                        </span>
                        <span class="badge badge-{{ $suggestion->status }}">{{ $suggestion->status }}</span>
                    </div>
                    <div style="font-size:13px;color:var(--text3);margin-bottom:6px">
                        Suggested by
                        <strong style="color:var(--text2)">{{ $suggestion->user->name }}</strong>
                        · {{ $suggestion->created_at->diffForHumans() }}
                    </div>
                    @if($suggestion->description)
                    <p style="font-size:13px;color:var(--text2);margin-bottom:8px">
                        {{ $suggestion->description }}
                    </p>
                    @endif
                    <a href="{{ $suggestion->tool_url }}" target="_blank"
                       style="font-size:12px;color:var(--primary2)">
                        {{ $suggestion->tool_url }} ↗
                    </a>
                </div>

                @if($suggestion->status === 'pending')
                <div style="display:flex;gap:8px;flex-shrink:0">
                    <form action="{{ route('admin.suggestions.approve', $suggestion) }}" method="POST">
                        @csrf
                        <button type="submit"
                                style="background:var(--accent)20;color:var(--accent);border:1px solid var(--accent)30;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.suggestions.reject', $suggestion) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">
                            ✕ Reject
                        </button>
                    </form>
                </div>
                @else
                <div style="font-size:12px;color:var(--text3);padding-top:4px">
                    {{ ucfirst($suggestion->status) }}
                </div>
                @endif

            </div>
        </div>
        @empty
        <div style="text-align:center;padding:64px 24px">
            <div style="font-size:48px;margin-bottom:16px">💡</div>
            <div style="font-size:18px;font-weight:700;margin-bottom:8px">No suggestions yet</div>
            <div style="font-size:14px;color:var(--text2)">
                When users suggest new tools they will appear here
            </div>
        </div>
        @endforelse

        <div style="margin-top:20px">
            {{ $suggestions->links() }}
        </div>

    </main>
@endsection