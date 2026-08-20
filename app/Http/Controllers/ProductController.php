<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', true)->with('category');

        if ($request->category) {
            $cat = Category::where('slug', $request->category)->firstOrFail();
            $childIds = Category::where('parent_id', $cat->id)->pluck('id');
            $query->whereIn('category_id', $childIds->push($cat->id));
        }
        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->tab) {
            match($request->tab) {
                'featured'   => $query->where('is_featured', true),
                'bestseller' => $query->where('is_bestseller', true),
                'new'        => $query->where('is_new_arrival', true),
                'export'     => $query->where('is_export_ready', true),
                default      => null,
            };
        }

        $products   = $query->orderBy('sort_order')->paginate(12)->withQueryString();
        $categories = Category::where('status', true)->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->where('status', true)->orderBy('sort_order')])
            ->orderBy('sort_order')->get();

        return view('products.index', compact('products','categories'));
    }

    public function show(Product $product)
    {
        $related = Product::where('status', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        return view('products.show', compact('product','related'));
    }
}
