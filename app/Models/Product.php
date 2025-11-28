<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

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
        'star',
        'slug'];

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (Schema::hasColumn('products', 'slug')) {
                $product->slug = $product->slug ?: Str::slug($product->product_name ?? '');
            }
        });
        static::updating(function ($product) {
            if (Schema::hasColumn('products', 'slug')) {
                $product->slug = Str::slug($product->product_name ?? '');
            }
        });
    }

    public function getSlugAttribute(): string
    {
        $value = $this->attributes['slug'] ?? null;
        return $value ?: Str::slug($this->product_name ?? '');
    }
}
