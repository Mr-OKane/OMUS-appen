<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'line1',
        'line2'
    ];

    protected $table = "addresses";

    public function postalCode(): BelongsTo
    {
        return $this->belongsTo(PostalCode::class);
    }
}
