<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $fillable = ['customer_name', 'customer_email', 'customer_mobile', 'status', 'product_id', 'payment_status', 'total'];
    protected $hidden = ['id'];

    public function getOrders()
    {
        return Order::all();
    }

    public function getOrderById($id)
    {
        return Order::find($id);
    }

    /**
     * Get the product that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
