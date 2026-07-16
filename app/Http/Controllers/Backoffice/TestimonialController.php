<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $items = Testimonial::orderBy('id', 'desc')->get();
        return view('backoffice.testimonials.index', compact('items'));
    }

    public function create()
    {
        return view('backoffice.testimonials.create');
    }

    public function store(Request $request)
    {
        // basic validation
        $item = new Testimonial();
        // assign fields here manually in actual code, this is scaffolding
        $item->save();
        return redirect()->route('testimonials.index')->with('success', 'Created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('backoffice.testimonials.edit', ['item' => $testimonial]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->save();
        return redirect()->route('testimonials.index')->with('success', 'Updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Deleted successfully.');
    }
}
