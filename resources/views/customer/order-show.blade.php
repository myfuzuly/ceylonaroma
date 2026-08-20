@extends('layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<section class="cust-section">
    <div class="container">
        <div class="cust-layout">
            @include('customer.partials.sidebar')
            <div class="cust-main">
                <div class="order-detail-head">
                    <div>
                        <a href="{{ route('customer.orders') }}" class="back-link">← Back to Orders</a>
                        <h2 class="cust-page-title">{{ $order->order_number }}</h2>
                    </div>
                    <span class="status-pill status-{{ $order->status }} status-lg">{{ ucfirst($order->status) }}</span>
                </div>

                <div class="order-detail-grid">
                    {{-- Order Info --}}
                    <div class="order-info-card">
                        <h4>Order Details</h4>
                        <dl class="order-dl">
                            <dt>Placed</dt><dd>{{ $order->created_at->format('d M Y, g:i A') }}</dd>
                            <dt>Shipping To</dt><dd>{{ $order->name }}, {{ $order->country }}</dd>
                            @if($order->company)<dt>Company</dt><dd>{{ $order->company }}</dd>@endif
                            @if($order->address)<dt>Address</dt><dd>{{ $order->address }}</dd>@endif
                            @if($order->phone)<dt>Phone</dt><dd>{{ $order->phone }}</dd>@endif
                            <dt>Email</dt><dd>{{ $order->email }}</dd>
                            @if($order->notes)<dt>Notes</dt><dd>{{ $order->notes }}</dd>@endif
                            @if($order->payment_method)
                                <dt>Payment</dt><dd>{{ ucfirst($order->payment_method) }}
                                    @if($order->payment_status)
                                        <span class="status-pill status-{{ $order->payment_status == 'paid' ? 'delivered' : 'pending' }}">{{ ucfirst($order->payment_status) }}</span>
                                    @endif
                                </dd>
                            @endif
                        </dl>
                    </div>

                    {{-- Items --}}
                    <div class="order-items-card">
                        <h4>Items Ordered</h4>
                        @foreach($order->items as $item)
                        <div class="order-item-row">
                            @if($item->product_image)
                                <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="order-item-img">
                            @endif
                            <div class="order-item-info">
                                <a href="{{ route('products.show', $item->product_slug) }}" class="order-item-name">{{ $item->product_name }}</a>
                                <span class="order-item-qty">Qty: {{ $item->quantity }}</span>
                                @if($item->notes)<p class="order-item-note">Note: {{ $item->notes }}</p>@endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
