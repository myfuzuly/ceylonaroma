<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;

class WholesalePriceController extends Controller
{
    public function index()
    {
        $products = Product::where('status', true)->orderBy('name')->get();

        $all = WholesalePrice::with('product')
            ->whereHas('product', fn($q) => $q->where('status', true))
            ->orderByDesc('updated_at')
            ->get()
            ->groupBy('product_id');

        $rows = $all->map(function ($group) {
            $sorted = $group->sortByDesc('updated_at')->values();
            return [
                'product' => $sorted->first()->product,
                'current' => $sorted->first(),
                'history' => $sorted->slice(1)->values(),
            ];
        })->sortBy(fn($row) => $row['product']->name)->values();

        $lastUpdated = $rows->max(fn($row) => $row['current']->updated_at);

        $byDate = $all->flatten()
            ->sortByDesc('updated_at')
            ->groupBy(fn($wp) => $wp->updated_at->format('Y-m-d'))
            ->map(fn($group) => $group->sortBy(fn($wp) => $wp->product->name)->values())
            ->sortKeysDesc();

        return view('admin.wholesale-prices.index', compact('rows', 'products', 'lastUpdated', 'byDate'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price'      => 'required|numeric|min:0',
            'currency'   => 'nullable|string|max:8',
            'unit'       => 'nullable|string|max:50',
        ]);

        WholesalePrice::create([
            'product_id' => $data['product_id'],
            'price'      => $data['price'],
            'currency'   => $data['currency'] ?? 'USD',
            'unit'       => $data['unit'] ?? 'kg',
        ]);

        return back()->with('success', 'Wholesale price saved. Previous prices for this product are kept as history.');
    }

    public function destroy(WholesalePrice $wholesalePrice)
    {
        $wholesalePrice->delete();
        return back()->with('success', 'Wholesale price removed.');
    }
}
