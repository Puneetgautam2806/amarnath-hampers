<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'integer|min:1'
        ]);

        $productId = $request->product_id;
        $qty = $request->input('qty', 1);

        $product = Product::where('status', 1)->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found or is currently inactive.');
        }

        // Validate stock level
        if ($product->stock < $qty) {
            return redirect()->back()->with('error', "Only {$product->stock} units left in stock.");
        }

        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $newQty = $cart[$productId]['qty'] + $qty;
            if ($product->stock < $newQty) {
                return redirect()->back()->with('error', "Cannot add more. Maximum available stock is {$product->stock}.");
            }
            $cart[$productId]['qty'] = $newQty;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => $qty
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);

        foreach ($request->qty as $id => $qty) {
            if (isset($cart[$id])) {
                $product = Product::find($id);
                if ($product) {
                    if ($product->stock < $qty) {
                        return redirect()->back()->with('error', "Only {$product->stock} units are available for {$product->name}.");
                    }
                    $cart[$id]['qty'] = intval($qty);
                }
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
