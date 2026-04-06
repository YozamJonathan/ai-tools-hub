<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    

    public function index()
    {
        $collections = Auth::user()->collections()->with('tools.category')->get();
        return view('favorites', compact('collections'));
    }

    public function toggle(Request $request, Tool $tool)
    {
        $user = Auth::user();
        $collection = $user->collections()->firstOrCreate(['name'=>'My Favourites'], ['is_public'=>false]);

        if ($collection->tools()->where('tool_id', $tool->id)->exists()) {
            $collection->tools()->detach($tool->id);
            $saved = false;
        } else {
            if (!$user->isPro() && $collection->tools()->count()>=20)
                return response()->json(['error'=>'Upgrade to Pro for unlimited saves'],403);

            $collection->tools()->attach($tool->id,['added_at'=>now()]);
            $saved = true;
        }

        return response()->json(['saved'=>$saved]);
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string|max:80']);
        $user = Auth::user();

        if (!$user->isPro() && $user->collections()->count()>=2)
            return back()->with('error','Upgrade to Pro for unlimited collections');

        Collection::create(['user_id'=>$user->id,'name'=>$request->name]);
        return back()->with('success','Collection created!');
    }
}