<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TransictionsController;
use App\Http\Controllers\DetailsController;

use App\Models\Customers;

Route::get('/', function () {
    return redirect()->route('login');
});

// Customer routes
Route::get('/customers/add', [CustomersController::class, 'add'])->name('customers.add');
Route::post('/customers/store', [CustomersController::class, 'store'])->name('customers.store');
Route::get('/customers/list', [CustomersController::class, 'list'])->name('customers.list');
Route::get('/customers/edit/{id}', [CustomersController::class, 'edit'])->name('customers.edit');
Route::put('/customers/update/{id}', [CustomersController::class, 'update'])->name('customers.update');
Route::delete('/customers/delete/{id}', [CustomersController::class, 'delete'])->name('customers.delete');


Route::get('/home', function () {    // Today's statistics
    $todaysSales = \App\Models\transictions::whereDate('created_at', now())->sum('sellamount');
    $todaysPayments = \App\Models\transictions::whereDate('created_at', now())->sum('paymentamount');
    $todaysTransactions = \App\Models\transictions::whereDate('created_at', now())->count();

    // This month's statistics
    $thisMonthSales = \App\Models\transictions::whereMonth('created_at', now()->month)->sum('sellamount');
    $thisMonthPayments = \App\Models\transictions::whereMonth('created_at', now()->month)->sum('paymentamount');

    // Overall statistics
    $totalTransactions = \App\Models\transictions::count();
    $totalCustomers = \App\Models\customers::count();
    $totalSales = \App\Models\transictions::sum('sellamount');
    $totalPayments = \App\Models\transictions::sum('paymentamount');
    $pendingAmount = $totalSales - $totalPayments;

    // Top customers
    $topCustomers = \App\Models\transictions::selectRaw('customer_id, SUM(sellamount) as total_purchases')
        ->with('customer')
        ->groupBy('customer_id')
        ->orderByDesc('total_purchases')
        ->limit(5)
        ->get();

    return view('shop.home', compact(
        'totalTransactions',
        'totalCustomers',
        'totalSales',
        'totalPayments',
        'todaysSales',
        'todaysPayments',
        'todaysTransactions',
        'thisMonthSales',
        'thisMonthPayments',
        'pendingAmount',
        'topCustomers'
    ));
})->name('home');


//customers
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/list', [CustomersController::class, 'list'])->name('list');
    Route::get('/add', [CustomersController::class, 'add'])->name('add');
    Route::get('/edit/{id}', [CustomersController::class, 'edit'])->name('edit');
    Route::post('/store', [CustomersController::class, 'store'])->name('store');
    Route::post('/update/{id}', [CustomersController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [CustomersController::class, 'delete'])->name('delete');
});


//transictions
Route::prefix('transictions')->name('transictions.')->group(function () {
    Route::get('/list', [TransictionsController::class, 'list'])->name('list');
    Route::get('/add', [TransictionsController::class, 'add'])->name('add');
    Route::get('/edit/{id}', [TransictionsController::class, 'edit'])->name('edit');
    Route::post('/store', [TransictionsController::class, 'store'])->name('store');
    Route::post('/update/{id}', [TransictionsController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [TransictionsController::class, 'delete'])->name('delete');
    Route::get('/day-purchase', [TransictionsController::class, 'dayPurchase'])->name('day');
});

Route::prefix('customer')->name('customer.')->group(function () {
    // Customer Purchases page
    Route::get('/purchases', [TransictionsController::class, 'customerPurchasesPage'])->name('purchases');
    // API for purchases of a customer
    Route::get('/purchases/{customer}', [TransictionsController::class, 'customerPurchases']);
    // Customer Details route
    Route::get('/{id}/details', [TransictionsController::class, 'customerDetails'])->name('details');
});


// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);


Route::post('/custom', [App\Http\Controllers\CustomersController::class, 'custom'])->name('custom');

Route::post('/check-phone', [App\Http\Controllers\CustomersController::class, 'checkPhone'])->name('customers.checkPhone');

Route::delete('/customers/{id}', [App\Http\Controllers\CustomersController::class, 'destroy'])->name('customers.destroy');
