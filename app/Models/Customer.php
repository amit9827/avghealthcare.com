<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    //

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }


    public function shoppingcart()
    {
        return $this->hasMany(ShoppingCart::class, 'customer_id', 'id');
    }


}
