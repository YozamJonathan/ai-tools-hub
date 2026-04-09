@extends('layouts.admin')
@section('title', 'Edit Tool — Admin')

@section('content')
<div class="admin-layout">
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

    <main class="admin-content">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px">
            <a href="{{ route('admin.tools.index') }}" style="color:var(--text3);font-size:14px">← Back</a>
            <h2 style="font-size:22px;font-weight:800">Edit — {{ $tool->name }}</h2>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:32px;max-width:640px">
            <form action="{{ route('admin.tools.update', $tool) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Tool name *</label>
                    <input type="text" name="name" class="form-input"
                           value="{{ old('name', $tool->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Emoji icon</label>
                    <input type="text" name="emoji" class="form-input"
                           value="{{ old('emoji', $tool->emoji) }}" style="max-width:120px">
                </div>

                <div class="form-group">
                    <label class="form-label">Official URL *</label>
                    <input type="url" name="url" class="form-input"
                           value="{{ old('url', $tool->url) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-input" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $tool->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input form-textarea"
                              required>{{ old('description', $tool->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="approved" {{ $tool->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending"  {{ $tool->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ $tool->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:var(--text2)">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ $tool->is_featured ? 'checked' : '' }}>
                        Feature this tool (pin to top)
                    </label>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('admin.tools.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection