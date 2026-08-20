@extends('layouts.app')

@section('title', 'Phone Login')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-icon-wrap">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.18 19.79 19.79 0 013 .64 2 2 0 015 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
                </svg>
            </div>
            <h1 class="auth-title">Phone Login</h1>
            <p class="auth-subtitle">Enter your registered phone number to receive an OTP</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.otp.send') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           placeholder="+94 77 123 4567"
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small class="form-hint">Enter your number with country code (e.g. +94771234567)</small>
                </div>
                <button type="submit" class="btn btn-gold btn-block">Send OTP</button>
            </form>

            <p class="auth-footer-text">
                <a href="{{ route('customer.login') }}">← Back to login</a>
            </p>
        </div>
    </div>
</section>
@endsection
