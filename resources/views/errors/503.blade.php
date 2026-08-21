@extends('layouts.app')
@section('title', 'Be Right Back')
@section('content')
<section class="error-page-section">
    <div class="container">
        <div class="error-page-inner">
            <div class="error-code">503</div>
            <h1>Under Maintenance</h1>
            <p>Ceylon Aroma is briefly offline for scheduled maintenance. We'll be back shortly.</p>
            <p class="error-page-sub">Questions? Email <a href="mailto:{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}">{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}</a></p>
        </div>
    </div>
</section>
@endsection
