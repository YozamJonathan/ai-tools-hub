<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class AdminSuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with('user')->latest()->paginate(20);
        return view('admin.suggestions', compact('suggestions'));
    }

    public function approve(Suggestion $suggestion)
    {
        $suggestion->update(['status' => 'approved']);
        $suggestion->user->increment('contributions'); // Increment contributor count
        return back()->with('success', 'Suggestion approved! User notified.');
    }

    public function reject(Suggestion $suggestion)
    {
        $suggestion->update(['status' => 'rejected']);
        return back()->with('success', 'Suggestion rejected.');
    }
}