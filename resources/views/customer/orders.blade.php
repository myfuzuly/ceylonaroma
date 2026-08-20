@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="cust-section">
    <div class="container">
        <div class="cust-layout">
            @include('customer.partials.sidebar')
            <div class="cust-main">
                <h2 class="cust-page-title">My Orders</h2>

                @if($orders->isEmpty())
                    <div class="cust-empty">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                        <p>You haven't placed any orders yet.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-gold">Browse Products</a>
                    </div>
                @else
                    <div class="order-table-wrap">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Items</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><span class="order-num">{{ $order->order_number }}</span></td>
                                <td>{{ $order->items_count }} item(s)</td>
                                <td>{{ $order->country }}</td>
                                <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td><a href="{{ route('customer.order.show', $order->order_number) }}" class="btn btn-xs btn-outline">View</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $orders->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
