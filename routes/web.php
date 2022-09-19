<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get(
    '/',
    function () {
        return view('home');
    }
);

// List all orders
Route::get(
    '/orders',
    [OrderController::class, 'index']
);

// Show a form to create a new order
Route::get(
    '/orders/new',
    function () {
        return view('orders.new');
    }
);

// Save the order and show all details before to pay
Route::post(
    '/orders/checkout',
    [OrderController::class, 'store']
);

// Response page for payments
Route::get(
    '/orders/pay',
    [OrderController::class, 'paymentStatus']
);

// Show order details
Route::get(
    '/orders/traking/[id]',
    [OrderController::class, 'show']
);
