@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('breadcrumb') <span>Blog Posts</span> @endsection

@section('content')
<div class="page-title">
    Blog Posts
    <a href="{{ route('admin.blog.create') }}" class="a-btn a-btn-primary">+ New Post</a>
</div>

<div class="filter-bar">
    <form method="GET" style="display:flex;gap:.6rem">
        <div class="f-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts…">
        </div>
        <button type="submit" class="a-btn a-btn-ghost">Search</button>
        <a href="{{ route('admin.blog.index') }}" class="a-btn a-btn-ghost">Clear</a>
    </form>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Published</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($posts as $p)
                <tr>
                    <td>
                        @if($p->image)<img src="{{ asset('storage/'.$p->image) }}" class="td-img" alt="">
                        @else<div class="td-img-placeholder">📖</div>@endif
                    </td>
                    <td><div class="td-name">{{ $p->title }}</div><div class="td-sub">{{ Str::limit($p->excerpt, 60) }}</div></td>
                    <td style="font-size:.75rem;color:var(--a-muted)">{{ $p->category }}</td>
                    <td style="font-size:.75rem;color:var(--a-muted)">{{ $p->published_at?->format('d M Y') }}</td>
                    <td><span class="badge {{ $p->status ? 'badge-active' : 'badge-inactive' }}"><span class="dot"></span>{{ $p->status ? 'Published' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.blog.edit', $p) }}" class="a-btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.blog.destroy', $p) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete '{{ $p->title }}'?">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--a-muted)">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if($posts->hasPages())
<div class="a-pagination">{{ $posts->links('partials.admin-pagination') }}</div>
@endif
@endsection
