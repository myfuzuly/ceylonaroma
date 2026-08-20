@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="auth-section">
    <div class="auth-container auth-container-wide">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/img/logo.png" alt="Ceylon Aroma" class="auth-logo-img">
            </div>
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join Ceylon Aroma as a trade partner</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif

            <a href="{{ route('customer.google') }}" class="btn btn-social btn-google btn-block mb-3">
                <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Sign up with Google
            </a>

            <div class="auth-divider"><span>or register with email</span></div>

            <form method="POST" action="{{ route('customer.register.post') }}" class="auth-form">
                @csrf
                {{-- Honeypot: must stay empty; bots autofill it --}}
                <input type="text" name="_hp" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;opacity:0">
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="John Smith" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="john@company.com" class="form-control @error('email') is-invalid @enderror">
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="+94 77 123 4567" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company" value="{{ old('company') }}"
                               placeholder="Your Company Ltd" class="form-control @error('company') is-invalid @enderror">
                        @error('company')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Country *</label>
                    <select name="country" required class="form-control @error('country') is-invalid @enderror">
                        <option value="">Select Country</option>
                        @foreach(['United States','United Kingdom','Canada','Australia','Germany','France','Netherlands','Japan','China','India','UAE','Saudi Arabia','Singapore','Sri Lanka','Other'] as $c)
                            <option value="{{ $c }}" {{ old('country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('country')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" required minlength="8"
                               placeholder="Min 8 characters" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password *</label>
                        <input type="password" name="password_confirmation" required
                               placeholder="Repeat password" class="form-control">
                    </div>
                </div>
                {{-- Math CAPTCHA --}}
                @php $q = session('captcha_question', $question ?? ''); @endphp
                <div class="form-group captcha-group">
                    <label class="captcha-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Security Check
                    </label>
                    <div class="captcha-row">
                        <div class="captcha-question">{{ $q ?: $question }}</div>
                        <input type="number" name="captcha" class="form-control captcha-input @if(session('captcha_error')) is-invalid @endif"
                               placeholder="Answer" required autocomplete="off" inputmode="numeric">
                    </div>
                    @if(session('captcha_error'))
                        <span class="invalid-feedback" style="display:block">{{ session('captcha_error') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-gold btn-block">Create Account</button>
            </form>

            <p class="auth-footer-text">
                Already have an account? <a href="{{ route('customer.login') }}">Sign In</a>
            </p>
        </div>
    </div>
</section>
@endsection
