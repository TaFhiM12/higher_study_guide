<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index()
    {
        $blogs = Post::latest()->paginate(10); // Fetch all blogs with pagination
        return view('admin.blogs.index', compact('blogs'));
    }

    public function admin_show() {
        $blogs = Post::all();
        return view('admin.blogs.admin-show', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'post_content' => 'required|string',
            'image' => 'nullable|image',
            'country_name' => 'required|string',
            'degree_type' => 'required|in:Undergraduate,Masters,PhD',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['publishers'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        Post::create($data);

        session()->flash('success', 'Blog created successfully!');
        return redirect()->route('blogs.admin_show');
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            session()->flash('error', 'You are not authorized to edit this blog.');
            return redirect()->route('blogs.admin_show');
        }

        return view('admin.blogs.edit', compact('post'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            session()->flash('error', 'You are not authorized to update this blog.');
            return redirect()->route('blogs.admin_show');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'country_name' => 'required|string',
            'degree_type' => 'required|in:Undergraduate,Masters,PhD',
            'publishers' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $post->update($data);

        session()->flash('success', 'Blog updated successfully!');
        return redirect()->route('blogs.admin_show');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            session()->flash('error', 'You are not authorized to delete this blog.');
            return redirect()->route('blogs.admin_show');
        }

        $post->delete();

        session()->flash('success', 'Blog deleted successfully!');
        return redirect()->route('blogs.admin_show');
    }
}
