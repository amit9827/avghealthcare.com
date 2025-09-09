<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function shopping_cart_items()
    {
        return $this->hasMany(ShoppingCart::class, 'session_id', 'shopping_cart_session_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }



}
