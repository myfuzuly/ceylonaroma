<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') — Ceylon Aroma Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/admin.css','resources/js/admin.js'])
</head>
<body>

<div class="admin-layout">
    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:.6rem">
                <svg width="32" height="32" viewBox="0 0 36 36" fill="none"><circle cx="18" cy="18" r="17" fill="rgba(198,134,42,.2)"/><path d="M18 8C13 8 9 12.5 10 18c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-5.5-3-10-8-10z" fill="none" stroke="rgba(198,134,42,.6)" stroke-width="1.5"/><path d="M18 8c0 3-1.5 6-4 8.5C16 18 18 20 18 24c0-4 2-6 4-7.5C19.5 14 18 11 18 8z" fill="#C6862A" opacity=".9"/><circle cx="18" cy="18" r="2" fill="#DFA84C"/></svg>
                <div class="sidebar-logo-text">
                    <span class="sidebar-logo-ceylon">Ceylon</span>
                    <span class="sidebar-logo-aroma">Aroma <span class="sidebar-badge">Admin</span></span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <span class="sidebar-section-label">Overview</span>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <span class="sidebar-section-label" style="margin-top:.5rem">Catalogue</span>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                Categories
            </a>
            <a href="{{ route('admin.collections.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Collections
            </a>

            <span class="sidebar-section-label" style="margin-top:.5rem">Content</span>
            <a href="{{ route('admin.sliders.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><circle cx="8" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Slider
            </a>
            <a href="{{ route('admin.blog.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Blog Posts
            </a>

            <span class="sidebar-section-label" style="margin-top:.5rem">Business</span>
            <a href="{{ route('admin.customers.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Customers
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                Orders
                @php $newOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($newOrders > 0)
                <span class="sidebar-badge-num">{{ $newOrders }}</span>
                @endif
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Inquiries
                @php $newInq = \App\Models\Inquiry::where('status','new')->count(); @endphp
                @if($newInq > 0)
                <span class="sidebar-badge-num">{{ $newInq }}</span>
                @endif
            </a>

            <span class="sidebar-section-label" style="margin-top:.5rem">System</span>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Admin Users
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41M4.93 4.93l1.41 1.41M21 12h-2M5 12H3M12 21v-2M12 5V3"/></svg>
                Settings
            </a>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                View Site
            </a>
        </nav>

        <div class="sidebar-footer">
            Ceylon Aroma &copy; {{ date('Y') }}
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                @yield('breadcrumb', 'Admin Panel')
            </div>
            <div class="topbar-right">
                <div class="admin-user">
                    <div class="admin-avatar">{{ strtoupper(substr(session('admin_name','A'), 0, 1)) }}</div>
                    <span>{{ session('admin_name','Administrator') }}</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="admin-logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="a-alert a-alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="a-alert a-alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="a-alert a-alert-error">
                    <ul style="margin:0;padding-left:1rem">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
