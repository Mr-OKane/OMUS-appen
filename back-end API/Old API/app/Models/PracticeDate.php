<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeDate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'practice'
    ];

    protected $table = "practice_dates";

    public function team(): BelongsTo
    {
      return $this->belongsTo(Team::class);
    }
}
