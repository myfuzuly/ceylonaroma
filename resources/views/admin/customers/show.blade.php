@extends('layouts.admin')
@section('title', $customer->name)
@section('breadcrumb')
    <a href="{{ route('admin.customers.index') }}" style="color:var(--a-muted)">Customers</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ $customer->name }}</span>
@endsection

@section('content')
<div class="admin-page-head" style="margin-bottom:1.5rem">
    <div style="display:flex;align-items:center;gap:1rem">
        <div class="cust-avatar-md">
            @if($customer->avatar)
                <img src="{{ $customer->avatar }}" alt="{{ $customer->name }}">
            @else
                <span>{{ strtoupper(substr($customer->name,0,1)) }}</span>
            @endif
        </div>
        <div>
            <h2 style="margin:0;font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--a-text)">{{ $customer->name }}</h2>
            <p style="margin:0;font-size:.85rem;color:var(--a-muted)">{{ $customer->email }}@if($customer->company) · {{ $customer->company }}@endif</p>
        </div>
    </div>
    <div style="display:flex;gap:.5rem">
        @if($customer->google_id)
            <span class="badge" style="background:rgba(66,133,244,.1);color:#3b69c9">Google OAuth</span>
        @elseif($customer->phone)
            <span class="badge" style="background:rgba(16,185,129,.1);color:#047857">Phone OTP</span>
        @else
            <span class="badge" style="background:#f3f4f6;color:#6b7280">Email Login</span>
        @endif
    </div>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:1.25rem;align-items:start">

    {{-- Profile card --}}
    <div class="form-card">
        <div class="form-section-title">Profile</div>
        <dl style="display:grid;grid-template-columns:auto 1fr;gap:.4rem .75rem;font-size:.85rem">
            <dt style="color:var(--a-muted)">Email</dt>     <dd>{{ $customer->email }}</dd>
            <dt style="color:var(--a-muted)">Phone</dt>     <dd>{{ $customer->phone ?? '—' }}</dd>
            <dt style="color:var(--a-muted)">Company</dt>   <dd>{{ $customer->company ?? '—' }}</dd>
            <dt style="color:var(--a-muted)">Country</dt>   <dd>{{ $customer->country ?? '—' }}</dd>
            @if($customer->address)
            <dt style="color:var(--a-muted)">Address</dt>   <dd>{{ $customer->address }}</dd>
            @endif
            <dt style="color:var(--a-muted)">Joined</dt>    <dd>{{ $customer->created_at->format('d M Y') }}</dd>
            <dt style="color:var(--a-muted)">Orders</dt>    <dd><strong>{{ $orders->count() }}</strong></dd>
        </dl>
    </div>

    {{-- Orders --}}
    <div>
        <div class="form-section-title" style="margin-bottom:.75rem">Order History</div>
        @if($orders->isEmpty())
            <div style="padding:2rem;text-align:center;color:var(--a-muted);background:var(--a-card);border-radius:10px;border:1px solid var(--a-border)">
                No orders placed yet.
            </div>
        @else
        <div class="table-wrap">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
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
                        <td>{{ $order->items_count }}</td>
                        <td style="font-size:.82rem">
                            @if($order->payment_method === 'payhere')
                                <span class="badge {{ $order->payment_status === 'paid' ? 'badge-active' : 'badge-inactive' }}">
                                    PayHere · {{ ucfirst($order->payment_status ?? 'pending') }}
                                </span>
                            @else
                                <span style="color:var(--a-muted)">Inquiry</span>
                            @endif
                        </td>
                        <td><span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td style="font-size:.82rem;color:var(--a-muted)">{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="a-btn-icon" title="View">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
