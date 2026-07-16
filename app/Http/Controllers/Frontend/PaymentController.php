<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function dummy($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        
        // If already paid, redirect to complete
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.complete', $order->id);
        }

        return view('frontend.payment.dummy', compact('order'));
    }

    public function processDummy(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        
        // Simulate processing payment
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
            'payment_method' => 'dummy',
        ]);

        return redirect()->route('checkout.complete', $order->id)->with('success', 'Payment successful! Your order has been placed.');
    }
}
