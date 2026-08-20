<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = Customer::withCount('orders')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($query) use ($s) {
                $query->where('name', 'like', "%{$s}%")
                      ->orWhere('email', 'like', "%{$s}%")
                      ->orWhere('company', 'like', "%{$s}%")
                      ->orWhere('country', 'like', "%{$s}%");
            });
        }

        $customers = $q->paginate(25)->withQueryString();
        $total     = Customer::count();

        return view('admin.customers.index', compact('customers', 'total'));
    }

    public function show(Customer $customer)
    {
        $orders = Order::with('items')
            ->where('customer_id', $customer->id)
            ->latest()->get();
        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function toggleStatus(Customer $customer)
    {
        $customer->update(['is_active' => !($customer->is_active ?? true)]);
        $state = ($customer->is_active ?? true) ? 'enabled' : 'disabled';
        return back()->with('success', "Customer account {$state}.");
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted.');
    }
}
