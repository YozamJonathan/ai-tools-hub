<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
   

    public function index()
    {
        $messages = Auth::user()->messages()->with('tool')->latest()->get();
        return view('messages', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:10|max:1000',
            'tool_id' => 'nullable|exists:tools,id',
        ]);

        Message::create([
            'user_id'     => Auth::id(),
            'tool_id'     => $request->tool_id,
            'message'     => $request->message,
            'is_priority' => Auth::user()->isPro(),
            'status'      => 'pending',
        ]);

        return back()->with('success', 'Message sent to Yozee! You will get a reply soon.');
    }
}