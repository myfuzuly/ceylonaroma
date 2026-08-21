<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Order Update</title>
<style>
body{margin:0;padding:0;font-family:Inter,'Helvetica Neue',Arial,sans-serif;background:#f5edd8;color:#1a2a20}
.wrap{max-width:580px;margin:2rem auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
.header{background:#1b4332;padding:2rem 2.5rem;text-align:center}
.header img{height:44px;display:inline-block}
.status-band{padding:1rem 2.5rem;font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#fff;text-align:center}
.status-confirmed {background:#2563eb}
.status-processing{background:#d97706}
.status-shipped   {background:#7c3aed}
.status-delivered {background:#16a34a}
.status-cancelled {background:#dc2626}
.body{padding:2rem 2.5rem}
h2{font-size:1.25rem;font-weight:700;margin:0 0 .75rem;color:#1b4332}
p{line-height:1.65;color:#3a4a3e;margin:0 0 1rem;font-size:.93rem}
.order-box{background:#f5edd8;border-radius:8px;padding:1.25rem 1.5rem;margin:1.25rem 0}
.order-num{font-size:1.1rem;font-weight:700;color:#1b4332;margin-bottom:.5rem}
.item-row{display:flex;justify-content:space-between;font-size:.87rem;padding:.25rem 0;color:#3a4a3e}
.footer{background:#f5edd8;padding:1.25rem 2.5rem;text-align:center;font-size:.75rem;color:#6b7a70}
.btn{display:inline-block;background:#c8922a;color:#fff;padding:.7rem 1.5rem;border-radius:8px;font-weight:600;font-size:.88rem;text-decoration:none}
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <img src="https://ceylonaroma.com/images/ceylonaroma3.png" alt="Ceylon Aroma">
    </div>
    <div class="status-band status-{{ $order->status }}">
        @php
        $label = match($order->status) {
            'confirmed'  => 'Order Confirmed',
            'processing' => 'In Processing',
            'shipped'    => 'Shipped',
            'delivered'  => 'Delivered',
            'cancelled'  => 'Cancelled',
            default      => ucfirst($order->status),
        };
        @endphp
        {{ $label }}
    </div>
    <div class="body">
        <h2>
            @if($order->status === 'shipped') Your order is on its way!
            @elseif($order->status === 'delivered') Your order has arrived!
            @elseif($order->status === 'confirmed') Your order is confirmed!
            @elseif($order->status === 'cancelled') Order Cancelled
            @else Order Update
            @endif
        </h2>
        <p>Hi {{ $order->name }},</p>
        @if($order->status === 'shipped')
        <p>Great news — your Ceylon Aroma order has been dispatched and is on its way to you. Our team will reach out with tracking details if applicable.</p>
        @elseif($order->status === 'delivered')
        <p>Your order has been marked as delivered. We hope you are delighted with your Ceylon Aroma products. Please don't hesitate to contact us with any feedback.</p>
        @elseif($order->status === 'confirmed')
        <p>Thank you — your order has been confirmed and our team is preparing it for fulfillment. We will update you on the next steps shortly.</p>
        @elseif($order->status === 'cancelled')
        <p>Your order has been cancelled. If you have any questions or did not request this cancellation, please contact us immediately.</p>
        @else
        <p>The status of your order has been updated to <strong>{{ ucfirst($order->status) }}</strong>.</p>
        @endif

        <div class="order-box">
            <div class="order-num">Order #{{ $order->order_number }}</div>
            @foreach($order->items as $item)
            <div class="item-row">
                <span>{{ $item->product_name }}</span>
                <span>× {{ $item->quantity }}</span>
            </div>
            @endforeach
        </div>

        <p style="text-align:center">
            <a href="{{ url('/account/orders/'.$order->order_number) }}" class="btn">View Order</a>
        </p>
        <p>If you have any questions, reply to this email or reach us at <a href="mailto:info@ceylonaroma.com" style="color:#2d6a4f">info@ceylonaroma.com</a>.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Ceylon Aroma Commodities Exports (Pvt) Ltd &middot; Kegalle, Sri Lanka
    </div>
</div>
</body>
</html>
