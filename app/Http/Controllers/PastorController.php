<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use Illuminate\Http\Request;

class PastorController extends Controller
{
    public function index()
    {
        $pastors = Pastor::orderBy('name')->get();
        return view('pastor.index', compact('pastors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:pastors,name',
        ]);

        Pastor::create(['name' => $request->name]);

        return redirect()->route('pastor.index')->with('message', '牧師を登録しました');
    }

    public function destroy(Pastor $pastor)
    {
        $pastor->delete();

        return redirect()->route('pastor.index')->with('message', '牧師を削除しました');
    }
}
