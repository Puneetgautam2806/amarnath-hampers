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
            'qty' => 'integer|min:1',
            'color' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
        ]);

        $productId = $request->product_id;
        $qty = $request->input('qty', 1);
        $color = $request->input('color');
        $size = $request->input('size');

        $product = Product::where('status', 1)->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found or is currently inactive.');
        }

        // Validate stock level
        if ($product->stock < $qty) {
            return redirect()->back()->with('error', "Only {$product->stock} units left in stock.");
        }

        $cart = session('cart', []);

        // Unique key for variant
        $cartKey = (string)$productId;
        if (!empty($color)) {
            $cartKey .= '_' . \Illuminate\Support\Str::slug($color);
        }
        if (!empty($size)) {
            $cartKey .= '_' . \Illuminate\Support\Str::slug($size);
        }

        if (isset($cart[$cartKey])) {
            $newQty = $cart[$cartKey]['qty'] + $qty;
            if ($product->stock < $newQty) {
                return redirect()->back()->with('error', "Cannot add more. Maximum available stock is {$product->stock}.");
            }
            $cart[$cartKey]['qty'] = $newQty;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'cart_key' => $cartKey,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->image,
                'color' => $color,
                'size' => $size,
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

        foreach ($request->qty as $key => $qty) {
            if (isset($cart[$key])) {
                $productId = $cart[$key]['id'] ?? $key;
                $product = Product::find($productId);
                if ($product) {
                    if ($product->stock < $qty) {
                        return redirect()->back()->with('error', "Only {$product->stock} units are available for {$product->name}.");
                    }
                    $cart[$key]['qty'] = intval($qty);
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
