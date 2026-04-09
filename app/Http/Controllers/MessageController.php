<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Show user's messages with replies
     */
    public function index()
    {
        $messages = Auth::user()
            ->messages()
            ->with('tool')
            ->latest()
            ->paginate(10);
        
        // Count unread replies
        $unreadReplies = Auth::user()
            ->messages()
            ->where('status', 'replied')
            ->whereNull('read_at')
            ->count();

        return view('messages', compact('messages', 'unreadReplies'));
    }

    /**
     * Send a new message (Ask Yozee)
     */
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

    /**
     * Show single message and mark as read
     */
    public function show(Message $message)
    {
        // Check authorization
        if ($message->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Mark as read if it has a reply
        $message->markAsRead();

        return view('messages.show', compact('message'));
    }

    /**
     * Mark message as read (AJAX)
     */
    public function markAsRead(Message $message)
    {
        if ($message->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->markAsRead();

        return response()->json(['success' => true]);
    }
}
