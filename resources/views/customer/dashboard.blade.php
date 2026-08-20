@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<section class="cust-section">
    <div class="container">
        <div class="cust-layout">

            {{-- Sidebar --}}
            @include('customer.partials.sidebar')

            {{-- Main --}}
            <div class="cust-main">
                <div class="cust-welcome">
                    <div class="cust-avatar">
                        @if($customer->avatar)
                            <img src="{{ $customer->avatar }}" alt="{{ $customer->name }}">
                        @else
                            <span>{{ strtoupper(substr($customer->name,0,1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="cust-name">Welcome, {{ $customer->name }}</h2>
                        <p class="cust-meta">{{ $customer->company ?? 'Ceylon Aroma Customer' }} &bull; {{ $customer->country }}</p>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="cust-stats-row">
                    <div class="cust-stat">
                        <span class="cust-stat-num">{{ $customer->orders()->count() }}</span>
                        <span class="cust-stat-label">Total Orders</span>
                    </div>
                    <div class="cust-stat">
                        <span class="cust-stat-num">{{ $customer->orders()->where('status','delivered')->count() }}</span>
                        <span class="cust-stat-label">Delivered</span>
                    </div>
                    <div class="cust-stat">
                        <span class="cust-stat-num">{{ $customer->orders()->whereIn('status',['pending','processing','shipped'])->count() }}</span>
                        <span class="cust-stat-label">Active Orders</span>
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="cust-section-card">
                    <div class="cust-card-head">
                        <h3>Recent Orders</h3>
                        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline">View All</a>
                    </div>
                    @if($orders->isEmpty())
                        <div class="cust-empty">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                            <p>No orders yet. <a href="{{ route('products.index') }}">Browse products</a></p>
                        </div>
                    @else
                        <div class="order-table-wrap">
                            <table class="order-table">
                                <thead><tr><th>Order #</th><th>Items</th><th>Status</th><th>Date</th><th></th></tr></thead>
                                <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><span class="order-num">{{ $order->order_number }}</span></td>
                                    <td>{{ $order->items_count }} item(s)</td>
                                    <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td><a href="{{ route('customer.order.show', $order->order_number) }}" class="btn btn-xs btn-outline">View</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
