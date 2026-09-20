<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Roll-forward commodity prices — daily at 11:00 AM Sri Lanka Time
| If no prices have been entered for today, copy yesterday's rows to today.
|--------------------------------------------------------------------------
*/
Schedule::call(function () {
    $today     = now()->toDateString();
    $yesterday = now()->subDay()->toDateString();

    // Skip if today's prices already exist
    if (DB::table('commodity_prices')->whereDate('price_date', $today)->exists()) {
        Log::info("Commodity prices: entries already exist for {$today}, skipping roll-forward.");
        return;
    }

    $rows = DB::table('commodity_prices')
        ->whereDate('price_date', $yesterday)
        ->get();

    if ($rows->isEmpty()) {
        Log::warning("Commodity prices: no rows found for {$yesterday}, nothing to roll forward.");
        return;
    }

    $inserts = $rows->map(fn($r) => [
        'commodity'  => $r->commodity,
        'grade'      => $r->grade,
        'price_lkr'  => $r->price_lkr,
        'price_usd'  => $r->price_usd,
        'sort_order' => $r->sort_order,
        'price_date' => $today,
        'is_visible' => $r->is_visible,
        'created_at' => now(),
        'updated_at' => now(),
    ])->toArray();

    DB::table('commodity_prices')->insert($inserts);

    Log::info("Commodity prices: rolled forward " . count($inserts) . " rows from {$yesterday} to {$today}.");
})->timezone('Asia/Colombo')->dailyAt('11:00')->name('prices:rollforward')->withoutOverlapping();
