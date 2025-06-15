<?php

namespace App\Http\Controllers;

use App\Models\transictions;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransictionsController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'details' => 'required|string|max:255',
            'paymentamount' => 'required|numeric|min:0|max:9999999999.99',
            'sellamount' => 'required|numeric|min:0|max:9999999999.99',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $transictions = new transictions;
        $transictions->date = $request->date;
        $transictions->details = $request->details;
        $transictions->paymentamount = $request->paymentamount;
        $transictions->sellamount = $request->sellamount;
        $transictions->customer_id = $request->customer_id;
        $transictions->save();

        return back();
    }

    function add()
    {
        $customers = Customers::all();
        $today = date('Y-m-d');
        $todayTransactions = transictions::where('date', $today)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop.index', compact('customers', 'today', 'todayTransactions'));
    }

    function list()
    {
        $transictions = transictions::with('customer')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('shop.purchaselist', compact('transictions'));
    }

    public function delete($id)
    {
        $transictions = transictions::find($id);
        if ($transictions) {
            $transictions->delete();
        }
        return redirect()->back();
    }

    public function customerDetails($customerId)
    {
        $customer = Customers::findOrFail($customerId);
        $transactions = transictions::where('customer_id', $customerId)
            ->orderBy('date', 'desc')
            ->get();

        $totalSales = $transactions->sum('sellamount');
        $totalPayments = $transactions->sum('paymentamount');
        $balance = $totalSales - $totalPayments;

        return view('shop.customer-details', compact('customer', 'transactions', 'totalSales', 'totalPayments', 'balance'));
    }

    // Show customer purchases page
    public function customerPurchasesPage()
    {
        try {
            $customers = Customers::orderBy('c_name')->get(['id', 'c_name', 'phone']);
            return view('shop.customer_purchases', compact('customers'));
        } catch (\Exception $e) {
            Log::error('Error loading customers list', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Unable to load customers. Please try again.');
        }
    }

    // Get customer purchases API endpoint
    public function customerPurchases($customerId)
    {
        try {
            $customer = Customers::findOrFail($customerId);

            // Get all transactions for the customer
            $transactions = transictions::where('customer_id', $customerId)
                ->orderBy('date', 'desc')
                ->get();

            // Calculate totals using collection methods
            $totalSell = $transactions->sum('sellamount');
            $totalPayment = $transactions->sum('paymentamount');
            $balance = $totalSell - $totalPayment;

            // Group transactions by month for the summary
            $monthlySummary = $transactions->groupBy(function($transaction) {
                return date('Y-m', strtotime($transaction->date));
            })->map(function($monthTransactions) {
                return [
                    'sell_amount' => $monthTransactions->sum('sellamount'),
                    'payment_amount' => $monthTransactions->sum('paymentamount'),
                    'transaction_count' => $monthTransactions->count()
                ];
            });

            Log::info('Customer purchases loaded successfully', [
                'customer_id' => $customerId,
                'transaction_count' => $transactions->count(),
                'total_sell' => $totalSell,
                'total_payment' => $totalPayment
            ]);

            return response()->json([
                'status' => 'success',
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->c_name,
                    'phone' => $customer->phone
                ],
                'summary' => [
                    'total_sell' => round($totalSell, 2),
                    'total_payment' => round($totalPayment, 2),
                    'balance' => round($balance, 2)
                ],
                'monthly_summary' => $monthlySummary,
                'transactions' => $transactions->map(function($transaction) {
                    return [
                        'id' => $transaction->id,
                        'date' => $transaction->date,
                        'details' => $transaction->details,
                        'sellamount' => round($transaction->sellamount, 2),
                        'paymentamount' => round($transaction->paymentamount, 2)
                    ];
                })
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning('Customer not found', ['customer_id' => $customerId]);
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error loading customer purchases', [
                'customer_id' => $customerId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load customer purchases. Please try again.'
            ], 500);
        }
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
        $purchases = transictions::where('date', $date)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();
        $today = $date;
        return view('shop.day_purchase', compact('purchases', 'today'));
    }
}
