<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\ContactMessage;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pageShow($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        $settings = SiteSetting::first();
        return view('frontend.page', compact('page', 'settings'));
    }

    public function about()
    {
        $settings = SiteSetting::first();
        $testimonials = \App\Models\Testimonial::where('status', 1)->orderBy('sort_order', 'asc')->get();
        return view('frontend.about', compact('settings', 'testimonials'));
    }

    public function contact()
    {
        $settings = SiteSetting::first();
        return view('frontend.contact', compact('settings'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:25',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully. Our team will get back to you shortly.');
    }

    public function blogIndex(Request $request)
    {
        $query = Post::where('status', 1)->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9);
        $recentPosts = Post::where('status', 1)->orderBy('id', 'desc')->take(5)->get();
        $categories = Category::where('status', 1)->withCount('products')->get();
        $settings = SiteSetting::first();

        return view('frontend.blog', compact('posts', 'recentPosts', 'categories', 'settings'));
    }

    public function blogShow($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 1)->firstOrFail();
        $recentPosts = Post::where('status', 1)->where('id', '!=', $post->id)->orderBy('id', 'desc')->take(4)->get();
        $categories = Category::where('status', 1)->withCount('products')->get();
        $settings = SiteSetting::first();

        return view('frontend.post', compact('post', 'recentPosts', 'categories', 'settings'));
    }
}
