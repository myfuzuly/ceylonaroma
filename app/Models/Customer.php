<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = [
        'name','email','password','phone','company',
        'country','address','google_id','avatar',
        'otp_code','otp_expires_at','is_active',
    ];

    protected $hidden = ['password','remember_token','otp_code'];

    protected $casts = [
        'password'       => 'hashed',
        'otp_expires_at' => 'datetime',
        'is_active'      => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
