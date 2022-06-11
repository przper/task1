<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function swipes()
    {
        return $this->hasMany(Swipe::class, 'owner_id');
    }

    public function pairsAsFirst()
    {
        return $this->hasMany(Pair::class, 'first_user_id');
    }

    public function pairsAsSecond()
    {
        return $this->hasMany(Pair::class, 'second_user_id');
    }

    public function getPairsAttribute()
    {
        return $this->pairsAsFirst->merge($this->pairsAsSecond);
    }
}
