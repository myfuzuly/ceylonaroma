<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->withCount('products')->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('sort_order')->get();
        return view('admin.categories.form', ['category' => new Category, 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'status'      => 'boolean',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['status']    = $request->boolean('status', true);
        $data['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')->get();
        return view('admin.categories.form', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'status'      => 'boolean',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);
        $data['status']    = $request->boolean('status', true);
        $data['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;
        if ($request->boolean('remove_image')) {
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
