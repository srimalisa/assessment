<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        'total_price',
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order','id','order_id');
    }

    public function food()
    {
        return $this->hasOne('App\Models\Food','id','food_id');
    }

    public function scopeOrderId($query, $order_id)
    {
        return $query->where('order_id',$order_id);
    }
}
