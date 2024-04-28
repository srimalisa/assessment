<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'foods';

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price'
    ];

    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant','restaurant_id','id');
    }

    public function scopeRestaurantId($query, $restaurant_id)
    {
        return $query->where('restaurant_id',$restaurant_id);
    }
}
