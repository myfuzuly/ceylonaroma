@extends('layouts.app')
@section('title', 'Server Error')
@section('content')
<section class="error-page-section">
    <div class="container">
        <div class="error-page-inner">
            <div class="error-code">500</div>
            <h1>Something Went Wrong</h1>
            <p>We've encountered an unexpected error. Please try again or contact us if the problem persists.</p>
            <a href="{{ url('/') }}" class="btn btn-gold">← Back to Home</a>
        </div>
    </div>
</section>
@endsection
