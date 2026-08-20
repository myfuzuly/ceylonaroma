@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/images/ceylonaroma3.png" alt="Ceylon Aroma" class="auth-logo-img">
            </div>
            <h1 class="auth-title">Forgot Password?</h1>
            <p class="auth-subtitle">Enter your email and we'll send you a reset link.</p>

            @if(session('success'))
                <div class="auth-alert auth-alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif

            @unless(session('success'))
            <form method="POST" action="{{ route('customer.forgot-password.post') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="fp-email">Email Address</label>
                    <input type="email" id="fp-email" name="email" value="{{ old('email') }}" required
                           placeholder="your@email.com" autocomplete="email"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn btn-gold btn-block">Send Reset Link</button>
            </form>
            @endunless

            <p class="auth-footer-text" style="margin-top:1rem">
                <a href="{{ route('customer.login') }}" style="color:var(--muted)">&larr; Back to Sign In</a>
            </p>
        </div>
    </div>
</section>
@endsection
