<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackingController extends Controller
{
    // Tracking an order
    public function show(Request $request)
    {
        // Get the order
        $order = Order::find($request->order_id);
        
        // Show the order details
        return view('orders.tracking', [
            'order_id' => $request->order_id,
            'order' => $order
        ]);
    }
}
