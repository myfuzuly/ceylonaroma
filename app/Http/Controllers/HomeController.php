<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Collection;
use App\Models\BlogPost;
use App\Models\Setting;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $categories   = Category::where('status', true)->whereNull('parent_id')->orderBy('sort_order')->get();
        $featured     = Product::where('status', true)->where('is_featured', true)->with('category')->take(6)->get();
        $latest       = Product::where('status', true)->with('category')->latest()->take(6)->get();
        $bestsellers  = Product::where('status', true)->where('is_bestseller', true)->with('category')->take(6)->get();
        $newArrivals  = Product::where('status', true)->where('is_new_arrival', true)->with('category')->take(6)->get();
        $exportReady  = Product::where('status', true)->where('is_export_ready', true)->with('category')->take(6)->get();
        $collections  = Collection::where('status', true)->orderBy('sort_order')->take(4)->get();
        $posts        = BlogPost::where('status', true)->orderByDesc('published_at')->take(4)->get();
        $settings     = Setting::getAllKeyed();
        $slides       = Slider::where('status', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('home', compact(
            'categories','featured','latest','bestsellers',
            'newArrivals','exportReady','collections','posts','settings','slides'
        ));
    }
}
