<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    protected $orders;
    protected $products;

    public function __construct(Order $orders, Product $products)
    {
        $this->orders = $orders;
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orders->getOrders();
        return view('orders.list', ['orders' => $orders]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $products = $this->products->getProducts();
        return view('orders.new', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->products->getProductById($request->product_id);

        $data = [
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
            'customer_mobile' => request('customer_mobile'),
            'status' => 'CREATED',
            'payment_status' => 'NONE',
            'total' => request('total'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'product_id' => $request->product_id
        ];

        $order = new Order($data);
        $order->save();

        return view('orders.checkout', [
            'order_id' => $order['id'],
            'order' => $data,
            'product' => $product
        ]);
    }

    /**
     * Show payment result and update the payment status field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentStatus(Request $request)
    {
        $data = [
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
            'customer_mobile' => request('customer_mobile'),
            'status' => request('status'),
            'payment_status' => NULL
        ];

        // Update both payment_status and status fields in database
        // TODO

        // Show view
        return view('orders.pay', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orders->getOrderById($id);
        return view('orders.tracking', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
