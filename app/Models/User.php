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
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'avatar',
        'otp',
        'contact_no',
        'role',
        'expertise',
        'isActive',
        'isVerified',
        'isDeleted',
        'isActivated',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
            return $this->hasOne(Profile::class, 'profile_id', 'id')->latestOfMany();
    }
    public function hasBranch()
    {
            return $this->hasOne(Employee::class, 'barber_id', 'id')->latestOfMany();
    }
    public function getUser() {
        
        return $this->BelongsTo(User::class,'user_id','id');

    }
}
