@extends('layouts.admin')
@section('title', 'Admin Users')
@section('breadcrumb')<span>Admin Users</span>@endsection

@section('content')
<div class="page-title" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem">
    Admin Users
    <a href="{{ route('admin.users.create') }}" class="a-btn a-btn-primary">+ New Admin</a>
</div>

@if(session('success'))
<div class="a-alert a-alert-success" style="margin-bottom:1rem">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="a-alert a-alert-error" style="margin-bottom:1rem">{{ session('error') }}</div>
@endif

<div class="table-wrap">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.65rem">
                        <div style="width:32px;height:32px;border-radius:50%;background:var(--sidebar-accent,#1b4332);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.82rem;flex-shrink:0">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <span style="font-weight:500">{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td style="text-align:right">
                    <div style="display:flex;gap:.4rem;justify-content:flex-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="a-btn a-btn-ghost a-btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Delete this admin account?')">
                            @csrf @method('DELETE')
                            <button class="a-btn a-btn-danger a-btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:2rem;color:#6b7280">No admin users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
