<?php

namespace App\Http\Controllers;

use App\Models\Detail;


use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index()
    {
        $details = Detail::all();
        return view('shop.details', compact('details'));
    }
    function store(Request $request)
    {
        $request->validate([
            'detail_name' => 'required|string|max:255',
            'detail_value' => 'required|string|max:255',
        ]);
        $details = new Detail;
        $details->detail_name = $request->detail_name;
        $details->detail_value = $request->detail_value;
        $details->save();
        return redirect()->back();
    }
}
