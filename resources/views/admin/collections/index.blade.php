@extends('layouts.admin')
@section('title', 'Collections')
@section('breadcrumb') <span>Collections</span> @endsection

@section('content')
<div class="page-title">
    Collections
    <a href="{{ route('admin.collections.create') }}" class="a-btn a-btn-primary">+ Add Collection</a>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead><tr><th>Image</th><th>Name</th><th>Tag</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($collections as $c)
                <tr>
                    <td>
                        @if($c->image)<img src="{{ asset('storage/'.$c->image) }}" class="td-img" alt="">
                        @else<div class="td-img-placeholder">🌿</div>@endif
                    </td>
                    <td><div class="td-name">{{ $c->name }}</div><div class="td-sub">{{ Str::limit($c->description, 60) }}</div></td>
                    <td><span class="badge badge-new">{{ $c->tag }}</span></td>
                    <td>{{ $c->sort_order }}</td>
                    <td><span class="badge {{ $c->status ? 'badge-active' : 'badge-inactive' }}"><span class="dot"></span>{{ $c->status ? 'Active' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.collections.edit', $c) }}" class="a-btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.collections.destroy', $c) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete '{{ $c->name }}'?">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--a-muted)">No collections yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
