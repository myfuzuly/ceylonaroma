@extends('layouts.admin')

@section('title', 'Orders')

@section('breadcrumb')<span>Orders</span>@endsection

@section('content')
<div class="page-title">Orders</div>

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
<div class="filter-bar">
    <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap">
        @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <div class="f-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, name, email, company…">
        </div>
        <button type="submit" class="a-btn a-btn-ghost">Search</button>
        @if(request('search'))<a href="{{ request()->url() }}{{ request('status') ? '?status='.request('status') : '' }}" class="a-btn a-btn-ghost">Clear</a>@endif
    </form>
</div>

<div class="table-wrap">
    <div class="table-scroll">
    <table>
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
        @forelse($orders as $order)
        <tr>
            <td><span class="order-num">{{ $order->order_number }}</span></td>
            <td>
                <div class="td-name">{{ $order->name }}</div>
                <div class="td-sub">{{ $order->email }}</div>
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
                    <span style="color:var(--a-muted)">Inquiry</span>
                @endif
            </td>
            <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="a-btn a-btn-ghost a-btn-sm">View</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:3rem;color:var(--a-muted)">No orders found.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>

@if($orders->hasPages())
<div class="a-pagination">{{ $orders->links('partials.admin-pagination') }}</div>
@endif
@endsection
