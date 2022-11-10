<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sheet extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'notes'
    ];

    protected $table = "sheets";

}
