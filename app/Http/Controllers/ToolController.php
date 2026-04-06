<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Review;
use App\Models\Rating;
use App\Models\Upvote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    public function show(Tool $tool)
    {
        $tool->load(['category', 'reviews.user']);
        $reviews    = $tool->reviews()->approved()->with('user')->latest()->take(10)->get();
        $userRating = null;
        $userSaved  = false;

        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                                ->where('tool_id', $tool->id)->first();
            $userSaved  = Auth::user()->collections()
                                      ->whereHas('tools', fn($q) => $q->where('tool_id', $tool->id))
                                      ->exists();
        }

        return view('tools.show', compact('tool', 'reviews', 'userRating', 'userSaved'));
    }

    public function upvote(Request $request, Tool $tool)
    {
        if (!Auth::check()) return response()->json(['error'=>'Login required'],401);

        $existing = Upvote::where('user_id',Auth::id())->where('tool_id',$tool->id)->first();

        if ($existing) {
            $existing->delete();
            $tool->decrement('vote_count');
            $voted = false;
        } else {
            Upvote::create(['user_id'=>Auth::id(),'tool_id'=>$tool->id]);
            $tool->increment('vote_count');
            $voted = true;
        }

        return response()->json(['voted'=>$voted,'count'=>$tool->fresh()->vote_count]);
    }

    public function rate(Request $request, Tool $tool)
    {
        $request->validate(['stars'=>'required|integer|min:1|max:5']);
        if (!Auth::check()) return response()->json(['error'=>'Login required'],401);

        Rating::updateOrCreate(
            ['user_id'=>Auth::id(),'tool_id'=>$tool->id],
            ['stars'=>$request->stars]
        );

        $tool->recalculateRating();

        return response()->json(['avg'=>$tool->fresh()->avg_rating]);
    }
}