@extends('layouts.admin')
@section('title', 'Categories')
@section('breadcrumb') <span>Categories</span> @endsection

@section('content')
<div class="page-title">
    Categories
    <a href="{{ route('admin.categories.create') }}" class="a-btn a-btn-primary">+ Add Category</a>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                {{-- ── Main / Parent category row ── --}}
                <tr style="background:var(--a-surface,#1e2430)">
                    <td>
                        @if($cat->image)
                            <img src="{{ asset('storage/'.$cat->image) }}" class="td-img" alt="">
                        @else
                            <div class="td-img-placeholder">📁</div>
                        @endif
                    </td>
                    <td>
                        <div class="td-name" style="display:flex;align-items:center;gap:.5rem">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:4px;background:var(--a-primary,#6366f1);color:#fff;font-size:.6rem;font-weight:700;flex-shrink:0">M</span>
                            <strong>{{ $cat->name }}</strong>
                        </div>
                    </td>
                    <td style="font-size:.75rem;color:var(--a-muted)">{{ $cat->slug }}</td>
                    <td>{{ $cat->products_count ?? 0 }}</td>
                    <td>{{ $cat->sort_order }}</td>
                    <td><span class="badge {{ $cat->status ? 'badge-active' : 'badge-inactive' }}"><span class="dot"></span>{{ $cat->status ? 'Active' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="a-btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete '{{ $cat->name }}'?" title="Delete">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- ── Sub-categories ── --}}
                @foreach($cat->children as $sub)
                <tr style="background:rgba(0,0,0,.18)">
                    <td style="padding-left:2rem">
                        @if($sub->image)
                            <img src="{{ asset('storage/'.$sub->image) }}" class="td-img" alt="" style="opacity:.85">
                        @else
                            <div class="td-img-placeholder" style="opacity:.6">📁</div>
                        @endif
                    </td>
                    <td>
                        <div class="td-name" style="display:flex;align-items:center;gap:.5rem;padding-left:1.2rem">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--a-muted)" stroke-width="2" style="flex-shrink:0"><polyline points="9 18 15 12 9 6"/></svg>
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:4px;background:rgba(100,116,139,.25);color:var(--a-muted);font-size:.55rem;font-weight:700;flex-shrink:0">S</span>
                            <span style="color:var(--a-muted)">{{ $sub->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:.75rem;color:var(--a-muted);opacity:.7">{{ $sub->slug }}</td>
                    <td style="color:var(--a-muted)">{{ $sub->products_count ?? 0 }}</td>
                    <td style="color:var(--a-muted)">{{ $sub->sort_order }}</td>
                    <td><span class="badge {{ $sub->status ? 'badge-active' : 'badge-inactive' }}"><span class="dot"></span>{{ $sub->status ? 'Active' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.categories.edit', $sub) }}" class="a-btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $sub) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete '{{ $sub->name }}'?" title="Delete">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--a-muted)">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
