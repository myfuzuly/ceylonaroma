@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-icon-wrap">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5">
                    <rect x="5" y="11" width="14" height="10" rx="2" ry="2"/>
                    <path d="M11 16a1 1 0 102 0 1 1 0 00-2 0zM8 11V7a4 4 0 118 0v4"/>
                </svg>
            </div>
            <h1 class="auth-title">Enter OTP</h1>
            <p class="auth-subtitle">We sent a 6-digit code to your phone number</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="auth-alert auth-alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.otp.verify.post') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="otp">6-Digit OTP Code</label>
                    <input type="text" id="otp" name="otp" required maxlength="6" minlength="6"
                           placeholder="000000" autocomplete="one-time-code"
                           class="form-control otp-input @error('otp') is-invalid @enderror"
                           inputmode="numeric" pattern="[0-9]{6}">
                    @error('otp')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small class="form-hint">Valid for 10 minutes</small>
                </div>
                <button type="submit" class="btn btn-gold btn-block">Verify & Login</button>
            </form>

            <p class="auth-footer-text">
                Didn't get the code?
                <a href="{{ route('customer.otp.phone') }}">Resend OTP</a>
            </p>
        </div>
    </div>
</section>
@endsection
