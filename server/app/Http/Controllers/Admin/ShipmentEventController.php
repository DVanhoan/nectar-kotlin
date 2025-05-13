<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use Illuminate\Http\Request;

class ShipmentEventController extends Controller
{
    public function store(Request $request, Shipment $shipment)
    {
        $shipment->events()->create($request->validate([
            'event_type'=>'required|in:picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered,exception',
            'location'=>'nullable',
            'event_time'=>'nullable|date',
            'description'=>'nullable'
        ]));
        return back()->with('success','Event added.');
    }
    public function update(Request $request, ShipmentEvent $shipmentEvent)
    {
        $shipmentEvent->update($request->validate([
            'event_type'=>'required|in:picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered,exception',
            'location'=>'nullable',
            'event_time'=>'nullable|date',
            'description'=>'nullable']));
        return back()->with('success','Event updated.');
    }
    public function destroy(ShipmentEvent $shipmentEvent)
    {
        $shipmentEvent->delete();
        return back()->with('success','Event deleted.');
    }
}
