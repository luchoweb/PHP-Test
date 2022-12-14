<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    
    protected $fillable = ['customer_document', 'customer_documentType', 'customer_name', 'customer_surname', 'customer_email', 'customer_mobile', 'status', 'product_id', 'payment_status', 'total', 'payment_requestId'];

    protected $hidden = ['id'];

    // Return all orders
    public function getOrders()
    {
        return Order::all();
    }

    // Return an order by ID
    public function getOrderById($id)
    {
        return Order::find($id);
    }

    // Get the product that owns the Order
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
