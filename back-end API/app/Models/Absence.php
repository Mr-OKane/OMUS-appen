<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'absence',
        'date'
    ];

    protected $table = "absences";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
