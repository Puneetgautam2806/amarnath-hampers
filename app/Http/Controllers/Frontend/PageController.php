<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;

class PageController extends Controller
{
    public function pageShow($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.page', compact('page'));
    }

    public function about()
    {
        // Fallback to a page with slug 'about', or just a dedicated view if it doesn't exist
        $page = Page::where('slug', 'about')->where('status', 1)->first();
        if (!$page) {
            $page = new Page(['title' => 'About Us', 'content' => 'Information about us...']);
        }
        return view('frontend.page', compact('page'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function blogIndex()
    {
        $posts = Post::where('status', 1)->orderBy('published_at', 'desc')->paginate(12);
        return view('frontend.blog', compact('posts'));
    }

    public function blogShow($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.post', compact('post'));
    }
}
