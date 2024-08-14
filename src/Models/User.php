<?php

namespace Mpob\Syndicates\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $appends = ['region','auth_role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NAME',
        'EMAIL',
        'PASSWORD',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'PASSWORD',
        'REMEMBER_TOKEN',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'EMAIL_VERIFIED_AT' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(UsrRole::class,'USR_ID');
    }

    /**
     * @return HasOne
     */
    public function staff(): HasOne
    {
        return $this->hasOne(TrcAccStaff::class,'USR_ID');
    }

    public function getRegionAttribute()
    {
        return !is_null($this->staff->division) ? $this->staff->division->region_code:0;
    }

    public function getAuthRole()
    {
        return $this->staff->role;
    }

}
