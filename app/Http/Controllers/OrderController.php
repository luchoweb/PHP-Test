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

    // Route[GET]: /orders
    public function index()
    {
        // Get all orders and list them
        $orders = $this->orders->getOrders();
        return view('orders.list', ['orders' => $orders]);
    }

    // Route[GET]: /orders/new
    public function new()
    {
        // Get all products to list in the new order form
        $products = $this->products->getProducts();
        return view('orders.new', ['products' => $products]);
    }

    // Route[POST]: /orders/checkout
    public function checkout(Request $request)
    {
        // Save the order and show all details and "Pay now" button
        $order_data = $this->store($request);
        return view('orders.checkout', $order_data);
    }

    // Save an order in the database
    public function store(Request $request)
    {
        // Get the product in the order
        $product = $this->products->getProductById($request->product_id);

        // Create the order schema
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

        // Save the order
        $order = new Order($data);
        $order->save();

        $orderSaved = [
            'order_id' => $order['id'],
            'order' => $order
        ];

        // Return the new order info
        return $orderSaved;
    }
}
