<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class LegacyRedirectController extends Controller
{
    /**
     * Old WordPress category slugs that don't map 1:1 onto the current
     * category table (renamed, re-pluralized, or merged during migration).
     */
    private array $categoryAliases = [
        'h1-h2-cinnamon'       => 'h1-h2',
        'c4-cinnamon'          => 'c4',
        'flavoured-tea'        => 'flavored-tea',
        'alba-cinnamon'        => 'alba',
        'spices-dehydrated'    => 'dehydrated-spices',
        'bulk-cinnamon-export' => 'bulk',
        'cinnamon-cut'         => 'cinnamon-cuts',
        'fruits'               => 'dehydrated-fruits',
        'fruits-pulps'         => 'pulps',
        'dehydrated'           => 'dehydrated-products',
        'ceylon-cinnamon'      => 'true-ceylon-cinnamon',
        'ayurvedic-collections'=> 'ayurvedic-products',
        'leaves'               => 'dehydrated-leaves',
        'vegetables'           => 'dehydrated-vegetables',
        'spices'               => 'premium-ceylon-spices',
    ];

    /** Old /product/{slug}/ (WordPress) -> /products/{slug} */
    public function product(string $slug): RedirectResponse
    {
        if (Product::where('slug', $slug)->where('status', true)->exists()) {
            return redirect()->route('products.show', $slug, 301);
        }

        return redirect()->route('products.index', [], 301);
    }

    /** Old /category/{a}/{b?}/{c?}/ (WordPress, incl. /feed/ suffix) -> /products/category/{slug} */
    public function category(string $a, ?string $b = null, ?string $c = null): RedirectResponse
    {
        $segments = array_filter([$b, $a], fn ($v) => $v !== null && $v !== 'feed');

        foreach ($segments as $candidate) {
            if (Category::where('slug', $candidate)->exists()) {
                return redirect()->route('products.category', $candidate, 301);
            }
            if (isset($this->categoryAliases[$candidate])) {
                return redirect()->route('products.category', $this->categoryAliases[$candidate], 301);
            }
        }

        if (in_array($a, ['industry-news', 'uncategorized'], true)) {
            return redirect()->route('blog.index', [], 301);
        }

        return redirect()->route('products.index', [], 301);
    }

    /** Old /tag/{slug}/ (WordPress blog tags) -> /blog */
    public function tag(): RedirectResponse
    {
        return redirect()->route('blog.index', [], 301);
    }
}
