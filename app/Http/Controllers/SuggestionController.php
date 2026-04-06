<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
   

    public function index()
    {
        $suggestions = Auth::user()->suggestions()->latest()->get();
        return view('suggest', compact('suggestions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tool_name'   => 'required|string|max:120',
            'tool_url'    => 'required|url|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Suggestion::create([
            'user_id'     => Auth::id(),
            'tool_name'   => $request->tool_name,
            'tool_url'    => $request->tool_url,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your suggestion has been submitted for review.');
    }
}