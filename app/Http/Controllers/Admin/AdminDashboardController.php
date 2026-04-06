<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\User;
use App\Models\Suggestion;
use App\Models\Message;
use App\Models\Review;
use App\Models\Subscription;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'tools'       => Tool::approved()->count(),
            'users'       => User::count(),
            'pro_users'   => User::where('is_premium', true)->count(),
            'revenue_tzs' => Subscription::where('status', 'active')->sum('amount_tzs'),
            'pending_suggestions' => Suggestion::where('status', 'pending')->count(),
            'pending_reviews'     => Review::where('status', 'pending')->count(),
            'pending_messages'    => Message::where('status', 'pending')->count(),
        ];

        $topTools = Tool::approved()
                        ->orderBy('vote_count', 'desc')
                        ->take(5)->get();

        return view('admin.dashboard', compact('stats', 'topTools'));
    }
}