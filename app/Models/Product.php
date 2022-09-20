<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = ['product_name', 'product_price'];
    protected $hidden = ['id'];

    public function getProducts()
    {
        return Product::all();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }
}
