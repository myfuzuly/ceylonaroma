<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products   = Product::where('status', 1)->select('slug','updated_at')->get();
        $categories = Category::whereNull('parent_id')->select('slug','updated_at')->get();
        $posts      = BlogPost::where('status', 1)->select('slug','updated_at')->get();

        $staticPages = [
            ['loc' => route('home'),           'priority' => '1.0', 'freq' => 'weekly'],
            ['loc' => route('products.index'), 'priority' => '0.9', 'freq' => 'daily'],
            ['loc' => route('contact'),        'priority' => '0.8', 'freq' => 'monthly'],
            ['loc' => route('about'),          'priority' => '0.7', 'freq' => 'monthly'],
            ['loc' => route('export'),         'priority' => '0.7', 'freq' => 'monthly'],
            ['loc' => route('quality'),        'priority' => '0.7', 'freq' => 'monthly'],
            ['loc' => route('private-label'),  'priority' => '0.7', 'freq' => 'monthly'],
            ['loc' => route('blog.index'),     'priority' => '0.6', 'freq' => 'weekly'],
        ];

        $url = fn(string $loc, string $freq, string $priority, ?string $lastmod = null): string =>
            "<url><loc>" . htmlspecialchars($loc) . "</loc>" .
            ($lastmod ? "<lastmod>{$lastmod}</lastmod>" : '') .
            "<changefreq>{$freq}</changefreq><priority>{$priority}</priority></url>\n";

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($staticPages as $p) {
            $xml .= $url($p['loc'], $p['freq'], $p['priority']);
        }
        foreach ($categories as $cat) {
            $xml .= $url(
                route('products.index', ['category' => $cat->slug]),
                'weekly', '0.8',
                $cat->updated_at->toAtomString()
            );
        }
        foreach ($products as $product) {
            $xml .= $url(
                route('products.show', $product->slug),
                'weekly', '0.7',
                $product->updated_at->toAtomString()
            );
        }
        foreach ($posts as $post) {
            $xml .= $url(
                route('blog.show', $post->slug),
                'monthly', '0.5',
                $post->updated_at->toAtomString()
            );
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
