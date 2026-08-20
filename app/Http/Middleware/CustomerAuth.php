<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('customer_id')) {
            return redirect()->route('customer.login')
                ->with('error', 'Please login to continue.');
        }
        return $next($request);
    }
}
