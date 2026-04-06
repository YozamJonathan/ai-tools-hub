<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with('category')->latest()->paginate(20);
        return view('admin.tools.index', compact('tools'));
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