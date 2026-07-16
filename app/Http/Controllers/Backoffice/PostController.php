<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $items = Post::orderBy('id', 'desc')->get();
        return view('backoffice.posts.index', compact('items'));
    }

    public function create()
    {
        return view('backoffice.posts.create');
    }

    public function store(Request $request)
    {
        // basic validation
        $item = new Post();
        // assign fields here manually in actual code, this is scaffolding
        $item->save();
        return redirect()->route('posts.index')->with('success', 'Created successfully.');
    }

    public function edit(Post $post)
    {
        return view('backoffice.posts.edit', ['item' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Deleted successfully.');
    }
}
