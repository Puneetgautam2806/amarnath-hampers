<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\Request;

class PromoBannerController extends Controller
{
    public function index()
    {
        $items = PromoBanner::orderBy('id', 'desc')->get();
        return view('backoffice.promo_banners.index', compact('items'));
    }

    public function create()
    {
        return view('backoffice.promo_banners.create');
    }

    public function store(Request $request)
    {
        // basic validation
        $item = new PromoBanner();
        // assign fields here manually in actual code, this is scaffolding
        $item->save();
        return redirect()->route('promo_banners.index')->with('success', 'Created successfully.');
    }

    public function edit(PromoBanner $promo_banner)
    {
        return view('backoffice.promo_banners.edit', ['item' => $promo_banner]);
    }

    public function update(Request $request, PromoBanner $promo_banner)
    {
        $promo_banner->save();
        return redirect()->route('promo_banners.index')->with('success', 'Updated successfully.');
    }

    public function destroy(PromoBanner $promo_banner)
    {
        $promo_banner->delete();
        return redirect()->route('promo_banners.index')->with('success', 'Deleted successfully.');
    }
}
