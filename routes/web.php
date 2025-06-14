<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TransictionsController;
use App\Http\Controllers\DetailsController;

use App\Models\Customers;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    $customers = Customers::all();
    return view('shop.index', compact('customers'));
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

// Customer Purchases page
Route::get('/customer/purchases', [TransictionsController::class, 'customerPurchasesPage'])->name('customer.purchases');
// API for purchases of a customer
Route::get('/customer/purchases/{customer}', [TransictionsController::class, 'customerPurchases']);


// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

// Details
Route::get('/details', [DetailsController::class, 'index'])->name('details.index');
Route::post('details/store', [DetailsController::class, 'store'])->name('details.store');
