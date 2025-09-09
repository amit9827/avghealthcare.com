<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function additional_banner_images()
    {
        return $this->hasMany(BannerImage::class);

    }

    public function additional_product_images()
    {
        return $this->hasMany(ProductImage::class);

    }




 }
