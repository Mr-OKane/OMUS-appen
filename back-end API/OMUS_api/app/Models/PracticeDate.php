<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeDate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'practice_date'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_practice_dates','practice_date_id','user_id');
    }
}
