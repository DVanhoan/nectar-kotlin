<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::with(['customer', 'payment', 'shipment', 'items.product']);

        // Nếu là seller thì chỉ lấy orders mà trong order_items có product->seller_id = current user
        if ($user->role === 'seller') {
            $query->whereHas('items.product', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            });
        }

        // Admin sẽ không bị lọc, lấy tất cả

        $orders = $query->orderBy('placed_at', 'desc')
            ->paginate(20);

        return view('pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        // Nếu seller, kiểm tra xem order có product của họ không
        if ($user->role === 'seller') {
            $owns = $order->items->contains(function($item) use ($user) {
                return $item->product->seller_id === $user->id;
            });

            if (! $owns) {
                abort(403, 'You are not authorized to view this order.');
            }
        }

        // Admin (và shipper) đều có thể xem

        return view('pages.orders.show', compact('order'));
    }
}
