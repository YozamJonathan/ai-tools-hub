@extends('layouts.admin')
@section('title', 'Manage Tools — Admin')

@section('content')
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

        {{-- Search & Filter Form --}}
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:16px;margin-bottom:20px">
            <form method="GET" action="{{ route('admin.tools.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
                
                <div style="flex:1;min-width:240px">
                    <label style="display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">Search by name or URL</label>
                    <input type="text" name="search" placeholder="e.g. ChatGPT, openai.com..." class="form-input"
                           value="{{ request('search') }}" style="width:100%">
                </div>

                <div style="min-width:180px">
                    <label style="display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">Category</label>
                    <select name="category_id" class="form-input" style="width:100%">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn btn-primary" style="padding:9px 18px;font-size:13px">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.tools.index') }}" class="btn btn-outline" style="padding:9px 18px;font-size:13px">
                        <i class="fas fa-times"></i> Clear
                    </a>
                    @endif
                </div>

            </form>
        </div>

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
                            @if(request('search') || request('category_id'))
                                No tools found. <a href="{{ route('admin.tools.index') }}" style="color:var(--primary2)">Clear filters →</a>
                            @else
                                No tools yet. <a href="{{ route('admin.tools.create') }}" style="color:var(--primary2)">Add the first one →</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:20px">
            {{ $tools->appends(request()->query())->links() }}
        </div>

    </main>
@endsection