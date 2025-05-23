<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    // Lấy thông tin vận chuyển của đơn hàng của người dùng
    public function show($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('shipment')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found or unauthorized'], 404);
        }

        return response()->json($order->shipment);
    }

    // (Admin hoặc hệ thống) cập nhật trạng thái vận chuyển
    public function update(Request $request, $shipmentId)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $shipment = Shipment::findOrFail($shipmentId);

        $shipment->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number,
        ]);

        return response()->json(['message' => 'Shipment updated successfully', 'shipment' => $shipment]);
    }
}
