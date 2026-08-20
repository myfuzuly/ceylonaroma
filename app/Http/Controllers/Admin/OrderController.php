<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with('items')->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($query) use ($s) {
                $query->where('order_number', 'like', "%{$s}%")
                      ->orWhere('name', 'like', "%{$s}%")
                      ->orWhere('email', 'like', "%{$s}%")
                      ->orWhere('company', 'like', "%{$s}%");
            });
        }

        $orders = $q->paginate(20)->withQueryString();

        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,confirmed,shipped,delivered,cancelled',
        ]);

        $previous = $order->status;
        $order->update(['status' => $request->status]);

        /* Send customer email on meaningful status transitions */
        $notifyOn = ['confirmed', 'shipped', 'delivered', 'cancelled'];
        if (in_array($request->status, $notifyOn) && $request->status !== $previous && $order->email) {
            try {
                Mail::to($order->email)->send(new OrderStatusMail($order));
            } catch (\Throwable) {
                /* Non-fatal — status is saved regardless */
            }
        }

        return back()->with('success', "Order #{$order->order_number} status updated to {$request->status}.");
    }
}
