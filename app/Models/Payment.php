<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'payment_status'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order','payment_id','payment_id');
    }

    public function scopePaymentStatus($query, $payment_status)
    {
        return $query->where('payment_status',$payment_status);
    }
}
