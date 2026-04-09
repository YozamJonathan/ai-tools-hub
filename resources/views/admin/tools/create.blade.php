@extends('layouts.admin')
@section('title', 'Add Tool — Admin')

@section('content')

    <main class="admin-content">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px">
            <a href="{{ route('admin.tools.index') }}" style="color:var(--text3);font-size:14px">← Back</a>
            <h2 style="font-size:22px;font-weight:800">Add New Tool</h2>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:32px;max-width:640px">
            <form action="{{ route('admin.tools.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tool name *</label>
                    <input type="text" name="name" class="form-input"
                           value="{{ old('name') }}" placeholder="e.g. Otter.ai" required>
                    @error('name')<div style="color:var(--accent2);font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Emoji icon</label>
                    <input type="text" name="emoji" class="form-input"
                           value="{{ old('emoji', '🤖') }}" placeholder="🤖" style="max-width:120px">
                </div>

                <div class="form-group">
                    <label class="form-label">Official URL *</label>
                    <input type="url" name="url" class="form-input"
                           value="{{ old('url') }}" placeholder="https://..." required>
                    @error('url')<div style="color:var(--accent2);font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-input" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<div style="color:var(--accent2);font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input form-textarea"
                              placeholder="Short description shown on the tool card..."
                              required>{{ old('description') }}</textarea>
                    @error('description')<div style="color:var(--accent2);font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:var(--text2)">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        Feature this tool (pin to top)
                    </label>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">Add Tool</button>
                    <a href="{{ route('admin.tools.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </main>
@endsection