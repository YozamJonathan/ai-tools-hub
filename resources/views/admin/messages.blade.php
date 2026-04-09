@extends('layouts.admin')
@section('title', 'Messages — Admin')

@section('content')

    <main class="admin-content">

        <div style="margin-bottom:24px">
            <h2 style="font-size:22px;font-weight:800">Ask Yozee — Messages</h2>
            <p style="color:var(--text2);font-size:14px;margin-top:4px">
                Pro member messages appear first ⚡
            </p>
        </div>

        @if(session('success'))
        <div style="background:var(--accent)15;border:1px solid var(--accent)40;color:var(--accent);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            ✓ {{ session('success') }}
        </div>
        @endif

        @forelse($messages as $message)
        <div style="background:var(--surface);border:1px solid {{ $message->is_priority ? 'var(--amber)' : 'var(--border)' }};border-radius:var(--card-radius);padding:20px;margin-bottom:12px">

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--primary-glow);border:1px solid var(--primary)30;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--primary2);flex-shrink:0">
                    {{ strtoupper($message->user->name[0]) }}
                </div>
                <div style="flex:1">
                    <span style="font-weight:600;font-size:14px">{{ $message->user->name }}</span>
                    @if($message->is_priority)
                    <span class="pro-badge" style="margin-left:6px;font-size:10px">PRO</span>
                    @endif
                    @if($message->tool)
                    <span style="font-size:12px;color:var(--text3);margin-left:8px">
                        re: {{ $message->tool->name }}
                    </span>
                    @endif
                    <span style="font-size:12px;color:var(--text3);margin-left:8px">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
                <span class="badge badge-{{ $message->status }}">{{ $message->status }}</span>
            </div>

            <p style="font-size:14px;color:var(--text2);margin-bottom:16px;line-height:1.5">
                "{{ $message->message }}"
            </p>

            @if($message->status === 'pending')
            <form action="{{ route('admin.messages.reply', $message) }}" method="POST"
                  style="display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap">
                @csrf
                <textarea name="reply" class="form-input"
                          style="flex:1;min-width:240px;min-height:80px"
                          placeholder="Type your reply to {{ $message->user->name }}..."
                          required></textarea>
                <button type="submit" class="btn btn-primary" style="align-self:flex-end">
                    Send reply
                </button>
            </form>
            @else
            <div style="background:var(--surface2);border-left:3px solid var(--accent);padding:12px 16px;border-radius:0 8px 8px 0;font-size:13px;color:var(--text2)">
                <div style="font-size:11px;color:var(--text3);margin-bottom:4px;text-transform:uppercase;letter-spacing:.06em">Yozee replied</div>
                {{ $message->reply }}
            </div>
            @endif

        </div>
        @empty
        <div style="text-align:center;padding:64px 24px">
            <div style="font-size:48px;margin-bottom:16px">💬</div>
            <div style="font-size:18px;font-weight:700;margin-bottom:8px">No messages yet</div>
            <div style="font-size:14px;color:var(--text2)">
                When users ask Yozee questions they will appear here
            </div>
        </div>
        @endforelse

        <div style="margin-top:20px">
            {{ $messages->links() }}
        </div>

    </main>
@endsection