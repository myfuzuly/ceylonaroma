<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share settings with all views (cached per request)
        View::composer('*', function ($view) {
            if (!$view->offsetExists('settings')) {
                try {
                    $view->with('settings', Setting::getAllKeyed());
                } catch (\Throwable $e) {
                    $view->with('settings', []);
                }
            }
        });

        // Use our custom pagination views
        Paginator::defaultView('partials.pagination');
        Paginator::defaultSimpleView('partials.pagination');
    }
}
