<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15);
        return view('backoffice.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('backoffice.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:1,2',
        ]);

        $testimonial = new Testimonial();
        $testimonial->name = $validated['name'];
        $testimonial->designation = $validated['designation'] ?? 'Customer';
        $testimonial->review_text = $validated['review_text'];
        $testimonial->rating = (int) $validated['rating'];
        $testimonial->sort_order = $validated['sort_order'] ?? 0;
        $testimonial->status = (int) $validated['status'];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'testimonial_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $fileName);
            $testimonial->photo = 'uploads/testimonials/' . $fileName;
        }

        $testimonial->save();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial / Review added successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('backoffice.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:1,2',
        ]);

        $testimonial->name = $validated['name'];
        $testimonial->designation = $validated['designation'] ?? 'Customer';
        $testimonial->review_text = $validated['review_text'];
        $testimonial->rating = (int) $validated['rating'];
        $testimonial->sort_order = $validated['sort_order'] ?? 0;
        $testimonial->status = (int) $validated['status'];

        if ($request->hasFile('photo')) {
            if ($testimonial->photo && File::exists(public_path($testimonial->photo))) {
                File::delete(public_path($testimonial->photo));
            }
            $file = $request->file('photo');
            $fileName = 'testimonial_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $fileName);
            $testimonial->photo = 'uploads/testimonials/' . $fileName;
        }

        $testimonial->save();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial / Review updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo && File::exists(public_path($testimonial->photo))) {
            File::delete(public_path($testimonial->photo));
        }
        $testimonial->delete();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
