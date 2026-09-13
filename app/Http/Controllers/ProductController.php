<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ?Category $category = null)
    {
        $request->validate([
            'category' => 'nullable|string|max:100|alpha_dash',
            'search'   => 'nullable|string|max:200',
            'tab'      => 'nullable|in:featured,bestseller,new,export',
            'page'     => 'nullable|integer|min:1|max:9999',
        ]);

        // Canonicalize old ?category= query-string links to the clean /products/category/{slug} URL
        if (!$category && $request->category) {
            $legacyCat = Category::where('slug', $request->category)->first();
            if (!$legacyCat) abort(404);
            return redirect()->route('products.category', $legacyCat->slug, 301);
        }

        $query = Product::where('status', true)->with('category');

        if ($category) {
            $childIds = Category::where('parent_id', $category->id)->pluck('id');
            $query->whereIn('category_id', $childIds->push($category->id));
        }
        if ($request->search) {
            $search = substr(trim($request->search), 0, 200);
            $query->where('name', 'like', '%'.$search.'%');
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

        return view('products.index', compact('products','categories','category'));
    }

    public function suggestions(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);
        $q = trim((string) $request->q);

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', true)
            ->with('category')
            ->where('name', 'like', '%'.$q.'%')
            ->orderBy('sort_order')
            ->take(6)
            ->get(['id', 'name', 'slug', 'image', 'category_id']);

        return response()->json($products->map(fn($p) => [
            'name'     => $p->name,
            'slug'     => $p->slug,
            'image'    => $p->image
                ? (\Illuminate\Support\Str::startsWith($p->image, ['http', '/']) ? $p->image : asset('storage/'.$p->image))
                : null,
            'category' => $p->category?->name,
            'url'      => route('products.show', $p->slug),
        ]));
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
