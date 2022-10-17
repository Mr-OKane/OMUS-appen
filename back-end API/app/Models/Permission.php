<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = "permissions";

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,"role_permissions","permissionID","roleID")->withTimestamps();
    }
}
