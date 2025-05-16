<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'shipper_id', 'carrier','tracking_number','status','shipped_at','delivered_at','estimated_delivery'];

    protected $dates = ['shipped_at','delivered_at','estimated_delivery'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipper_id');
    }


    public function events()
    {
        return $this->hasMany(ShipmentEvent::class);
    }
}
