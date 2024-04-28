<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'location',
        'status',
        'approval',
        'manager_id',
        'created_by',
    ];

    public function category()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }

    public function foods()
    {
        return $this->hasMany('App\Models\Food','restaurant_id','id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\RestaurantStatus','id','status');
    }

    public function approval()
    {
        return $this->hasOne('App\Models\RestaurantStatus','id','approval');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order','restaurant_id','id');
    }

    public function scopeCategoryId($query, $category_id)
    {
        return $query->where('category_id',$category_id);
    }

    public function scopeManagerId($query, $manager_id)
    {
        return $query->where('manager_id',$manager_id);
    }

    public function scopeEnabled($query)
    {
        return $query->where('status',1);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval',3);
    }
}
