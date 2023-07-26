<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function Complexes()
    {
        return $this->hasMany(Complexes::class,'creator_id');
    }
    public function Salons()
    {
        return $this->hasMany(salons::class,'creator_id');
    }
    public function Roles()
    {
        return $this->hasMany(Roles::class,'user_id');
    }
    public function Payments()
    {
        return $this->hasMany(Payments::class,'user_id');
    }
    public function Salon_reserves()
    {
        return $this->hasMany(Salon_reserves::class,'user_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'wallet'
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
