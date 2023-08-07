<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $table = "chat_rooms";

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
}
