<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address'
    ];

    public function zipCode():BelongsTo
    {
        return $this->belongsTo(ZipCode::class,'zip_code_id');
    }

    public function users():HasMany
    {
        return $this->hasMany(User::class,'address_id','id');
    }
}
