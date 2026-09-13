<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') — Ceylon Aroma Admin</title>
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Inter:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
@vite(['resources/css/admin.css','resources/js/admin.js'])
</head>
<body>

{{-- Mobile overlay --}}
<div class="admin-overlay" id="adminOverlay"></div>

<div class="admin-layout">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-link">
                <svg width="32" height="32" viewBox="0 0 36 36" fill="none"><circle cx="18" cy="18" r="17" fill="rgba(198,134,42,.15)"/><path d="M18 8C13 8 9 12.5 10 18c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-5.5-3-10-8-10z" fill="none" stroke="rgba(198,134,42,.5)" stroke-width="1.5"/><path d="M18 8c0 3-1.5 6-4 8.5C16 18 18 20 18 24c0-4 2-6 4-7.5C19.5 14 18 11 18 8z" fill="#C6862A" opacity=".9"/><circle cx="18" cy="18" r="2" fill="#DFA84C"/></svg>
                <div class="sidebar-logo-text">
                    <span class="sidebar-logo-ceylon">Ceylon</span>
                    <span class="sidebar-logo-aroma">Aroma <span class="sidebar-badge">Admin</span></span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <span class="sidebar-section-label">Overview</span>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <span class="sidebar-section-label">Catalogue</span>
            <a href="{{ route('admin.products.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                Products
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                Categories
            </a>
            <a href="{{ route('admin.collections.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Collections
            </a>

            <span class="sidebar-section-label">Content</span>
            <a href="{{ route('admin.sliders.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><circle cx="8" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Slider
            </a>
            <a href="{{ route('admin.blog.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Blog Posts
            </a>

            <span class="sidebar-section-label">Business</span>
            <a href="{{ route('admin.customers.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Customers
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                Orders
                @php try { $newOrders = \App\Models\Order::where('status','pending')->count(); } catch(\Throwable $e){ $newOrders=0; } @endphp
                @if($newOrders > 0)
                <span class="sidebar-badge-num">{{ $newOrders }}</span>
                @endif
            </a>
            <a href="{{ route('admin.wholesale-prices.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.wholesale-prices.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                Wholesale Prices
            </a>
            <a href="{{ route('admin.inquiries.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Inquiries
                @php try { $newInq = \App\Models\Inquiry::where('status','new')->count(); } catch(\Throwable $e){ $newInq=0; } @endphp
                @if($newInq > 0)
                <span class="sidebar-badge-num">{{ $newInq }}</span>
                @endif
            </a>

            <span class="sidebar-section-label">System</span>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Admin Users
            </a>
            <a href="{{ route('admin.settings.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41M4.93 4.93l1.41 1.41M21 12h-2M5 12H3M12 21v-2M12 5V3"/></svg>
                Settings
            </a>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank" rel="noopener">
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
                <button type="button" class="admin-hamburger" id="adminHamburger" aria-label="Toggle menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
                <div class="topbar-breadcrumb">
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @else
                        <span>Admin Panel</span>
                    @endif
                </div>
            </div>
            <div class="topbar-right">
                <div class="admin-user">
                    <div class="admin-avatar">{{ strtoupper(substr(session('admin_name','A'), 0, 1)) }}</div>
                    <strong>{{ session('admin_name','Administrator') }}</strong>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
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
                <div class="a-alert a-alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="a-alert a-alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul class="a-alert-list">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
(function(){
    var hamburger = document.getElementById('adminHamburger');
    var sidebar   = document.getElementById('adminSidebar');
    var overlay   = document.getElementById('adminOverlay');
    if(!hamburger||!sidebar||!overlay) return;

    function openSidebar(){
        sidebar.classList.add('open');
        overlay.classList.add('open');
        hamburger.classList.add('open');
        hamburger.setAttribute('aria-expanded','true');
        document.body.style.overflow='hidden';
    }
    function closeSidebar(){
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded','false');
        document.body.style.overflow='';
    }

    hamburger.addEventListener('click', function(){
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeSidebar(); });

    /* Close sidebar on nav link click (mobile) */
    sidebar.querySelectorAll('.sidebar-link').forEach(function(a){
        a.addEventListener('click', function(){
            if(window.innerWidth <= 960) closeSidebar();
        });
    });
})();
</script>

@stack('scripts')
</body>
</html>
