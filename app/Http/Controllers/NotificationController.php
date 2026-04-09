<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get unread notification counts (AJAX)
     */
    public function getUnreadCounts()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();

        // Unread message replies
        $unreadMessages = $user->messages()
            ->where('status', 'replied')
            ->whereNull('read_at')
            ->count();

        // Total notifications
        $totalNotifications = $unreadMessages;

        return response()->json([
            'unread_messages' => $unreadMessages,
            'total_notifications' => $totalNotifications,
            'timestamp' => now()->timestamp,
        ]);
    }
}
