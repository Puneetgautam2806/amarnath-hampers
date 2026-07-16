<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add some products before checking out.');
        }

        return view('frontend.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'order_note' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate Subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        // Flat rate shipping
        $shipping = 15.00;
        $total = $subtotal + $shipping;

        try {
            DB::beginTransaction();

            // Double check stock levels for all products before creating order
            foreach ($cart as $id => $item) {
                $product = Product::lockForUpdate()->find($id);
                if (!$product || $product->stock < $item['qty']) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', "Sorry, the product '{$item['name']}' is no longer available in the requested quantity.");
                }
            }

            // Create Order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'order_note' => $request->order_note,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Save Order Items and decrement stock
            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'total' => $item['price'] * $item['qty'],
                ]);

                // Decrement stock
                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('payment.dummy', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to place order. Please try again. Details: ' . $e->getMessage());
        }
    }

    public function complete($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('frontend.order-complete', compact('order'));
    }
}
