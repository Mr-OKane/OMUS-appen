<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function chatRoom(): BelongsTo
    {
       return $this->belongsTo(ChatRoom::class,'chat_room_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class,'chat_id','id');
    }
}
