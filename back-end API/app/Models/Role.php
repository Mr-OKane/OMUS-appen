<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = "roles";

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,"role_permissions","roleID","permissionID")->withTimestamps();
    }
}
