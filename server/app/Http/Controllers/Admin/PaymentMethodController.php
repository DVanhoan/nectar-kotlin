<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::paginate(20);
        return view('pages.payment_methods.index', compact('methods'));
    }
    public function create()
    {
        return view('pages.payment_methods.create');
    }
    public function store(Request $request)
    {
        PaymentMethod::create($request->validate(['name'=>'required','details'=>'nullable']));
        return redirect()->route('pages.payment-methods.index')->with('success','Method created.');
    }
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('pages.payment_methods.edit', compact('paymentMethod'));
    }
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validate(['name'=>'required','details'=>'nullable']));
        return redirect()->route('pages.payment-methods.index')->with('success','Method updated.');
    }
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back()->with('success','Method deleted.');
    }
}
