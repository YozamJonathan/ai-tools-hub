@extends('layouts.app')
@section('title', 'Pro Library')

@section('content')

<section style="background:linear-gradient(135deg,var(--bg2) 0%,#1a1528 100%);border-bottom:1px solid var(--border);padding:56px 24px;text-align:center;position:relative;overflow:hidden">
    <div style="position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,var(--primary)15,transparent 70%);pointer-events:none"></div>
    <div class="pro-badge" style="font-size:13px;padding:6px 16px;margin-bottom:20px;display:inline-flex">⚡ Pro Library</div>
    <h1 style="font-size:clamp(32px,5vw,56px);margin-bottom:12px">
        Master AI. <span style="background:linear-gradient(135deg,var(--primary2),var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Learn fast.</span>
    </h1>
    <p style="font-size:17px;color:var(--text2);max-width:500px;margin:0 auto 32px">
        Tutorials, AI engineering books, and deep dives — all in one place.
    </p>
    <div style="display:flex;align-items:center;justify-content:center;gap:24px;flex-wrap:wrap">
        <span style="font-size:13px;color:var(--text3)">✓ 60+ tutorials</span>
        <span style="font-size:13px;color:var(--text3)">✓ 20+ books</span>
        <span style="font-size:13px;color:var(--text3)">✓ New content weekly</span>
    </div>
</section>

<main class="main-content">
    <div class="main-inner">

        @auth
        @if(!auth()->user()->isPro())
        {{-- Paywall banner --}}
        <div style="background:linear-gradient(135deg,var(--surface),#1a1528);border:1px solid var(--primary)30;border-radius:var(--card-radius);padding:28px 32px;margin-bottom:32px;display:flex;align-items:center;gap:24px;flex-wrap:wrap">
            <div style="flex:1;min-width:260px">
                <div style="font-family:var(--font-display);font-size:20px;font-weight:800;margin-bottom:6px">Unlock the full Pro Library</div>
                <p style="font-size:14px;color:var(--text2)">Get access to all tutorials and books for just 5,000 TZS/month (≈$1.94).</p>
            </div>
            <div style="display:flex;align-items:center;gap:16px;flex-shrink:0">
                <div style="text-align:center">
                    <div style="font-family:var(--font-display);font-size:28px;font-weight:800">5,000</div>
                    <div style="font-size:12px;color:var(--text3)">TZS/month</div>
                </div>
                <a href="#upgrade" class="btn btn-accent">Upgrade to Pro →</a>
            </div>
        </div>
        @endif
        @endauth

        @guest
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:40px;text-align:center;margin-bottom:32px">
            <div style="font-size:40px;margin-bottom:16px">🔒</div>
            <div style="font-size:20px;font-weight:800;margin-bottom:8px">Create a free account first</div>
            <p style="color:var(--text2);font-size:14px;margin-bottom:20px">Sign in or register to access the Pro Library</p>
            <div style="display:flex;gap:10px;justify-content:center">
                <a href="{{ route('register') }}" class="btn btn-primary">Join free</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Sign in</a>
            </div>
        </div>
        @endguest

        {{-- Tutorials Section --}}
        <div class="section">
            <div class="section-header">
                <div class="section-title">📹 Tutorials
                    <span class="section-title-accent">Step-by-step guides</span>
                </div>
            </div>
            <div class="tools-grid">
                @foreach([
                    ['emoji'=>'🤖','title'=>'Getting Started with ChatGPT','diff'=>'beginner','time'=>'20 min','free'=>true],
                    ['emoji'=>'🎨','title'=>'Midjourney Masterclass','diff'=>'intermediate','time'=>'45 min','free'=>false],
                    ['emoji'=>'🧠','title'=>'Prompt Engineering for LLMs','diff'=>'advanced','time'=>'60 min','free'=>false],
                    ['emoji'=>'💻','title'=>'Build with OpenAI API','diff'=>'intermediate','time'=>'90 min','free'=>false],
                    ['emoji'=>'🎬','title'=>'AI Video with Runway ML','diff'=>'beginner','time'=>'35 min','free'=>false],
                    ['emoji'=>'🔍','title'=>'Perplexity for Research','diff'=>'beginner','time'=>'15 min','free'=>true],
                ] as $tutorial)
                <div class="tool-card" style="position:relative">
                    @if(!$tutorial['free'] && !(auth()->check() && auth()->user()->isPro()))
                    <div style="position:absolute;top:12px;right:12px;background:var(--surface2);border:1px solid var(--border);padding:3px 8px;border-radius:100px;font-size:11px;color:var(--text3)">🔒 Pro</div>
                    @endif
                    @if($tutorial['free'])
                    <div style="position:absolute;top:12px;right:12px;background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);padding:3px 8px;border-radius:100px;font-size:11px;font-weight:700">Free</div>
                    @endif
                    <div class="tool-icon" style="font-size:28px">{{ $tutorial['emoji'] }}</div>
                    <div class="tool-name">{{ $tutorial['title'] }}</div>
                    <div class="tool-card-footer">
                        <span class="tool-cat-badge">{{ $tutorial['diff'] }}</span>
                        <span style="font-size:12px;color:var(--text3)">⏱ {{ $tutorial['time'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Books Section --}}
        <div class="section">
            <div class="section-header">
                <div class="section-title">📚 Books
                    <span class="section-title-accent">AI engineering library</span>
                </div>
            </div>
            <div class="tools-grid">
                @foreach([
                    ['emoji'=>'📖','title'=>'Prompt Engineering for Everyone','topic'=>'Prompt Engineering','pages'=>120,'free'=>true],
                    ['emoji'=>'🧠','title'=>'AI Engineering Fundamentals','topic'=>'ML / Engineering','pages'=>280,'free'=>false],
                    ['emoji'=>'🚀','title'=>'Building AI Products','topic'=>'Product Management','pages'=>200,'free'=>false],
                    ['emoji'=>'📊','title'=>'Data Science for AI Beginners','topic'=>'Data Science','pages'=>340,'free'=>false],
                    ['emoji'=>'⚖️','title'=>'Ethics & Safety in AI','topic'=>'AI Ethics','pages'=>160,'free'=>true],
                    ['emoji'=>'💰','title'=>'AI Business Strategy','topic'=>'Business','pages'=>220,'free'=>false],
                ] as $book)
                <div class="tool-card" style="position:relative">
                    @if(!$book['free'] && !(auth()->check() && auth()->user()->isPro()))
                    <div style="position:absolute;top:12px;right:12px;background:var(--surface2);border:1px solid var(--border);padding:3px 8px;border-radius:100px;font-size:11px;color:var(--text3)">🔒 Pro</div>
                    @endif
                    @if($book['free'])
                    <div style="position:absolute;top:12px;right:12px;background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);padding:3px 8px;border-radius:100px;font-size:11px;font-weight:700">Free</div>
                    @endif
                    <div class="tool-icon" style="font-size:28px">{{ $book['emoji'] }}</div>
                    <div class="tool-name">{{ $book['title'] }}</div>
                    <div class="tool-card-footer">
                        <span class="tool-cat-badge">{{ $book['topic'] }}</span>
                        <span style="font-size:12px;color:var(--text3)">📄 {{ $book['pages'] }} pages</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</main>

@endsection