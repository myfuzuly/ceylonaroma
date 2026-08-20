<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query();
        if ($request->search) $query->where('title','like','%'.$request->search.'%');
        $posts = $query->orderByDesc('published_at')->paginate(15)->withQueryString();
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.form', ['post' => new BlogPost]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'nullable|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'status'       => 'boolean',
        ]);
        $data['slug']   = Str::slug($data['title']);
        $data['status'] = $request->boolean('status', true);
        $data['published_at'] = $data['published_at'] ?? now();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog','public');
        }
        BlogPost::create($data);
        return redirect()->route('admin.blog.index')->with('success','Post created.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.form', ['post' => $blog]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'nullable|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'status'       => 'boolean',
        ]);
        $data['status'] = $request->boolean('status', true);
        if ($request->boolean('remove_image')) {
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog','public');
        }
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success','Post updated.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return back()->with('success','Post deleted.');
    }
}
