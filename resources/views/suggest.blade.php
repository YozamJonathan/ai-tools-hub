{{-- ============================================================ --}}
{{-- FILE: resources/views/suggest.blade.php                     --}}
{{-- ============================================================ --}}

@extends('layouts.app')
@section('title', 'Suggest a Tool')

@section('content')
<main style="padding:64px 24px;max-width:640px;margin:0 auto">
    <div style="text-align:center;margin-bottom:40px">
        <div style="font-size:48px;margin-bottom:16px">💡</div>
        <h1 style="font-size:32px;font-weight:800;margin-bottom:12px">Suggest an AI Tool</h1>
        <p style="font-size:16px;color:var(--text2)">
            Know a great AI tool we're missing? Submit it — 3 approved suggestions earns you a Contributor badge.
        </p>
    </div>

    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);padding:32px;margin-bottom:32px">
        <form action="{{ route('suggest.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Tool name *</label>
                <input type="text" name="tool_name" class="form-input"
                       placeholder="e.g. Otter.ai" value="{{ old('tool_name') }}" required>
                @error('tool_name') <span style="color:var(--accent2);font-size:12px">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Official website *</label>
                <input type="url" name="tool_url" class="form-input"
                       placeholder="https://..." value="{{ old('tool_url') }}" required>
                @error('tool_url') <span style="color:var(--accent2);font-size:12px">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Why should we add it?</label>
                <textarea name="description" class="form-input form-textarea"
                          placeholder="What makes this tool great?">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-full btn-lg">Submit suggestion</button>
        </form>
    </div>

    {{-- My past suggestions --}}
    @if($suggestions->count() > 0)
    <div>
        <div style="font-family:var(--font-display);font-size:18px;font-weight:700;margin-bottom:16px">My Suggestions</div>
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--card-radius);overflow:hidden">
            <table class="data-table">
                <thead><tr><th>Tool</th><th>Submitted</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($suggestions as $s)
                    <tr>
                        <td style="color:var(--text);font-weight:500">{{ $s->tool_name }}</td>
                        <td>{{ $s->created_at->diffForHumans() }}</td>
                        <td><span class="badge badge-{{ $s->status }}">{{ $s->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</main>
@endsection
