<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
