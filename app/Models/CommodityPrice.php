<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommodityPrice extends Model
{
    protected $fillable = ['commodity', 'grade', 'price_lkr', 'price_usd', 'sort_order', 'price_date'];

    protected $casts = [
        'price_date' => 'date',
        'price_lkr'  => 'decimal:2',
        'price_usd'  => 'decimal:2',
    ];

    public static function currentPrices()
    {
        $sub = DB::table('commodity_prices')
            ->selectRaw('commodity, grade, MAX(price_date) as max_date')
            ->groupBy('commodity', 'grade');

        return static::select('commodity_prices.*')
            ->joinSub($sub, 'latest', function ($join) {
                $join->on('commodity_prices.commodity', '=', 'latest.commodity')
                     ->on('commodity_prices.grade', '=', 'latest.grade')
                     ->on('commodity_prices.price_date', '=', 'latest.max_date');
            })
            ->orderBy('sort_order')
            ->get();
    }

    public static function pricesForDate(string $date)
    {
        $sub = DB::table('commodity_prices')
            ->selectRaw('commodity, grade, MAX(price_date) as max_date')
            ->where('price_date', '<=', $date)
            ->groupBy('commodity', 'grade');

        return static::select('commodity_prices.*')
            ->joinSub($sub, 'latest', function ($join) {
                $join->on('commodity_prices.commodity', '=', 'latest.commodity')
                     ->on('commodity_prices.grade', '=', 'latest.grade')
                     ->on('commodity_prices.price_date', '=', 'latest.max_date');
            })
            ->orderBy('sort_order')
            ->get();
    }

    public static function lastUpdatedDate()
    {
        return static::max('price_date');
    }

    public static function availableDates()
    {
        return static::selectRaw('DISTINCT price_date')
            ->orderByDesc('price_date')
            ->pluck('price_date');
    }
}
