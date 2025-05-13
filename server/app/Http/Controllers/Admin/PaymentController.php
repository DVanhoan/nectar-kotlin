<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order','method')->paginate(20);
        return view('pages.payments.index', compact('payments'));
    }
    public function show(Payment $payment)
    {
        return view('pages.payments.show', compact('payment'));
    }
}
