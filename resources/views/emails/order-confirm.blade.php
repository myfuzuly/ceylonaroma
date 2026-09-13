<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Order Received</title>
<style>
body{margin:0;padding:0;font-family:Inter,'Helvetica Neue',Arial,sans-serif;background:#f5edd8;color:#1a2a20}
.wrap{max-width:580px;margin:2rem auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
.header{background:#1b4332;padding:2rem 2.5rem;text-align:center}
.header img{height:44px;display:inline-block}
.check-band{background:#16a34a;padding:.9rem 2.5rem;text-align:center;color:#fff;font-size:.82rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase}
.body{padding:2.5rem 2.5rem 2rem}
h2{font-size:1.35rem;font-weight:700;margin:0 0 .75rem;color:#1b4332}
p{line-height:1.65;color:#3a4a3e;margin:0 0 1rem;font-size:.93rem}
.order-box{background:#f5edd8;border-radius:8px;padding:1.25rem 1.5rem;margin:1.25rem 0}
.order-num{font-size:1.15rem;font-weight:700;color:#1b4332;margin-bottom:.75rem;display:flex;align-items:center;gap:.5rem}
.item-row{display:flex;justify-content:space-between;font-size:.87rem;padding:.3rem 0;border-bottom:1px solid rgba(27,67,50,.08);color:#3a4a3e}
.item-row:last-child{border-bottom:none}
.what-next{background:#eaf7f0;border-radius:8px;padding:1rem 1.25rem;margin:1.25rem 0;border-left:3px solid #16a34a}
.what-next p{font-size:.87rem;margin:.25rem 0;color:#166534}
.what-next strong{color:#14532d}
.footer{background:#f5edd8;padding:1.25rem 2.5rem;text-align:center;font-size:.75rem;color:#6b7a70}
.btn{display:inline-block;background:#c8922a;color:#fff;padding:.7rem 1.5rem;border-radius:8px;font-weight:600;font-size:.88rem;text-decoration:none}
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <img src="https://ceylonaroma.com/images/ceylonaroma4.png" alt="Ceylon Aroma">
    </div>
    <div class="check-band">Order Received</div>
    <div class="body">
        <h2>Thank you, {{ $order->name }}!</h2>
        <p>Your order has been received and our export team will review it shortly. You will hear from us within <strong>24 hours</strong> with pricing and next steps.</p>

        <div class="order-box">
            <div class="order-num">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1b4332" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Order #{{ $order->order_number }}
            </div>
            @foreach($order->items as $item)
            <div class="item-row">
                <span>{{ $item->product_name }}</span>
                <span>× {{ $item->quantity }}</span>
            </div>
            @endforeach
        </div>

        @if($order->notes)
        <p style="font-size:.87rem;color:#5d8a6c"><strong>Your notes:</strong> {{ $order->notes }}</p>
        @endif

        <div class="what-next">
            <p><strong>What happens next?</strong></p>
            <p>1. Our team reviews your order and prepares a quote</p>
            <p>2. We email you within 24 hours with pricing and availability</p>
            <p>3. Upon agreement, we arrange shipping and send export documents</p>
        </div>

        <p style="text-align:center">
            <a href="{{ $trackUrl }}" class="btn">Track Your Order</a>
        </p>

        <p>Questions? Reply to this email or reach us at <a href="mailto:info@ceylonaroma.com" style="color:#2d6a4f">info@ceylonaroma.com</a> or <a href="tel:+94718821234" style="color:#2d6a4f">+94 71 882 1234</a>.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Ceylon Aroma Commodities Exports (Pvt) Ltd &middot; Kegalle, Sri Lanka
    </div>
</div>
</body>
</html>
