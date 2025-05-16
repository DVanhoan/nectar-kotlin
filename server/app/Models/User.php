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

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'avatar_url',
        'role',
        'google_id',
        'facebook_id'
    ];

    protected $hidden = ['password'];

    public function phoneVerifications()
    {
        return $this->hasMany(PhoneVerification::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status','active');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function shipmentsToDeliver()
    {
        return $this->hasMany(Shipment::class, 'shipper_id');
    }
}
