<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $customer = session('customer_id')
            ? Customer::find(session('customer_id'))
            : null;

        return view('checkout', compact('cart', 'customer'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:30',
            'company' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'notes'   => 'nullable|string|max:1000',
        ]);

        // Generate unique order number
        do {
            $orderNumber = 'CA-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_id'  => session('customer_id'),
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? null,
            'company'      => $data['company'] ?? null,
            'country'      => $data['country'],
            'address'      => $data['address'] ?? null,
            'notes'        => $data['notes'] ?? null,
            'status'       => 'pending',
            'items_count'  => count($cart),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['id'],
                'product_name'  => $item['name'],
                'product_slug'  => $item['slug'],
                'product_image' => $item['image'],
                'quantity'      => $item['qty'],
            ]);
        }

        session()->forget('cart');

        try {
            Mail::to($order->email)->send(new OrderConfirmMail($order));
        } catch (\Throwable $e) {
            \Log::error('OrderConfirmMail failed: ' . $e->getMessage());
        }

        return redirect()->route('order.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('order-confirmation', compact('order'));
    }
}
