@extends('layouts.app')

@section('title', 'Inquiry Submitted')

@section('content')
<section class="confirm-section">
    <div class="container">
        <div class="confirm-card">
            <div class="confirm-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <h1 class="confirm-title">Inquiry Submitted!</h1>
            <p class="confirm-subtitle">Thank you — our export team will respond with a personalised quote within 24 hours.</p>

            <div class="confirm-order-num">
                <span class="confirm-label">Order Reference</span>
                <span class="confirm-num">{{ $order->order_number }}</span>
            </div>

            @if($order->payment_status === 'paid')
                <div class="confirm-payment-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Payment received via PayHere
                </div>
            @endif

            <div class="confirm-details">
                <div class="confirm-detail-row">
                    <span>Ship To</span>
                    <span>{{ $order->name }}, {{ $order->country }}</span>
                </div>
                <div class="confirm-detail-row">
                    <span>Email</span>
                    <span>{{ $order->email }}</span>
                </div>
                <div class="confirm-detail-row">
                    <span>Items</span>
                    <span>{{ $order->items_count }}</span>
                </div>
                <div class="confirm-detail-row">
                    <span>Status</span>
                    <span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
            </div>

            <div class="confirm-items">
                <h4>Items in Order</h4>
                @foreach($order->items as $item)
                <div class="confirm-item-row">
                    <span>{{ $item->product_name }}</span>
                    <span>× {{ $item->quantity }}</span>
                </div>
                @endforeach
            </div>

            <div class="confirm-actions">
                @if(session('customer_id'))
                    <a href="{{ route('customer.orders') }}" class="btn btn-gold">My Orders</a>
                @endif
                <button type="button" onclick="window.print()" class="btn btn-outline">Print Confirmation</button>
                <a href="{{ route('home') }}" class="btn btn-outline">Back to Home</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline">Browse More</a>
            </div>
        </div>
    </div>
</section>
@endsection
