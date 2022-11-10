<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instrument extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $table = "instruments";

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,"user_instruments","instrumentID","userID")->withTimestamps();
    }
}
