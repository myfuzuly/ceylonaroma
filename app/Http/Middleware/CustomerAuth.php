<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;

class CustomerAuth
{
    public function handle(Request $request, Closure $next)
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login')
                ->with('error', 'Please login to continue.');
        }

        $customer = Customer::find($customerId);

        if (!$customer || (isset($customer->is_active) && !$customer->is_active)) {
            $request->session()->forget(['customer_id', 'customer_name']);
            return redirect()->route('customer.login')
                ->with('error', $customer ? 'Your account has been disabled. Please contact us.' : 'Please login to continue.');
        }

        return $next($request);
    }
}
