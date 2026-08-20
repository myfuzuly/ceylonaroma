@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="admin-page-head">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="back-link">← Orders</a>
        <h1>{{ $order->order_number }}</h1>
    </div>
    <span class="status-pill status-{{ $order->status }} status-lg">{{ ucfirst($order->status) }}</span>
</div>

<div class="order-detail-grid">
    {{-- Customer & Shipping Info --}}
    <div class="order-info-card">
        <h4>Customer Details</h4>
        <dl class="order-dl">
            <dt>Name</dt><dd>{{ $order->name }}</dd>
            <dt>Email</dt><dd><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></dd>
            @if($order->phone)<dt>Phone</dt><dd>{{ $order->phone }}</dd>@endif
            @if($order->company)<dt>Company</dt><dd>{{ $order->company }}</dd>@endif
            <dt>Country</dt><dd>{{ $order->country }}</dd>
            @if($order->address)<dt>Address</dt><dd>{{ nl2br(e($order->address)) }}</dd>@endif
            @if($order->notes)<dt>Notes</dt><dd>{{ $order->notes }}</dd>@endif
        </dl>

        <h4 class="mt-3">Payment</h4>
        <dl class="order-dl">
            <dt>Method</dt><dd>{{ $order->payment_method === 'payhere' ? 'PayHere Online' : 'Inquiry / Quote' }}</dd>
            @if($order->payment_method === 'payhere')
                <dt>Payment Status</dt>
                <dd><span class="status-pill status-{{ $order->payment_status === 'paid' ? 'delivered' : 'pending' }}">{{ ucfirst($order->payment_status ?? 'pending') }}</span></dd>
                @if($order->payment_id)<dt>Payment ID</dt><dd><code>{{ $order->payment_id }}</code></dd>@endif
            @endif
            <dt>Placed</dt><dd>{{ $order->created_at->format('d M Y, g:i A') }}</dd>
        </dl>

        {{-- Update Status --}}
        <div class="order-status-form">
            <h4>Update Status</h4>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="d-flex gap-2">
                @csrf @method('PATCH')
                <select name="status" class="form-control">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-gold">Update</button>
            </form>
            @if(session('success'))
                <p class="form-success mt-2">{{ session('success') }}</p>
            @endif
        </div>
    </div>

    {{-- Order Items --}}
    <div class="order-items-card">
        <h4>Items Ordered ({{ $order->items_count }})</h4>
        @foreach($order->items as $item)
        <div class="order-item-row">
            @if($item->product_image)
                <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="order-item-img">
            @endif
            <div class="order-item-info">
                <a href="{{ route('products.show', $item->product_slug) }}" target="_blank" class="order-item-name">{{ $item->product_name }}</a>
                <span class="order-item-qty">Qty: {{ $item->quantity }}</span>
                @if($item->notes)<p class="order-item-note">{{ $item->notes }}</p>@endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
