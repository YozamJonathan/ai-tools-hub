<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
   

    public function store(Request $request, Tool $tool)
    {
        $request->validate([
            'body' => 'required|string|min:10|max:500',
        ]);

        $existing = Review::where('user_id', Auth::id())
                          ->where('tool_id', $tool->id)->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this tool');
        }

        Review::create([
            'user_id' => Auth::id(),
            'tool_id' => $tool->id,
            'body'    => $request->body,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Review submitted! It will appear after approval.');
    }
}