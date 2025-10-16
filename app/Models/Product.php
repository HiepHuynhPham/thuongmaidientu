<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_detailDesc',
        'product_shortDesc',
        'product_price',
        'product_factory',
        'product_target',
        'product_type',
        'product_quantity',
        'product_image_url',
        'star'];

    public function discounts()
    {
        return $this->hasMany(ProductDiscount::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }
}