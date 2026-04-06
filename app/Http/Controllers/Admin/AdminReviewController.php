<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user','tool'])->latest()->paginate(20);
        return view('admin.reviews', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);
        return back()->with('success', 'Review approved!');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => 'flagged']);
        return back()->with('success', 'Review removed.');
    }
}