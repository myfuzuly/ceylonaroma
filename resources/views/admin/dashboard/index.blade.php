@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb')<span>Dashboard</span>@endsection

@section('content')

<div class="page-title">Dashboard</div>

@if($stats['orders_pending'] > 0 || $stats['low_stock'] > 0 || $stats['new_inquiries'] > 0)
<div style="display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.25rem">
    @if($stats['orders_pending'] > 0)
    <a href="{{ route('admin.orders.index') }}?status=pending" class="admin-alert admin-alert-warning" style="text-decoration:none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
        <strong>{{ $stats['orders_pending'] }} pending order{{ $stats['orders_pending'] > 1 ? 's' : '' }}</strong> awaiting action
    </a>
    @endif
    @if($stats['new_inquiries'] > 0)
    <a href="{{ route('admin.inquiries.index') }}" class="admin-alert admin-alert-info" style="text-decoration:none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <strong>{{ $stats['new_inquiries'] }} new {{ Str::plural('inquiry', $stats['new_inquiries']) }}</strong> unread
    </a>
    @endif
    @if($stats['low_stock'] > 0)
    <a href="{{ route('admin.products.index') }}?stock=low" class="admin-alert admin-alert-warning" style="text-decoration:none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <strong>{{ $stats['low_stock'] }} product{{ $stats['low_stock'] > 1 ? 's' : '' }}</strong> low on stock
    </a>
    @endif
</div>
@endif

{{-- Stats grid --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(52,211,153,.12);color:var(--a-green)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $stats['products'] }}</div>
            <div class="stat-card-label">Products</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(96,165,250,.12);color:var(--a-blue)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $stats['customers'] }}</div>
            <div class="stat-card-label">Customers</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(198,134,42,.12);color:var(--a-accent)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $stats['orders'] }}</div>
            <div class="stat-card-label">Total Orders</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(251,191,36,.12);color:#d97706">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="stat-card-num" style="color:#d97706">{{ $stats['orders_pending'] }}</div>
            <div class="stat-card-label">Pending Orders</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(52,211,153,.12);color:var(--a-green)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $stats['inquiries'] }}</div>
            <div class="stat-card-label">Inquiries</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(248,113,113,.12);color:var(--a-red)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $stats['categories'] }}</div>
            <div class="stat-card-label">Categories</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem">

    {{-- Recent Orders --}}
    <div class="table-wrap">
        <div class="table-toolbar">
            <span class="table-title">Recent Orders</span>
            <a href="{{ route('admin.orders.index') }}" class="a-btn a-btn-ghost a-btn-sm">View All</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr><th>Order #</th><th>Customer</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="order-num" style="color:var(--a-accent)">{{ $order->order_number }}</a></td>
                    <td>
                        <div style="font-size:.82rem">{{ $order->name }}</div>
                        <div style="font-size:.75rem;color:var(--a-muted)">{{ $order->country }}</div>
                    </td>
                    <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td style="font-size:.78rem;color:var(--a-muted)">{{ $order->created_at->format('d M') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--a-muted);padding:2rem">No orders yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Inquiries --}}
    <div class="table-wrap">
        <div class="table-toolbar">
            <span class="table-title">Recent Inquiries</span>
            <a href="{{ route('admin.inquiries.index') }}" class="a-btn a-btn-ghost a-btn-sm">View All</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr><th>Name</th><th>Company</th><th>Status</th></tr>
                </thead>
                <tbody>
                @forelse($recentInquiries as $inq)
                <tr>
                    <td><a href="{{ route('admin.inquiries.show', $inq) }}" style="color:var(--a-accent)">{{ $inq->name }}</a></td>
                    <td style="font-size:.8rem;color:var(--a-muted)">{{ $inq->company ?? '—' }}</td>
                    <td><span class="badge badge-{{ $inq->status }}"><span class="dot"></span>{{ ucfirst($inq->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--a-muted);padding:2rem">No inquiries yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <a href="{{ route('admin.products.create') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(52,211,153,.1);color:var(--a-green)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>
        </div>
        <span class="qa-label">New Product</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(198,134,42,.1);color:var(--a-accent)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
        </div>
        <span class="qa-label">Orders</span>
    </a>
    <a href="{{ route('admin.customers.index') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(96,165,250,.1);color:var(--a-blue)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <span class="qa-label">Customers</span>
    </a>
    <a href="{{ route('admin.inquiries.index') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(251,191,36,.1);color:#d97706">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <span class="qa-label">Inquiries</span>
    </a>
    <a href="{{ route('admin.blog.create') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(255,255,255,.06);color:var(--a-muted)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>
        </div>
        <span class="qa-label">New Post</span>
    </a>
    <a href="{{ route('admin.settings.index') }}" class="qa-card">
        <div class="qa-icon" style="background:rgba(255,255,255,.06);color:var(--a-muted)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41M4.93 4.93l1.41 1.41M21 12h-2M5 12H3M12 21v-2M12 5V3"/></svg>
        </div>
        <span class="qa-label">Settings</span>
    </a>
</div>

@endsection
