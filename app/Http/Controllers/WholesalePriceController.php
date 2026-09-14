<?php

namespace App\Http\Controllers;

use App\Models\CommodityPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WholesalePriceController extends Controller
{
    public function index()
    {
        $currentPrices  = CommodityPrice::currentPrices();
        $grouped        = $currentPrices->groupBy('commodity');
        $lastUpdated    = CommodityPrice::lastUpdatedDate();
        $availableDates = CommodityPrice::availableDates()->take(60);

        // Format last updated with 11:00 AM Sri Lanka Time note
        $lastUpdatedFormatted = $lastUpdated
            ? Carbon::parse($lastUpdated)->setTimezone('Asia/Colombo')->format('d M Y') . ' · 11:00 AM (Sri Lanka Time)'
            : null;

        return view('wholesale-prices', compact('grouped', 'lastUpdated', 'lastUpdatedFormatted', 'availableDates'));
    }

    public function byDate(Request $request)
    {
        $date   = $request->validate(['date' => 'required|date'])['date'];
        $prices = CommodityPrice::pricesForDate($date)->values();
        return response()->json($prices);
    }
}
