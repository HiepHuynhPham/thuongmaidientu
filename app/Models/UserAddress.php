<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address', 'address_type', 'is_default'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
