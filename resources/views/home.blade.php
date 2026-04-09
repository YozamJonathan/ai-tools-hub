
@extends('layouts.app')

@section('title', 'AI Tools Hub - Discover & Master AI Tools')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-[calc(100vh-200px)] bg-gradient-to-b from-slate-950 via-slate-900 to-slate-800 pt-16 pb-16 px-4">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/3 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-5xl mx-auto">
        <!-- Main Heading -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">
                <span class="text-white">Discover &</span>
                <br>
                <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">Master AI Tools</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-12">
                Explore {{ \App\Models\Tool::approved()->count() }}+ carefully curated AI tools. Compare features, read verified reviews from {{ number_format(\App\Models\User::count()) }} members.
            </p>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4 hover:border-slate-600 transition">
                    <div class="text-2xl md:text-3xl font-bold text-blue-400 mb-1">{{ \App\Models\Tool::approved()->count() }}+</div>
                    <div class="text-xs md:text-sm text-gray-400">AI Tools</div>
                </div>
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4 hover:border-slate-600 transition">
                    <div class="text-2xl md:text-3xl font-bold text-cyan-400 mb-1">{{ \App\Models\Category::count() }}</div>
                    <div class="text-xs md:text-sm text-gray-400">Categories</div>
                </div>
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4 hover:border-slate-600 transition">
                    <div class="text-2xl md:text-3xl font-bold text-purple-400 mb-1">{{ number_format(\App\Models\User::count()) }}</div>
                    <div class="text-xs md:text-sm text-gray-400">Active Users</div>
                </div>
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4 hover:border-slate-600 transition">
                    <div class="text-2xl md:text-3xl font-bold text-green-400 mb-1">{{ \App\Models\Review::where('status','approved')->count() }}</div>
                    <div class="text-xs md:text-sm text-gray-400">Reviews</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trending & New Tools Section -->
<section class="bg-slate-950 py-16 px-4">
    <div class="max-w-7xl mx-auto" id="tools-section">

        <!-- Trending Section -->
        @if($trending->count() > 0)
        <div class="mb-20">
            <div class="flex items-center gap-3 mb-8">
                <span class="text-3xl">🔥</span>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Trending Now</h2>
                    <p class="text-sm text-gray-400">Most upvoted tools this week</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($trending as $i => $tool)
                <a href="{{ route('tools.show', $tool) }}" class="group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-600/10 to-red-600/10 group-hover:from-orange-500/20 group-hover:to-red-500/20 transition duration-300"></div>
                    <div class="relative bg-slate-800 border border-slate-700 group-hover:border-orange-500/50 rounded-lg p-6 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center text-xl">{{ $tool->emoji }}</div>
                                <div>
                                    <h3 class="font-bold text-white group-hover:text-orange-400 transition">{{ $tool->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $tool->category->name }}</p>
                                </div>
                            </div>
                            @if($i < 3)
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-red-600">
                                <span class="text-sm font-bold text-white">#{{ $i+1 }}</span>
                            </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-300 line-clamp-2 mb-4">{{ $tool->description }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-700">
                            <span class="text-sm font-semibold text-orange-400">{{ number_format($tool->vote_count) }} upvotes</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-orange-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- New This Week Section -->
        @if($newTools->count() > 0)
        <div class="mb-20">
            <div class="flex items-center gap-3 mb-8">
                <span class="text-3xl">✨</span>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white">New This Week</h2>
                    <p class="text-sm text-gray-400">{{ $newTools->count() }} tools just added</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($newTools as $tool)
                <a href="{{ route('tools.show', $tool) }}" class="group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 to-cyan-600/10 group-hover:from-emerald-500/20 group-hover:to-cyan-500/20 transition duration-300"></div>
                    <div class="relative bg-slate-800 border border-slate-700 group-hover:border-emerald-500/50 rounded-lg p-5 transition h-full flex flex-col">
                        <div class="inline-flex items-center gap-2 mb-3">
                            <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-semibold rounded">NEW</span>
                        </div>
                        <div class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center text-lg mb-3">{{ $tool->emoji }}</div>
                        <h3 class="font-bold text-white group-hover:text-emerald-400 transition mb-1 line-clamp-2">{{ $tool->name }}</h3>
                        <p class="text-xs text-gray-500 mb-3">{{ $tool->category->name }}</p>
                        <p class="text-sm text-gray-300 line-clamp-2 flex-1">{{ $tool->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- All Tools Section -->
<section class="bg-slate-950 py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="mb-8">
            @if(request('search'))
                <h2 class="text-3xl font-bold text-white mb-2">Search Results</h2>
                <p class="text-gray-400">Results for <span class="text-blue-400 font-semibold">"{{ request('search') }}"</span> — {{ $tools->total() }} tools found</p>
            @elseif(request('category'))
                <h2 class="text-3xl font-bold text-white mb-2">{{ ucfirst(str_replace('-', ' ', request('category'))) }} Tools</h2>
                <p class="text-gray-400">{{ $tools->total() }} tools in this category</p>
            @else
                <h2 class="text-3xl font-bold text-white mb-2">All Tools</h2>
                <p class="text-gray-400">Browse all {{ $tools->total() }} AI tools in our database</p>
            @endif
        </div>

        <!-- Empty State -->
        @if($tools->count() === 0)
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-2xl font-bold text-white mb-2">No tools found</h3>
            <p class="text-gray-400 mb-6">We couldn't find any tools matching your search or category.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to All Tools
            </a>
        </div>
        @else
        <!-- Tools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($tools as $tool)
            @include('partials.tool-card', ['tool' => $tool])
            @endforeach
        </div>

        <!-- Pagination -->
        @if($tools->hasPages())
        <div class="flex justify-center">
            {{ $tools->withQueryString()->links() }}
        </div>
        @endif
        @endif
    </div>
</section>

<!-- Pro Upsell Section -->
@guest
<section class="bg-gradient-to-r from-blue-900/50 to-purple-900/50 border-t border-b border-slate-700 py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/20 border border-blue-500/50 rounded-full text-blue-400 text-sm font-semibold mb-6">
            <span>⚡</span>
            <span>Unlock Premium Features</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
            Level Up with <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Pro</span>
        </h2>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto mb-8">
            Access AI tutorials, Engineering books, Tool comparisons, and much more. All in one place, tailored for professionals.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <div class="flex items-center justify-center gap-2 text-gray-300">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Premium Tutorials</span>
            </div>
            <div class="flex items-center justify-center gap-2 text-gray-300">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Tool Comparisons</span>
            </div>
            <div class="flex items-center justify-center gap-2 text-gray-300">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Expert Reviews</span>
            </div>
        </div>

        <div class="mb-8">
            <div class="inline-block">
                <div class="text-5xl font-bold text-white mb-2">5,000 TZS<span class="text-lg text-gray-400">/month</span></div>
                <p class="text-gray-400 text-sm">≈ $1.94 USD · Cancel anytime, no questions asked</p>
            </div>
        </div>

        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition transform hover:scale-105">
            <span>Get Started Free</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
</section>
@endguest

@endsection
