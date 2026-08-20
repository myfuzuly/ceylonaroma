@extends('layouts.admin')
@section('title', 'Inquiry — ' . $inquiry->name)
@section('breadcrumb')
    <a href="{{ route('admin.inquiries.index') }}" style="color:var(--a-muted)">Inquiries</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ $inquiry->name }}</span>
@endsection

@section('content')
<div class="page-title" style="margin-bottom:1rem">
    Inquiry from {{ $inquiry->name }}
    <div style="display:flex;gap:.5rem">
        <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST" style="display:flex;gap:.5rem">
            @csrf @method('PATCH')
            <select name="status" class="f-select" onchange="this.form.submit()">
                @foreach(['new','read','replied','closed'] as $s)
                <option value="{{ $s }}" {{ $inquiry->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.inquiries.index') }}" class="a-btn a-btn-ghost">← Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem">
    <div>
        <div class="detail-card">
            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-val"><span class="badge badge-{{ $inquiry->status }}"><span class="dot"></span>{{ ucfirst($inquiry->status) }}</span></span></div>
            <div class="detail-row"><span class="detail-label">Name</span><span class="detail-val">{{ $inquiry->name }}</span></div>
            <div class="detail-row"><span class="detail-label">Email</span><span class="detail-val"><a href="mailto:{{ $inquiry->email }}" style="color:var(--a-accent)">{{ $inquiry->email }}</a></span></div>
            <div class="detail-row"><span class="detail-label">Phone</span><span class="detail-val">{{ $inquiry->phone ?: '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Company</span><span class="detail-val">{{ $inquiry->company }}</span></div>
            <div class="detail-row"><span class="detail-label">Country</span><span class="detail-val">{{ $inquiry->country }}</span></div>
            <div class="detail-row"><span class="detail-label">Products</span><span class="detail-val">{{ collect($inquiry->products)->implode(', ') ?: '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Date</span><span class="detail-val">{{ $inquiry->created_at->format('d M Y, H:i') }}</span></div>
        </div>
        <div style="margin-top:1rem">
            <div class="f-label" style="margin-bottom:.5rem">Message</div>
            <div class="inquiry-message">{{ $inquiry->message }}</div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem">
        <div class="detail-card">
            <div class="form-section-title">Quick Actions</div>
            <div style="display:flex;flex-direction:column;gap:.6rem">
                <a href="mailto:{{ $inquiry->email }}?subject=Re: Your inquiry — Ceylon Aroma" class="a-btn a-btn-primary" style="justify-content:center">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Reply via Email
                </a>
                <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="replied">
                    <button type="submit" class="a-btn a-btn-ghost" style="width:100%;justify-content:center">Mark as Replied</button>
                </form>
                <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="closed">
                    <button type="submit" class="a-btn a-btn-ghost" style="width:100%;justify-content:center">Mark as Closed</button>
                </form>
                <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="a-btn a-btn-danger" style="width:100%;justify-content:center" data-confirm="Delete this inquiry permanently?">Delete Inquiry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
