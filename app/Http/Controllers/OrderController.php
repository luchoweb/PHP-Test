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

    public function checkout(Request $request)
    {
        $order_data = $this->store($request);
        return view('orders.checkout', $order_data);
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
            'customer_document' => request('customer_document'),
            'customer_documentType' => request('customer_documentType'),
            'customer_name' => request('customer_name'),
            'customer_surname' => request('customer_surname'),
            'customer_email' => request('customer_email'),
            'customer_mobile' => request('customer_mobile'),
            'status' => 'CREATED',
            'payment_status' => 'NONE',
            'payment_requestId' => 0,
            'total' => request('total'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'product_id' => $request->product_id
        ];

        $order = new Order($data);
        $order->save();

        $orderSaved = [
            'order_id' => $order['id'],
            'order' => $order
        ];

        return $orderSaved;
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
