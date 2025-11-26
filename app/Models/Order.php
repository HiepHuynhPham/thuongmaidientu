<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total_price',
        'status',
        'receiver_phone',
        'receiver_address',
        'receiver_name',
        'payment_method',
        'pay',
        'paypal_order_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
}
