<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminToolController extends Controller
{
    public function index(Request $request)
    {
        $query = Tool::with('category');

        // Search by name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $tools = $query->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('admin.tools.index', compact('tools', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:120',
            'url'         => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'emoji'       => 'nullable|string|max:10',
        ]);

        Tool::create([
            ...$request->only(['name','url','description','category_id','emoji','is_featured']),
            'created_by' => Auth::id(),
            'status'     => 'approved',
        ]);

        return redirect()->route('admin.tools.index')
                         ->with('success','Tool added successfully!');
    }

    public function edit(Tool $tool)
    {
        $categories = Category::all();
        return view('admin.tools.edit', compact('tool','categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'name'        => 'required|string|max:120',
            'url'         => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $tool->update($request->only(['name','url','description','category_id','emoji','is_featured','status']));

        return redirect()->route('admin.tools.index')
                         ->with('success','Tool updated!');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return back()->with('success','Tool deleted.');
    }
}