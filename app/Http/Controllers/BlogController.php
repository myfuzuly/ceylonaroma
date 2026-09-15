<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, string $category = null)
    {
        $request->validate([
            'category' => 'nullable|string|max:100',
            'page'     => 'nullable|integer|min:1|max:9999',
        ]);

        $categories = BlogPost::where('status', true)->distinct()->pluck('category')->filter();

        // Resolve category: route segment slug takes priority over query string
        $activeCategory = null;
        if ($category !== null) {
            // Match slug to actual DB category name
            $activeCategory = $categories->first(
                fn($cat) => \Illuminate\Support\Str::slug($cat) === $category
            );
        } elseif ($request->category) {
            $activeCategory = substr(trim($request->category), 0, 100);
        }

        $query = BlogPost::where('status', true)->orderByDesc('published_at');
        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }
        $posts = $query->paginate(9)->withQueryString();

        return view('blog.index', compact('posts', 'categories', 'activeCategory'));
    }

    public function show(BlogPost $blog_post)
    {
        $related = BlogPost::where('status', true)
            ->where('id', '!=', $blog_post->id)
            ->take(3)->get();
        return view('blog.show', compact('blog_post','related'));
    }
}
