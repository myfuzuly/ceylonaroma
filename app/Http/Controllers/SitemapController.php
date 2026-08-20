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
        $products   = Product::where('is_active', true)->select('slug','updated_at')->get();
        $categories = Category::whereNull('parent_id')->select('slug','updated_at')->get();
        $posts      = BlogPost::where('is_published', true)->select('slug','updated_at')->get();

        $staticPages = [
            ['loc' => route('home'),           'priority' => '1.0',  'freq' => 'weekly'],
            ['loc' => route('products.index'), 'priority' => '0.9',  'freq' => 'daily'],
            ['loc' => route('contact'),        'priority' => '0.8',  'freq' => 'monthly'],
            ['loc' => route('about'),          'priority' => '0.7',  'freq' => 'monthly'],
            ['loc' => route('export'),         'priority' => '0.7',  'freq' => 'monthly'],
            ['loc' => route('quality'),        'priority' => '0.7',  'freq' => 'monthly'],
            ['loc' => route('blog.index'),     'priority' => '0.6',  'freq' => 'weekly'],
        ];

        $xml = view('sitemap', compact('products','categories','posts','staticPages'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
