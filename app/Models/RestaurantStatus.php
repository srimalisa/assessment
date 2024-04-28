<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'restaurant_statuses';

    protected $fillable = [
        'category',
        'name',
    ];
}
