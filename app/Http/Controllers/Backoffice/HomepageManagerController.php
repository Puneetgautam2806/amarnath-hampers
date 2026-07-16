<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomepageManagerController extends Controller
{
    /**
     * Display the unified homepage management screen.
     */
    public function index()
    {
        $settings = SiteSetting::first();
        $sliders = Slider::query()->orderBy('orders')->get();

        return view('backoffice.homepage.index', compact('settings', 'sliders'));
    }

    /**
     * Update dynamic site settings (logo, favicon, contact, socials).
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,gif,svg,webp|max:1024',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'footer_desc' => 'nullable|string',
            'copyright_text' => 'nullable|string|max:255',
        ]);

        $settings = SiteSetting::first();
        if (!$settings) {
            $settings = new SiteSetting();
        }

        // Handle Site Logo Upload
        if ($request->hasFile('logo')) {
            if ($settings->logo_path && File::exists(public_path($settings->logo_path))) {
                File::delete(public_path($settings->logo_path));
            }
            $file = $request->file('logo');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $fileName);
            $settings->logo_path = 'uploads/settings/' . $fileName;
        }

        // Handle Favicon Upload
        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path && File::exists(public_path($settings->favicon_path))) {
                File::delete(public_path($settings->favicon_path));
            }
            $file = $request->file('favicon');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $fileName);
            $settings->favicon_path = 'uploads/settings/' . $fileName;
        }

        $settings->phone = $request->input('phone');
        $settings->email = $request->input('email');
        $settings->address = $request->input('address');
        $settings->facebook = $request->input('facebook');
        $settings->twitter = $request->input('twitter');
        $settings->instagram = $request->input('instagram');
        $settings->linkedin = $request->input('linkedin');
        $settings->footer_desc = $request->input('footer_desc');
        $settings->copyright_text = $request->input('copyright_text');
        $settings->save();

        return redirect()->route('homepage.index')->with('success', 'General site settings updated successfully.');
    }

    /**
     * Show form to create a new slider slide.
     */
    public function createSlider()
    {
        return view('backoffice.homepage.create_slider');
    }

    /**
     * Store a new slider slide in database.
     */
    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'subtitle' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'btn1_text' => 'nullable|string|max:50',
            'btn1_link' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:50',
            'btn2_link' => 'nullable|string|max:255',
            'orders' => 'nullable|integer',
            'status' => 'required|in:1,2',
        ]);

        $slider = new Slider();

        // Handle Banner Background Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sliders'), $fileName);
            $slider->image_path = 'uploads/sliders/' . $fileName;
        }

        $slider->subtitle = $validated['subtitle'];
        $slider->title = $validated['title'];
        $slider->description = $validated['description'];
        $slider->btn1_text = $validated['btn1_text'];
        $slider->btn1_link = $validated['btn1_link'];
        $slider->btn2_text = $validated['btn2_text'];
        $slider->btn2_link = $validated['btn2_link'];
        $slider->orders = $validated['orders'] ?? 0;
        $slider->status = (int) $validated['status'];
        $slider->save();

        return redirect()->route('homepage.index', ['tab' => 'sliders'])->with('success', 'Banner slide added successfully.');
    }

    /**
     * Show form to edit a slider slide.
     */
    public function editSlider(Slider $slider)
    {
        return view('backoffice.homepage.edit_slider', compact('slider'));
    }

    /**
     * Update a slider slide in database.
     */
    public function updateSlider(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'subtitle' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'btn1_text' => 'nullable|string|max:50',
            'btn1_link' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:50',
            'btn2_link' => 'nullable|string|max:255',
            'orders' => 'nullable|integer',
            'status' => 'required|in:1,2',
        ]);

        // Handle Banner Background Image Upload
        if ($request->hasFile('image')) {
            if ($slider->image_path && File::exists(public_path($slider->image_path))) {
                File::delete(public_path($slider->image_path));
            }
            $file = $request->file('image');
            $fileName = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sliders'), $fileName);
            $slider->image_path = 'uploads/sliders/' . $fileName;
        }

        $slider->subtitle = $validated['subtitle'];
        $slider->title = $validated['title'];
        $slider->description = $validated['description'];
        $slider->btn1_text = $validated['btn1_text'];
        $slider->btn1_link = $validated['btn1_link'];
        $slider->btn2_text = $validated['btn2_text'];
        $slider->btn2_link = $validated['btn2_link'];
        $slider->orders = $validated['orders'] ?? 0;
        $slider->status = (int) $validated['status'];
        $slider->save();

        return redirect()->route('homepage.index', ['tab' => 'sliders'])->with('success', 'Banner slide updated successfully.');
    }

    /**
     * Remove a slider slide from database and storage.
     */
    public function destroySlider(Slider $slider)
    {
        if ($slider->image_path && File::exists(public_path($slider->image_path))) {
            File::delete(public_path($slider->image_path));
        }

        $slider->delete();

        return redirect()->route('homepage.index', ['tab' => 'sliders'])->with('success', 'Banner slide deleted successfully.');
    }
}
