<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $guarded = [];
    public $table="category_product";


    public function category()
{
    return $this->belongsToMany(Category::class, 'category_id' );
}

    public function product()
    {
        return $this->belongsToMany(Product::class,   'product_id' );
    }


 }
