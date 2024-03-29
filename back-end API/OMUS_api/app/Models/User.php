<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

enum UserStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone_nr',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'status' => UserStatus::class,
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function cakeArrangements(): HasMany
    {
        return $this->hasMany(CakeArrangement::class,'user_id','id');
    }

    public function instruments(): BelongsToMany
    {
       return $this->belongsToMany(Instrument::class,'user_instruments','user_id','instrument_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'user_id','id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function sheets(): HasMany
    {
        return $this->hasMany(Sheet::class,'user_id','id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_users','user_id','team_id');
    }
}
