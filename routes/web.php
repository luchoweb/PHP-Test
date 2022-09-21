<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PaymentController;

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
Route::get('/', function () {
    return view('home');
});

// List all orders
Route::get('/orders', [OrderController::class, 'index']);

// Show a form to create a new order
Route::get('/orders/new', [OrderController::class, 'new']);

// Save the order and show all details before to pay
Route::post('/orders/checkout', [OrderController::class, 'checkout']);

// Tracking an order
Route::get('/orders/tracking', function () {
    return view('orders.tracking');
});

// Show order details
Route::post('/orders/tracking', [TrackingController::class, 'show']);

// Show order details and redirect to webcheckout
Route::post('/orders/pay', [PaymentController::class, 'pay']);

// Show order status after paying it on webcheckout
Route::get('/orders/pay/status', [PaymentController::class, 'status']);
