<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        // Order by lowest stock first by default so admins see what needs restocking
        $products = $query->orderBy('stock', 'asc')->paginate(15);

        return view('backoffice.stock.index', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->stock = $request->stock;
        $product->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Stock updated successfully!', 'stock' => $product->stock]);
        }

        return back()->with('success', 'Stock updated successfully for ' . $product->name);
    }
}
