<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommodityPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CommodityPriceController extends Controller
{
    public function index()
    {
        $currentPrices = CommodityPrice::currentPrices(visibleOnly: false);
        $grouped       = $currentPrices->groupBy('commodity');
        $lastUpdated   = CommodityPrice::lastUpdatedDate();
        $todayDate     = today()->toDateString();
        $todayCount    = CommodityPrice::where('price_date', $todayDate)->count();
        $totalCount    = $currentPrices->count();

        $historyDates = CommodityPrice::select('price_date', DB::raw('COUNT(*) as total'))
            ->groupBy('price_date')
            ->orderByDesc('price_date')
            ->limit(60)
            ->get();

        return view('admin.commodity-prices.index', compact(
            'grouped', 'lastUpdated', 'historyDates', 'todayDate', 'todayCount', 'totalCount', 'currentPrices'
        ));
    }

    public function bulkUpdate(Request $request)
    {
        $today = today()->toDateString();
        $rows  = $request->input('rows', []);

        DB::transaction(function () use ($rows, $today) {
            foreach ($rows as $row) {
                $lkr = ($row['price_lkr'] ?? '') !== '' ? (float) $row['price_lkr'] : null;
                $usd = ($row['price_usd'] ?? '') !== '' ? (float) $row['price_usd'] : null;

                CommodityPrice::updateOrCreate(
                    [
                        'commodity'  => $row['commodity'],
                        'grade'      => $row['grade'],
                        'price_date' => $today,
                    ],
                    [
                        'price_lkr'  => $lkr,
                        'price_usd'  => $usd,
                        'sort_order' => (int) ($row['sort_order'] ?? 0),
                        'is_visible' => isset($row['is_visible']) ? (int)(bool)$row['is_visible'] : 1,
                    ]
                );
            }
        });

        return redirect()->route('admin.commodity-prices.index')
            ->with('success', 'Commodity prices published for ' . Carbon::parse($today)->format('d M Y') . '.');
    }

    public function historyForDate(Request $request)
    {
        $date = $request->validate(['date' => 'required|date'])['date'];
        $prices = CommodityPrice::where('price_date', $date)->orderBy('sort_order')->get();
        return response()->json($prices);
    }
}
