@extends('layouts.admin')
@section('title', $user ? 'Edit Admin User' : 'New Admin User')
@section('breadcrumb')
<a href="{{ route('admin.users.index') }}">Admin Users</a>
<span>/</span>
<span>{{ $user ? 'Edit' : 'New' }}</span>
@endsection

@section('content')
<div class="page-title">{{ $user ? 'Edit Admin User' : 'New Admin User' }}</div>

@if($errors->any())
<div class="a-alert a-alert-error" style="margin-bottom:1rem">
    <ul style="margin:0;padding-left:1.1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="form-card" style="max-width:520px">
    <form method="POST" action="{{ $user ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($user) @method('PUT') @endif

        <div class="f-group">
            <label class="f-label">Full Name *</label>
            <input type="text" name="name" value="{{ old('name', $user?->name) }}" required
                   class="f-control" placeholder="Admin name">
        </div>
        <div class="f-group">
            <label class="f-label">Email Address *</label>
            <input type="email" name="email" value="{{ old('email', $user?->email) }}" required
                   class="f-control" placeholder="admin@ceylonaroma.com">
        </div>
        <div class="f-group">
            <label class="f-label">{{ $user ? 'New Password (leave blank to keep current)' : 'Password *' }}</label>
            <input type="password" name="password" {{ $user ? '' : 'required' }} minlength="8"
                   class="f-control" placeholder="Min 8 characters" autocomplete="new-password">
        </div>
        <div class="f-group">
            <label class="f-label">{{ $user ? 'Confirm New Password' : 'Confirm Password *' }}</label>
            <input type="password" name="password_confirmation" {{ $user ? '' : 'required' }}
                   class="f-control" placeholder="Repeat password" autocomplete="new-password">
        </div>
        <div style="display:flex;gap:.6rem;margin-top:1.25rem">
            <button type="submit" class="a-btn a-btn-primary">{{ $user ? 'Save Changes' : 'Create Admin' }}</button>
            <a href="{{ route('admin.users.index') }}" class="a-btn a-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
