@extends('layouts.admin')
@section('title', 'Inquiries')
@section('breadcrumb') <span>Inquiries</span> @endsection

@section('content')
<div class="page-title">
    Inquiries
    @if($newCount > 0)
    <span style="font-size:.875rem;background:rgba(248,113,113,.12);color:var(--a-red);padding:.3rem .75rem;border-radius:100px;font-weight:600">{{ $newCount }} new</span>
    @endif
</div>

<div class="filter-bar">
    <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap">
        <div class="f-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, company…">
        </div>
        <select name="status" class="f-select">
            <option value="">All Statuses</option>
            @foreach(['new','read','replied','closed'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="a-btn a-btn-ghost">Filter</button>
        <a href="{{ route('admin.inquiries.index') }}" class="a-btn a-btn-ghost">Clear</a>
    </form>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead><tr><th>Name</th><th>Company</th><th>Country</th><th>Products</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($inquiries as $inq)
                <tr>
                    <td>
                        <div class="td-name" style="{{ $inq->status === 'new' ? 'color:var(--a-accent)' : '' }}">{{ $inq->name }}</div>
                        <div class="td-sub">{{ $inq->email }}</div>
                    </td>
                    <td>{{ $inq->company }}</td>
                    <td>{{ $inq->country }}</td>
                    <td style="font-size:.75rem;color:var(--a-muted)">{{ collect($inq->products)->implode(', ') ?: '—' }}</td>
                    <td style="font-size:.75rem;color:var(--a-muted)">{{ $inq->created_at->format('d M Y') }}</td>
                    <td><span class="badge badge-{{ $inq->status }}"><span class="dot"></span>{{ ucfirst($inq->status) }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.inquiries.show', $inq) }}" class="a-btn-icon" title="View">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <form action="{{ route('admin.inquiries.destroy', $inq) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete inquiry from {{ $inq->name }}?">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--a-muted)">No inquiries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if($inquiries->hasPages())
<div class="a-pagination">{{ $inquiries->links('partials.admin-pagination') }}</div>
@endif
@endsection
