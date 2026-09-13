@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma" class="auth-logo-img">
            </div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your Ceylon Aroma account</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="auth-alert auth-alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.login.post') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" required
                           placeholder="your@email.com" autocomplete="email"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <div class="input-pwd-wrap">
                        <input type="password" id="login-password" name="password" required
                               autocomplete="current-password" placeholder="••••••••"
                               class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="pwd-toggle" aria-label="Show password" data-target="login-password">
                            <span class="eye-on"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                            <span class="eye-off"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg></span>
                        </button>
                    </div>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div style="text-align:right;margin-top:-.25rem;margin-bottom:.75rem">
                    <a href="{{ route('customer.forgot-password') }}" class="forgot-link">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-gold btn-block">Sign In</button>
            </form>

            <div class="auth-divider"><span>or continue with</span></div>

            <div class="auth-social">
                <a href="{{ route('customer.google') }}" class="btn-social btn-google">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Sign in with Google
                </a>
                <a href="{{ route('customer.otp.phone') }}" class="btn-social btn-phone">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.09 3h3a2 2 0 012 1.72c.127.96.36 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 11a16 16 0 006.91 6.91l1.27-1.27a2 2 0 012.11-.45c.907.34 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    Sign in with Phone OTP
                </a>
            </div>

            <p class="auth-footer-text">
                Don't have an account? <a href="{{ route('customer.register') }}">Create Account</a>
            </p>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.pwd-toggle').forEach(function(btn){
    btn.addEventListener('click', function(){
        var inp = document.getElementById(btn.dataset.target);
        if(!inp) return;
        var show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        btn.classList.toggle('showing', show);
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
});
</script>
@endpush
@endsection
