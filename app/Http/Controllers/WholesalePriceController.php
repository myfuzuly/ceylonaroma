<?php

namespace App\Http\Controllers;

use App\Models\WholesalePrice;
use Illuminate\Support\Carbon;

class WholesalePriceController extends Controller
{
    public function index()
    {
        $dates = WholesalePrice::whereHas('product', fn($q) => $q->where('status', true))
            ->selectRaw('DATE(updated_at) as d')
            ->distinct()
            ->orderByDesc('d')
            ->pluck('d');

        $history = [];

        foreach ($dates as $date) {
            $endOfDay = $date . ' 23:59:59';

            $items = WholesalePrice::with('product')
                ->whereHas('product', fn($q) => $q->where('status', true))
                ->where('updated_at', '<=', $endOfDay)
                ->orderByDesc('updated_at')
                ->get()
                ->unique('product_id')
                ->sortBy(fn($wp) => $wp->product->name)
                ->values();

            if ($items->count()) {
                $history[] = [
                    'date'  => Carbon::parse($date),
                    'items' => $items,
                ];
            }
        }

        return view('wholesale-prices', compact('history'));
    }
}
