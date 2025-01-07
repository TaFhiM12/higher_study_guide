<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\VisaPack;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {

        $offers = VisaPack::where('is_approved', 1)->get();
        return view('front.index', compact('offers'));
    }

    public function show_blogs()
{
    $posts = Post::latest()->paginate(10); // Paginate 6 posts per page
    return view('front.blog', compact('posts'));
}


    // Blog Search (AJAX)
    public function searchBlog(Request $request)
    {
        $query = $request->get('q', '');
    
        // Search for posts based on the title or post_content
        $posts = Post::where('title', 'like', "%$query%")
            ->orWhere('post_content', 'like', "%$query%")
            ->take(10) // Limit results for better performance
            ->get();
    
        // Return JSON response with required fields
        return response()->json([
            'posts' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => \Illuminate\Support\Str::limit(strip_tags($post->post_content), 500),
                    'image' => asset('storage/'.$post->image),
                    'created_at' => $post->created_at->format('Y-m-d'), // Add created_at for display
                ];
            }),
        ]);
    }
    

    // Single Blog Post
    public function blogShow($id)
    {
        $post = Post::findOrFail($id);
        return view('front.blog-details', compact('post'));
    }
}
