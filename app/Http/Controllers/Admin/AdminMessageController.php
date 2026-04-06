<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['user','tool'])
                           ->orderBy('is_priority','desc')
                           ->orderBy('created_at','asc')
                           ->paginate(20);

        return view('admin.messages', compact('messages'));
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate(['reply' => 'required|string|min:5']);

        $message->update([
            'reply'  => $request->reply,
            'status' => 'replied',
        ]);

        return back()->with('success', 'Reply sent!');
    }
}