<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('tools')->get();

        $query = Tool::approved()
                     ->with('category')
                     ->withCount('upvotes');

        if ($search = $request->get('search')) {
            $query->search($search);
        }

        if ($cat = $request->get('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $cat));
        }

        $tools    = $query->latest()->paginate(24);
        $trending = Tool::approved()->trending()->with('category')->take(5)->get();
        $newTools = Tool::approved()->newThisWeek()->with('category')->take(4)->get();

        return view('home', compact('tools', 'categories', 'trending', 'newTools'));
    }
}