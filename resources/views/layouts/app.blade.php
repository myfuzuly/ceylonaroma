@include('layouts.app-top')
@if(session('success'))
    <div class="alert alert-success" style="margin:1rem 1.5rem;border-radius:8px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-error" style="margin:1rem 1.5rem;border-radius:8px">{{ session('error') }}</div>
@endif
@yield('content')
@include('layouts.app-foot')
