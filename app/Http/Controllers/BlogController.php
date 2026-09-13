<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'category' => 'nullable|string|max:100',
            'page'     => 'nullable|integer|min:1|max:9999',
        ]);

        $query = BlogPost::where('status', true)->orderByDesc('published_at');
        if ($request->category) {
            $query->where('category', substr(trim($request->category), 0, 100));
        }
        $posts = $query->paginate(9)->withQueryString();
        $categories = BlogPost::where('status', true)->distinct()->pluck('category')->filter();

        return view('blog.index', compact('posts','categories'));
    }

    public function show(BlogPost $blog_post)
    {
        $related = BlogPost::where('status', true)
            ->where('id', '!=', $blog_post->id)
            ->take(3)->get();
        return view('blog.show', compact('blog_post','related'));
    }
}
