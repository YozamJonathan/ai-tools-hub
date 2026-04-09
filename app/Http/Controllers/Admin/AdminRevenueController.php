<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class AdminRevenueController extends Controller
{
    public function index()
    {
        // Total revenue from active subscriptions
        $totalRevenue = Subscription::where('status', 'active')
            ->sum('amount_tzs');

        // Active pro users
        $activePro = Subscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->distinct('user_id')
            ->count('user_id');

        // This month revenue
        $monthRevenue = Subscription::where('status', 'active')
            ->whereMonth('started_at', now()->month)
            ->whereYear('started_at', now()->year)
            ->sum('amount_tzs');

        // Lifetime revenue
        $lifetimeRevenue = Subscription::sum('amount_tzs');

        // Recent subscriptions (last 10)
        $recentSubscriptions = Subscription::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        // All subscriptions with pagination
        $subscriptions = Subscription::with('user')
            ->latest('created_at')
            ->paginate(15);

        // Revenue by payment method
        $revenueByMethod = Subscription::where('status', 'active')
            ->groupBy('payment_method')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount_tzs) as total'))
            ->get();

        return view('admin.revenue.index', compact(
            'totalRevenue',
            'activePro',
            'monthRevenue',
            'lifetimeRevenue',
            'recentSubscriptions',
            'subscriptions',
            'revenueByMethod'
        ));
    }
}
