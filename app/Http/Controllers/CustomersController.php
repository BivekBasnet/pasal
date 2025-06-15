<?php

namespace App\Http\Controllers;

use App\Models\transictions;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function update(Request $request, $id)
    {
        $customer = Customers::findOrFail($id);

        // Always validate name
        $rules = [
            'c_name' => 'required|string|max:255',
        ];

        // If phone number is changed, validate it
        if ($request->phone != $customer->phone) {
            $rules['phone'] = [
                'required',
                'digits:10',
                Rule::unique('customers')->ignore($customer->id)
            ];
        } else {
            // If phone is not changed, just make sure it's provided
            $rules['phone'] = 'required|digits:10';
        }

        $validated = $request->validate($rules, [
            'phone.unique' => 'This phone number is already registered with another customer.'
        ]);

        // Update the customer
        $customer->c_name = $request->c_name;
        if ($request->phone != $customer->phone && !Customers::where('phone', $request->phone)->exists()) {
            $customer->phone = $request->phone;
        } elseif ($request->phone == $customer->phone) {
            // If phone number hasn't changed, keep it
            $customer->phone = $request->phone;
        }

        $customer->save();

        return redirect()->route('customers.list')->with('success', 'Customer updated successfully');
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
