<?php

namespace App\Http\Controllers;

use App\Models\transictions;
use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customers::with('transictions')->get();
        return view('layouts.app', compact('customers'));
    }

    function store(Request $request)
    {
        $request->validate([
            'c_name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:customers,phone',
        ]);
        $customers = new Customers;
        $customers->c_name = $request->c_name;
        $customers->phone = $request->phone;
        $customers->save();

        return redirect()->back();
    }

    function add(){
        return view('shop.add');
    }

    function list(){
        $customers = customers::all();
        return view('shop.list',compact('customers'));
    }

    function edit($id){
        $customer = Customers::findOrFail($id);
        return view('shop.edit', compact('customer'));
    }

    function update(Request $request, $id){
        $request->validate([
            'c_name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:customers,phone,' . $id,
        ]);
        $customers = Customers::findOrFail($id);
        $customers->c_name = $request->c_name;
        $customers->phone = $request->phone;
        $customers->save();
        return redirect()->route('customers.list');
    }
    public function delete($id)
    {
        $customers = Customers::find($id);
        if ($customers) {
            $customers->delete();
        }
    return redirect()->back();
    }

    public function custom(Request $request)
    {
        $validated = $request->validate([
            'c_name' => 'required|string|max:255',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/'
        ]);

        $customers = Customers::create($validated);

        return response()->json([
            'success' => true,
            'customer' => $customers
        ]);
    }

    // Add a method to check phone existence
    public function checkPhone(Request $request)
    {
        $exists = Customers::where('phone', $request->phone)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function destroy($id)
    {
        try {
            $customer = Customers::findOrFail($id);
            $customer->delete();

            return redirect()->back()->with('success', 'Customer and all related transactions deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete customer');
        }
    }
}
