@extends('layouts.app')
@section('title', 'My Messages — Ask Yozee')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:20px">

    {{-- ── HEADER ── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:16px">
        <div>
            <h1 style="font-size:28px;font-weight:800;margin:0">Ask Yozee Messages</h1>
            <p style="color:var(--text2);margin-top:8px">
                View your messages and replies from Yozee
            </p>
        </div>
        @if($unreadReplies > 0)
        <div style="background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);padding:12px 16px;border-radius:12px;font-weight:600">
            🔔 You have {{ $unreadReplies }} unread repl{{ $unreadReplies === 1 ? 'y' : 'ies' }}
        </div>
        @endif
    </div>

    {{-- ── MESSAGES LIST ── --}}
    @forelse($messages as $message)
    <div style="background:var(--surface);border:1px solid {{ $message->status === 'replied' && !$message->isRead() ? 'var(--accent)' : 'var(--border)' }};border-radius:var(--card-radius);padding:20px;margin-bottom:12px;transition:all 0.2s ease">
        
        {{-- Message Header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:12px;flex-wrap:wrap">
            <div style="flex:1">
                {{-- Status Badge --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap">
                    @if($message->status === 'replied')
                        @if(!$message->isRead())
                        <span style="background:var(--accent)30;color:var(--accent);padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700;text-transform:uppercase;animation:pulse 2s infinite">
                            🔔 New Reply
                        </span>
                        @else
                        <span style="background:var(--accent)15;color:var(--accent);padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700">
                            ✓ Replied
                        </span>
                        @endif
                    @else
                    <span style="background:var(--amber)15;color:var(--amber);padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700">
                        ⏳ Pending
                    </span>
                    @endif

                    @if($message->is_priority)
                    <span style="background:var(--primary)20;color:var(--primary2);padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700">
                        ⚡ Pro
                    </span>
                    @endif
                </div>

                {{-- Tool Reference --}}
                @if($message->tool)
                <div style="font-size:13px;color:var(--text2);margin-bottom:8px">
                    about: <strong>{{ $message->tool->emoji }} {{ $message->tool->name }}</strong>
                </div>
                @endif

                {{-- Date --}}
                <div style="font-size:12px;color:var(--text3)">
                    {{ $message->created_at->format('M d, Y · h:i A') }}
                </div>
            </div>

            {{-- View Button --}}
            <a href="{{ route('messages.show', $message) }}" class="btn btn-primary" style="white-space:nowrap;align-self:flex-start">
                View Message
            </a>
        </div>

        {{-- Message Preview --}}
        <p style="color:var(--text2);font-size:14px;line-height:1.5;margin:12px 0;padding:12px;background:var(--surface2);border-radius:8px;border-left:3px solid var(--primary)">
            "{{ Str::limit($message->message, 150) }}"
        </p>

        {{-- Reply Preview (if exists) --}}
        @if($message->hasReply())
        <div style="background:var(--accent)08;border-left:3px solid var(--accent);padding:12px;border-radius:6px;margin-top:12px">
            <div style="font-size:11px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px">
                📧 Yozee's Reply
            </div>
            <p style="color:var(--text2);font-size:13px;line-height:1.5;margin:0">
                {{ Str::limit($message->reply, 200) }}
            </p>
            <div style="margin-top:8px">
                <a href="{{ route('messages.show', $message) }}" style="color:var(--accent);text-decoration:none;font-size:12px;font-weight:600">
                    Read full reply →
                </a>
            </div>
        </div>
        @endif

    </div>
    @empty
    <div style="text-align:center;padding:60px 20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius)">
        <div style="font-size:48px;margin-bottom:16px">💬</div>
        <h2 style="font-size:20px;font-weight:700;margin-bottom:8px">No messages yet</h2>
        <p style="color:var(--text2);margin-bottom:20px">
            Send your first question to Yozee and get personalized replies!
        </p>
        <a href="{{ route('suggest') }}" class="btn btn-primary">
            Ask Yozee a Question
        </a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($messages->hasPages())
    <div style="margin-top:28px">
        {{ $messages->links() }}
    </div>
    @endif

</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>

@endsection
