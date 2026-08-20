@extends('layouts.admin')
@section('title', 'Customers')
@section('breadcrumb')<span>Customers</span>@endsection

@section('content')
<div class="page-title">
    Customers
    <span class="a-badge-count">{{ $total }} total</span>
</div>

<div class="filter-bar">
    <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap">
        <div class="f-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, company, country…">
        </div>
        <button type="submit" class="a-btn a-btn-ghost">Search</button>
        @if(request('search'))<a href="{{ route('admin.customers.index') }}" class="a-btn a-btn-ghost">Clear</a>@endif
    </form>
</div>

@if(session('success'))
<div class="a-alert a-alert-success" style="margin-bottom:1rem">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Company</th>
                    <th>Country</th>
                    <th>Orders</th>
                    <th>Login Via</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($customers as $c)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.75rem">
                        <div class="cust-avatar-sm">
                            @if($c->avatar)
                                <img src="{{ $c->avatar }}" alt="{{ $c->name }}">
                            @else
                                <span>{{ strtoupper(substr($c->name,0,1)) }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="td-name">{{ $c->name }}</div>
                            <div class="td-sub">{{ $c->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:.82rem;color:var(--a-muted)">{{ $c->company ?? '—' }}</td>
                <td style="font-size:.82rem;color:var(--a-muted)">{{ $c->country ?? '—' }}</td>
                <td>
                    <span class="badge {{ $c->orders_count > 0 ? 'badge-active' : '' }}" style="{{ $c->orders_count == 0 ? 'color:var(--a-muted)' : '' }}">
                        {{ $c->orders_count }}
                    </span>
                </td>
                <td>
                    @if($c->google_id)
                        <span class="badge" style="background:rgba(66,133,244,.1);color:#3b69c9">Google</span>
                    @elseif($c->phone)
                        <span class="badge" style="background:rgba(16,185,129,.1);color:#047857">Phone</span>
                    @else
                        <span class="badge" style="background:#f3f4f6;color:#6b7280">Email</span>
                    @endif
                </td>
                <td>
                    @php $active = $c->is_active ?? true; @endphp
                    <span class="badge {{ $active ? 'badge-active' : '' }}" style="{{ !$active ? 'background:rgba(239,68,68,.1);color:#dc2626' : '' }}">
                        {{ $active ? 'Active' : 'Disabled' }}
                    </span>
                </td>
                <td style="font-size:.82rem;color:var(--a-muted)">{{ $c->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:.4rem">
                        <a href="{{ route('admin.customers.show', $c) }}" class="a-btn-icon" title="View">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.customers.toggle', $c) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="a-btn-icon" title="{{ $active ? 'Disable' : 'Enable' }}" style="color:{{ $active ? '#f59e0b' : '#16a34a' }}">
                                @if($active)
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                @else
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 11 12 14 22 4"/></svg>
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" style="display:inline"
                              onsubmit="return confirm('Delete {{ addslashes($c->name) }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="a-btn-icon" title="Delete" style="color:#ef4444">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--a-muted)">No customers yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($customers->hasPages())
<div class="a-pagination">{{ $customers->links('partials.admin-pagination') }}</div>
@endif
@endsection
