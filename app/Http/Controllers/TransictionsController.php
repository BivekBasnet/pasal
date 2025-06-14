<?php

namespace App\Http\Controllers;

use App\Models\transictions;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomersController;

class TransictionsController extends Controller
{
   function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'details' => 'required|string|max:255',
            'paymentamount' => 'required|numeric',
            'sellamount' => 'required|numeric',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $transictions = new Transictions;
        $transictions->date = $request->date;
        $transictions->details = $request->details;
        $transictions->paymentamount = $request->paymentamount;
        $transictions->sellamount = $request->sellamount;
        $transictions->customer_id = $request->customer_id;
        $transictions->save();

        // Reload the transaction with the customer relationship
        $transictions->load('customer');

        return response()->json([
            'success' => true,
            'message' => 'Transaction saved successfully!',
            'transaction' => $transictions
        ]);

    }

    function add(){
        $customers = Customers::all();
        $today = date('Y-m-d');
        $todayTransactions = transictions::where('date', $today)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop.index', compact('customers', 'today', 'todayTransactions'));
    }

    function list(){
        $transictions = transictions::with('customer')->get();
        return view('shop.purchaselist',compact('transictions'));
    }

    public function delete($id)
    {
        $transictions = transictions::find($id);
        if ($transictions) {
            $transictions->delete();
        }
        return redirect()->back();
    }

    public function customerDetails($customerId) {
        $customer = Customers::findOrFail($customerId);
        $transactions = transictions::where('customer_id', $customerId)
            ->orderBy('date', 'desc')
            ->get();

        $totalSales = $transactions->sum('sellamount');
        $totalPayments = $transactions->sum('paymentamount');
        $balance = $totalSales - $totalPayments;

        return view('shop.customer-details', compact('customer', 'transactions', 'totalSales', 'totalPayments', 'balance'));
    }

    public function customerPurchasesPage()
    {
        $customers = Customers::all();
        return view('shop.customer_purchases', compact('customers'));
    }

    public function customerPurchases($customerId)
    {
        $customer = Customers::find($customerId);
        $purchases = transictions::where('customer_id', $customerId)->orderBy('date', 'desc')->get();
        return response()->json([
            'customer' => $customer,
            'purchases' => $purchases
        ]);
    }

    public function edit($id)
    {
        $transiction = transictions::findOrFail($id);
        $customers = Customers::all();
        return view('shop.edit_transiction', compact('transiction', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'details' => 'required|string|max:255',
            'paymentamount' => 'required|numeric',
            'sellamount' => 'required|numeric',
            'customer_id' => 'required|exists:customers,id',
        ]);
        $transiction = transictions::findOrFail($id);
        $transiction->date = $request->date;
        $transiction->details = $request->details;
        $transiction->paymentamount = $request->paymentamount;
        $transiction->sellamount = $request->sellamount;
        $transiction->customer_id = $request->customer_id;
        $transiction->save();
        return redirect()->route('transictions.list');
    }

    public function dayPurchase(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $purchases = transictions::where('date', $date)->with('customer')->orderBy('created_at', 'desc')->get();
        $today = $date;
        return view('shop.day_purchase', compact('purchases', 'today'));
    }
}
