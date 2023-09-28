<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Processing = 'processing';
    case Dispatched = 'dispatched';
    case Delivered = 'delivered';
}

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_date',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'order_products', 'order_id','product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
