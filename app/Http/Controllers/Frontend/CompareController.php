<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $compare = session('compare', []);
        $products = [];
        
        if (!empty($compare)) {
            $products = Product::whereIn('id', $compare)->get();
        }

        return view('frontend.compare', compact('products'));
    }

    public function add(Request $request)
    {
        $product_id = $request->product_id;
        $compare = session()->get('compare', []);

        if (count($compare) >= 4) {
            return back()->with('error', 'You can only compare up to 4 items at a time.');
        }

        if (!in_array($product_id, $compare)) {
            $compare[] = $product_id;
            session()->put('compare', $compare);
            return back()->with('success', 'Product added to compare list!');
        }

        return back()->with('info', 'Product is already in your compare list.');
    }

    public function remove($id)
    {
        $compare = session()->get('compare', []);
        
        if (($key = array_search($id, $compare)) !== false) {
            unset($compare[$key]);
            session()->put('compare', array_values($compare));
        }

        return back()->with('success', 'Product removed from compare list!');
    }
}
