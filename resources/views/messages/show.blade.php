@extends('layouts.app')
@section('title', 'Message — Ask Yozee')

@section('content')
<div style="max-width:700px;margin:0 auto;padding:20px">

    {{-- ── BACK LINK ── --}}
    <a href="{{ route('messages') }}" style="color:var(--text3);text-decoration:none;font-size:14px;margin-bottom:20px;display:inline-flex;align-items:center;gap:6px">
        <i class="fas fa-arrow-left"></i> Back to Messages
    </a>

    {{-- ── MESSAGE CARD ── --}}
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);overflow:hidden;margin-bottom:20px">
        
        {{-- Header --}}
        <div style="background:var(--surface2);padding:20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
            <div style="flex:1">
                <h2 style="font-size:18px;font-weight:700;margin:0;margin-bottom:8px">Your Message</h2>
                <div style="font-size:13px;color:var(--text3)">
                    Sent {{ $message->created_at->format('M d, Y · h:i A') }}
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                @if($message->is_priority)
                <span style="background:var(--primary)20;color:var(--primary2);padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700">
                    ⚡ Pro Member
                </span>
                @endif

                @if($message->tool)
                <span style="background:var(--border);color:var(--text2);padding:6px 12px;border-radius:8px;font-size:12px">
                    re: {{ $message->tool->name }}
                </span>
                @endif
            </div>
        </div>

        {{-- Message Content --}}
        <div style="padding:24px">
            <p style="color:var(--text2);font-size:15px;line-height:1.6;white-space:pre-wrap;word-break:break-word">
                {{ $message->message }}
            </p>
        </div>

    </div>

    {{-- ── REPLY CARD ── --}}
    @if($message->hasReply())
    <div style="background:var(--accent)08;border:1px solid var(--accent)30;border-radius:var(--card-radius);overflow:hidden;margin-bottom:20px">
        
        {{-- Header --}}
        <div style="background:var(--accent)15;padding:20px;border-bottom:1px solid var(--accent)30">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <span style="font-size:20px">📧</span>
                <h2 style="font-size:18px;font-weight:700;margin:0">Yozee's Reply</h2>
            </div>
            
            @if(!$message->isRead())
            <div style="display:inline-block;background:var(--accent)25;color:var(--accent);padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700;text-transform:uppercase">
                🔔 New Reply
            </div>
            @else
            <div style="font-size:13px;color:var(--accent)">
                ✓ Read on {{ $message->read_at->format('M d, Y · h:i A') }}
            </div>
            @endif
        </div>

        {{-- Reply Content --}}
        <div style="padding:24px">
            <p style="color:var(--text);font-size:15px;line-height:1.6;white-space:pre-wrap;word-break:break-word">
                {{ $message->reply }}
            </p>
        </div>

    </div>
    @else
    <div style="background:var(--amber)10;border:1px solid var(--amber)30;border-radius:var(--card-radius);padding:24px;text-align:center;margin-bottom:20px">
        <div style="font-size:32px;margin-bottom:12px">⏳</div>
        <h3 style="font-size:16px;font-weight:700;margin:0 0 8px">Waiting for Reply</h3>
        <p style="color:var(--text2);margin:0">
            Yozee will reply to your message very soon. We'll notify you as soon as there's a response!
        </p>
    </div>
    @endif

    {{-- ── ACTION BUTTONS ── --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center">
        <a href="{{ route('messages') }}" class="btn btn-outline">
            ← Back to Messages
        </a>
        @if($message->hasReply())
        <a href="{{ route('suggest') }}" class="btn btn-primary">
            Ask Another Question
        </a>
        @else
        <a href="{{ route('suggest') }}" class="btn btn-primary">
            Ask Yozee Something
        </a>
        @endif
    </div>

</div>

@endsection
