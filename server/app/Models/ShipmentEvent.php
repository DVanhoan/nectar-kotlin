<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentEvent extends Model
{
    use HasFactory;

    protected $fillable = ['shipment_id','event_type','location','event_time','description'];

    protected $dates = ['event_time'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
