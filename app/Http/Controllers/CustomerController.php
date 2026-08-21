<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer     = Customer::find(session('customer_id'));
        $orders       = Order::with('items')
            ->where('customer_id', $customer->id)
            ->latest()->take(5)->get();
        $totalOrders    = Order::where('customer_id', $customer->id)->count();
        $deliveredOrders = Order::where('customer_id', $customer->id)->where('status', 'delivered')->count();
        $activeOrders   = Order::where('customer_id', $customer->id)->whereIn('status', ['pending', 'processing', 'shipped'])->count();
        return view('customer.dashboard', compact('customer', 'orders', 'totalOrders', 'deliveredOrders', 'activeOrders'));
    }

    public function orders()
    {
        $customer = Customer::find(session('customer_id'));
        $orders   = Order::with('items')
            ->where('customer_id', $customer->id)
            ->latest()->paginate(15);
        return view('customer.orders', compact('customer', 'orders'));
    }

    public function orderShow(string $orderNumber)
    {
        $customer = Customer::find(session('customer_id'));
        $order    = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('customer_id', $customer->id)
            ->firstOrFail();
        return view('customer.order-show', compact('customer', 'order'));
    }

    public function profile()
    {
        $customer = Customer::find(session('customer_id'));
        return view('customer.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Customer::find(session('customer_id'));

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:20|unique:customers,phone,' . $customer->id,
            'company' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($data);
        session(['customer_name' => $customer->name]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $customer = Customer::find(session('customer_id'));

        if (!$customer->password || !\Illuminate\Support\Facades\Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $customer->update(['password' => $request->password]);

        return back()->with('success', 'Password updated.');
    }
}
