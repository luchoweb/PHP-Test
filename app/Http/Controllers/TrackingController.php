<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackingController extends Controller
{
    protected $orders;

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $order_id = $request->order_id;
        $order = $this->orders->getOrderById($order_id);
        return view('orders.tracking', [
            'order_id' => $order_id,
            'order' => $order
        ]);
    }
}
