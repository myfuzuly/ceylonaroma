@extends('layouts.admin')
@section('title', 'Products')
@section('breadcrumb')<span>Products</span>@endsection

@section('content')

@php
$lowStock = \App\Models\Product::whereNotNull('stock_qty')
    ->whereColumn('stock_qty','<=','low_stock_threshold')
    ->where('status',true)->count();
@endphp

@if($lowStock > 0)
<div class="admin-alert admin-alert-warning">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    <strong>{{ $lowStock }} product{{ $lowStock > 1 ? 's' : '' }}</strong> {{ $lowStock > 1 ? 'are' : 'is' }} low on stock.
</div>
@endif

<div class="page-title">
    Products
    <a href="{{ route('admin.products.create') }}" class="a-btn a-btn-primary">+ Add Product</a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('admin.products.index') }}" style="display:flex;gap:.6rem;flex-wrap:wrap">
        <div class="f-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products…">
        </div>
        <select name="category_id" class="f-select">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="stock" class="f-select">
            <option value="">All Stock</option>
            <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
            <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
        </select>
        <select name="status" class="f-select">
            <option value="">All Status</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="a-btn a-btn-ghost">Filter</button>
        <a href="{{ route('admin.products.index') }}" class="a-btn a-btn-ghost">Clear</a>
    </form>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width:60px">Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>MOQ</th>
                    <th>Stock</th>
                    <th>Flags</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td>
                        @if($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}" alt="" class="td-img">
                        @else
                            <div class="td-img-placeholder">🌿</div>
                        @endif
                    </td>
                    <td>
                        <div class="td-name">{{ $p->name }}</div>
                        @if($p->sku)<div class="td-sub">SKU: {{ $p->sku }}</div>@endif
                    </td>
                    <td style="font-size:.8rem;color:var(--a-muted)">{{ $p->category?->name ?? '—' }}</td>
                    <td style="font-size:.82rem;white-space:nowrap">
                        @if($p->price)
                            <span style="font-weight:600;color:var(--a-accent)">{{ $p->currency }} {{ number_format($p->price,2) }}</span>
                            <span style="color:var(--a-muted)">/{{ $p->price_unit }}</span>
                        @else
                            <span style="color:var(--a-muted);font-style:italic">On Request</span>
                        @endif
                    </td>
                    <td style="font-size:.82rem;color:var(--a-muted)">
                        @if($p->min_order_qty)
                            {{ number_format($p->min_order_qty,0) }} {{ $p->min_order_unit }}
                        @else —@endif
                    </td>
                    <td>
                        @if($p->stock_qty !== null)
                            @if(!$p->in_stock || $p->stock_qty == 0)
                                <span class="badge badge-inactive">Out</span>
                            @elseif($p->isLowStock())
                                <span class="badge" style="background:rgba(245,158,11,.12);color:#b45309">
                                    ⚠ {{ $p->stock_qty }}
                                </span>
                            @else
                                <span class="badge badge-active">{{ $p->stock_qty }}</span>
                            @endif
                        @else
                            <span style="font-size:.8rem;color:var(--a-muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.25rem;flex-wrap:wrap">
                            @if($p->is_featured)<span class="badge badge-active">Featured</span>@endif
                            @if($p->is_bestseller)<span class="badge" style="background:rgba(198,134,42,.12);color:var(--a-accent)">Best</span>@endif
                            @if($p->is_new_arrival)<span class="badge badge-new">New</span>@endif
                            @if($p->is_export_ready)<span class="badge badge-replied">Export</span>@endif
                        </div>
                    </td>
                    <td><span class="badge {{ $p->status ? 'badge-active' : 'badge-inactive' }}"><span class="dot"></span>{{ $p->status ? 'Active' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('products.show', $p->slug) }}" class="a-btn-icon" title="View on site" target="_blank">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                            <a href="{{ route('admin.products.edit', $p) }}" class="a-btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="a-btn-icon" style="background:rgba(248,113,113,.1);border-color:rgba(248,113,113,.2);color:var(--a-red)"
                                    data-confirm="Delete '{{ $p->name }}'?" title="Delete">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center;padding:3rem;color:var(--a-muted)">
                    No products found. <a href="{{ route('admin.products.create') }}" style="color:var(--a-accent)">Add one</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
<div class="a-pagination">{{ $products->links('partials.admin-pagination') }}</div>
@endif

@endsection
