@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="admin-page-head">
    <h1>Orders</h1>
</div>

{{-- Status tabs --}}
<div class="order-tabs">
    @php $statuses = ['all'=>'All','pending'=>'Pending','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled']; @endphp
    @foreach($statuses as $key => $label)
    <a href="{{ request()->fullUrlWithQuery(['status' => $key == 'all' ? null : $key, 'page' => null]) }}"
       class="order-tab {{ (request('status') == $key || ($key == 'all' && !request('status'))) ? 'active' : '' }}">
        {{ $label }} <span class="order-tab-count">{{ $counts[$key] }}</span>
    </a>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" class="admin-search-form mb-3">
    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, name, email, company…" class="form-control">
    <button type="submit" class="btn btn-outline">Search</button>
    @if(request('search'))<a href="{{ request()->url() }}{{ request('status') ? '?status='.request('status') : '' }}" class="btn btn-ghost">Clear</a>@endif
</form>

@if($orders->isEmpty())
    <div class="admin-empty">No orders found.</div>
@else
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Company</th>
                <th>Country</th>
                <th>Items</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td><span class="order-num">{{ $order->order_number }}</span></td>
            <td>
                <div>{{ $order->name }}</div>
                <small class="text-muted">{{ $order->email }}</small>
            </td>
            <td>{{ $order->company ?? '—' }}</td>
            <td>{{ $order->country }}</td>
            <td>{{ $order->items_count }}</td>
            <td>
                @if($order->payment_method === 'payhere')
                    <span class="status-pill status-{{ $order->payment_status === 'paid' ? 'delivered' : ($order->payment_status === 'cancelled' ? 'cancelled' : 'pending') }}">
                        PayHere {{ ucfirst($order->payment_status ?? 'pending') }}
                    </span>
                @else
                    <span class="text-muted">Inquiry</span>
                @endif
            </td>
            <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-xs btn-outline">View</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endif
@endsection
