<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PracticeDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'practice'
    ];

    protected $table = "practice_dates";

    public function team(): BelongsTo
    {
      return $this->belongsTo(Team::class);
    }
}
