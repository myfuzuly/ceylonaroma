@extends('layouts.app')
@section('title', 'Page Not Found')
@section('content')
<section class="error-page-section">
    <div class="container">
        <div class="error-page-inner">
            <div class="error-code">404</div>
            <h1>Page Not Found</h1>
            <p>The page you're looking for doesn't exist or has been moved.</p>
            <a href="{{ url('/') }}" class="btn btn-gold">← Back to Home</a>
        </div>
    </div>
</section>
@endsection
