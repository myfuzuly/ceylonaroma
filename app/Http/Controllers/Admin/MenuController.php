<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->withCount('children')
            ->orderBy('nav_order')
            ->orderBy('sort_order')
            ->get();

        $settings = Setting::getAllKeyed();

        return view('admin.menu.index', compact('categories', 'settings'));
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:categories,id']);

        foreach ($request->order as $position => $id) {
            Category::where('id', $id)->update(['nav_order' => $position]);
        }

        return response()->json(['success' => true]);
    }

    public function toggle(Category $category)
    {
        $category->show_in_nav = ! $category->show_in_nav;
        $category->save();

        return response()->json(['show_in_nav' => $category->show_in_nav]);
    }

    public function updateFeatured(Request $request)
    {
        $request->validate([
            'nav_featured_title' => 'nullable|string|max:120',
            'nav_featured_desc'  => 'nullable|string|max:300',
            'nav_featured_url'   => 'nullable|url|max:500',
            'nav_featured_image' => 'nullable|image|max:2048',
        ]);

        Setting::set('nav_featured_title', $request->input('nav_featured_title', ''));
        Setting::set('nav_featured_desc',  $request->input('nav_featured_desc', ''));
        Setting::set('nav_featured_url',   $request->input('nav_featured_url', ''));

        if ($request->hasFile('nav_featured_image')) {
            $dest = public_path('images');
            if (! is_dir($dest)) {
                mkdir($dest, 0755, true);
            }
            $request->file('nav_featured_image')->move($dest, 'nav-featured.jpg');
            Setting::set('nav_featured_image', 'images/nav-featured.jpg');
        }

        return redirect()->route('admin.menu.index')->with('success', 'Featured panel updated.');
    }
}
