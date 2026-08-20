<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Collection, BlogPost, Inquiry, Setting, Order, Customer};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'      => Product::count(),
            'categories'    => Category::count(),
            'collections'   => Collection::count(),
            'posts'         => BlogPost::count(),
            'inquiries'     => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status','new')->count(),
            'orders'        => Order::count(),
            'orders_pending'=> Order::where('status','pending')->count(),
            'customers'     => Customer::count(),
            'revenue_orders'=> Order::whereIn('status',['processing','shipped','delivered'])->count(),
            'low_stock'     => Product::whereNotNull('stock_qty')->whereColumn('stock_qty','<=','low_stock_threshold')->count(),
        ];

        $recentOrders    = Order::with('items')->latest()->take(8)->get();
        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentProducts  = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats','recentOrders','recentInquiries','recentProducts'));
    }
}
