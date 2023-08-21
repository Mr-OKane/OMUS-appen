<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_price'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'order_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'product_id');
    }
}
