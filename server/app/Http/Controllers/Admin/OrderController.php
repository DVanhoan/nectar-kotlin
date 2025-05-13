<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user','payment','shipment')
            ->paginate(20);
        return view('pages.orders.index', compact('orders'));
    }
    public function show(Order $order)
    {
        return view('pages.orders.show', compact('order'));
    }
    public function update(Request $request, Order $order)
    {
        $order->update($request->validate(['status'=>'required|in:pending,paid,shipped,completed,cancelled']));
        return back()->with('success','Order status updated.');
    }
}
