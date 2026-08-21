<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayHereController extends Controller
{
    private string $merchantId;
    private string $merchantSecret;
    private string $baseUrl;

    public function __construct()
    {
        $this->merchantId     = env('PAYHERE_MERCHANT_ID', '');
        $this->merchantSecret = env('PAYHERE_MERCHANT_SECRET', '');
        $this->baseUrl        = env('PAYHERE_SANDBOX', 'false') === 'true'
            ? 'https://sandbox.payhere.lk/pay/checkout'
            : 'https://www.payhere.lk/pay/checkout';
    }

    /**
     * Initialize PayHere checkout — called via AJAX from checkout page.
     * Creates a pending order, returns PayHere form fields.
     */
    public function initiate(Request $request)
    {
        if (env('PAYHERE_ENABLED', 'false') !== 'true') {
            return response()->json(['error' => 'Payment gateway is not available. Please contact us to place your order.'], 503);
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 422);
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

        do {
            $orderNumber = 'CA-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        $order = Order::create([
            'order_number'   => $orderNumber,
            'customer_id'    => session('customer_id'),
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'] ?? null,
            'company'        => $data['company'] ?? null,
            'country'        => $data['country'],
            'address'        => $data['address'] ?? null,
            'notes'          => $data['notes'] ?? null,
            'status'         => 'pending',
            'payment_method' => 'payhere',
            'payment_status' => 'pending',
            'items_count'    => count($cart),
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

        // PayHere requires a total amount — since this is B2B/quote based, use 1.00 LKR as placeholder
        // In production, calculate actual price per product
        $amount   = number_format(1.00, 2, '.', '');
        $currency = 'LKR';
        $hash     = strtoupper(md5(
            $this->merchantId .
            $order->order_number .
            $amount .
            $currency .
            strtoupper(md5($this->merchantSecret))
        ));

        $fields = [
            'merchant_id'  => $this->merchantId,
            'return_url'   => route('payhere.return'),
            'cancel_url'   => route('payhere.cancel'),
            'notify_url'   => route('payhere.notify'),
            'order_id'     => $order->order_number,
            'items'        => implode(', ', array_column($cart, 'name')),
            'currency'     => $currency,
            'amount'       => $amount,
            'first_name'   => explode(' ', $data['name'])[0],
            'last_name'    => implode(' ', array_slice(explode(' ', $data['name']), 1)) ?: '-',
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? '0000000000',
            'address'      => $data['address'] ?? $data['country'],
            'city'         => $data['country'],
            'country'      => $data['country'],
            'hash'         => $hash,
        ];

        session(['payhere_order' => $order->order_number]);
        session()->forget('cart');

        return response()->json([
            'checkout_url' => $this->baseUrl,
            'fields'       => $fields,
        ]);
    }

    /**
     * PayHere IPN (server-to-server notification) — verified with MD5 hash.
     */
    public function notify(Request $request)
    {
        $merchantId     = $request->input('merchant_id');
        if ($merchantId !== $this->merchantId) {
            Log::warning("PayHere IPN: merchant_id mismatch");
            return response('Forbidden', 403);
        }
        $orderId        = $request->input('order_id');
        $paymentId      = $request->input('payment_id');
        $payhere_amount = $request->input('payhere_amount');
        $payhere_currency = $request->input('payhere_currency');
        $status_code    = $request->input('status_code');
        $md5sig         = $request->input('md5sig');

        $local_md5sig = strtoupper(md5(
            $merchantId .
            $orderId .
            $payhere_amount .
            $payhere_currency .
            $status_code .
            strtoupper(md5($this->merchantSecret))
        ));

        if ($local_md5sig !== $md5sig) {
            Log::warning("PayHere IPN hash mismatch for order {$orderId}");
            return response('Hash mismatch', 400);
        }

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            Log::warning("PayHere IPN: order {$orderId} not found");
            return response('Order not found', 404);
        }

        // status_code: 2 = success, 0 = pending, -1 = cancelled, -2 = failed, -3 = chargedback
        $paymentStatus = match ((int) $status_code) {
            2       => 'paid',
            0       => 'pending',
            -1      => 'cancelled',
            default => 'failed',
        };

        $orderStatus = $status_code == 2 ? 'processing' : $order->status;

        $order->update([
            'payment_status' => $paymentStatus,
            'payment_id'     => $paymentId,
            'status'         => $orderStatus,
        ]);

        Log::info("PayHere IPN processed: order={$orderId}, status={$paymentStatus}");
        return response('OK', 200);
    }

    /**
     * PayHere return URL — buyer comes back after payment.
     */
    public function returnUrl(Request $request)
    {
        $orderNumber = session('payhere_order') ?? $request->input('order_id');
        session()->forget('payhere_order');

        if (!$orderNumber) {
            return redirect()->route('home')->with('success', 'Payment processed. Check your email for confirmation.');
        }

        return redirect()->route('order.confirmation', $orderNumber);
    }

    /**
     * PayHere cancel URL — buyer cancelled payment.
     */
    public function cancelUrl(Request $request)
    {
        $orderNumber = session('payhere_order') ?? $request->input('order_id');
        session()->forget('payhere_order');

        if ($orderNumber) {
            Order::where('order_number', $orderNumber)->update(['payment_status' => 'cancelled']);
        }

        return redirect()->route('checkout')->with('error', 'Payment was cancelled. Your order details have been saved — try again or choose a different payment method.');
    }
}
