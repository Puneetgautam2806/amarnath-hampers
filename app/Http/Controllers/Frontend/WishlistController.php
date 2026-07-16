<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session('wishlist', []);
        $products = [];
        
        if (!empty($wishlist)) {
            $products = Product::whereIn('id', $wishlist)->get();
        }

        return view('frontend.wishlist', compact('products'));
    }

    public function add(Request $request)
    {
        $product_id = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        if (!in_array($product_id, $wishlist)) {
            $wishlist[] = $product_id;
            session()->put('wishlist', $wishlist);
            return back()->with('success', 'Product added to wishlist!');
        }

        return back()->with('info', 'Product is already in your wishlist.');
    }

    public function remove($id)
    {
        $wishlist = session()->get('wishlist', []);
        
        if (($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', array_values($wishlist));
        }

        return back()->with('success', 'Product removed from wishlist!');
    }
}
