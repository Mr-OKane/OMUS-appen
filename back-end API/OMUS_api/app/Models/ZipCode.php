<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZipCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'zip_code'
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class,'zip_code_id','id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
}
