<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Shipment::with('order.customer','shipper','events');

        if ($user->role === 'shipper') {

            $query->where('shipper_id', $user->id);
        }

        $shipments = $query->orderBy('status')->paginate(20);
        return view('pages.shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        return view('pages.shipments.show', compact('shipment'));
    }
    public function update(Request $request, Shipment $shipment)
    {
        $shipment->update($request->validate([
            'status'=>'required|in:pending,in_transit,out_for_delivery,delivered,cancelled',
            'carrier'=>'nullable',
            'tracking_number'=>'nullable',
            'estimated_delivery'=>'nullable|date']));
        return back()->with('success','Shipment updated.');
    }
}
