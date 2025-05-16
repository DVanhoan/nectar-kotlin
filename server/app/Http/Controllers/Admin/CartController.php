<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return view('pages.cart.index', compact('carts'));
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success','Cart deleted.');
    }
}
