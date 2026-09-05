<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(15);
        return view('backoffice.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('backoffice.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:1,2',
            'published_at' => 'nullable|date',
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        
        // Ensure unique slug
        $baseSlug = $post->slug;
        $count = 1;
        while (Post::where('slug', $post->slug)->exists()) {
            $post->slug = "{$baseSlug}-" . $count++;
        }

        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150);
        $post->content = $validated['content'];
        $post->author_name = $validated['author_name'] ?? 'Amar Nath Hampers';
        $post->status = (int) $validated['status'];
        $post->published_at = !empty($validated['published_at']) ? $validated['published_at'] : now();

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $fileName = 'post_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $fileName);
            $post->featured_image = 'uploads/posts/' . $fileName;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('backoffice.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:1,2',
            'published_at' => 'nullable|date',
        ]);

        $post->title = $validated['title'];
        if (!empty($validated['slug'])) {
            $post->slug = Str::slug($validated['slug']);
        } else {
            $post->slug = Str::slug($validated['title']);
        }

        // Ensure unique slug (excluding current)
        $baseSlug = $post->slug;
        $count = 1;
        while (Post::where('slug', $post->slug)->where('id', '!=', $post->id)->exists()) {
            $post->slug = "{$baseSlug}-" . $count++;
        }

        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150);
        $post->content = $validated['content'];
        $post->author_name = $validated['author_name'] ?? 'Amar Nath Hampers';
        $post->status = (int) $validated['status'];
        $post->published_at = !empty($validated['published_at']) ? $validated['published_at'] : $post->published_at ?? now();

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && File::exists(public_path($post->featured_image))) {
                File::delete(public_path($post->featured_image));
            }
            $file = $request->file('featured_image');
            $fileName = 'post_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $fileName);
            $post->featured_image = 'uploads/posts/' . $fileName;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image && File::exists(public_path($post->featured_image))) {
            File::delete(public_path($post->featured_image));
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Blog post deleted successfully.');
    }
}
