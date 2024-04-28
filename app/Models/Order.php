<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'payment_id',
        'user_id',
        'delivery_id',
        'description',
        'total_price',
        'payment_date',
        'order_status'
    ];

    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant','id','restaurant_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function deliveryType()
    {
        return $this->hasOne('App\Models\DeliveryType','id','delivery_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment','payment_id','payment_id');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\Models\OrderStatus','id','order_status');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }

    public function scopeUserId($query, $user_id)
    {
        return $query->where('user_id',$user_id);
    }
}
