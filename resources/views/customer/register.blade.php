@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="auth-section">
    <div class="auth-container auth-container-wide">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/images/ceylonaroma3.png" alt="Ceylon Aroma" class="auth-logo-img">
            </div>
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join Ceylon Aroma as a trade partner</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    <ul style="margin:0;padding-left:1.1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <a href="{{ route('customer.google') }}" class="btn-social btn-google btn-block" style="justify-content:center;margin-bottom:.75rem">
                <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Sign up with Google
            </a>

            <div class="auth-divider"><span>or register with email</span></div>

            <form method="POST" action="{{ route('customer.register.post') }}" class="auth-form" id="reg-form">
                @csrf
                <input type="text" name="_hp" value="" tabindex="-1" autocomplete="off" aria-hidden="true"
                       style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;opacity:0">
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="reg-name">Full Name *</label>
                        <input type="text" id="reg-name" name="name" value="{{ old('name') }}" required
                               autocomplete="name" placeholder="John Smith"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="reg-email">Email Address *</label>
                        <input type="email" id="reg-email" name="email" value="{{ old('email') }}" required
                               autocomplete="email" placeholder="john@company.com"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="reg-phone">Phone</label>
                        <input type="text" id="reg-phone" name="phone" value="{{ old('phone') }}"
                               autocomplete="tel" placeholder="+94 77 123 4567"
                               class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="reg-company">Company</label>
                        <input type="text" id="reg-company" name="company" value="{{ old('company') }}"
                               autocomplete="organization" placeholder="Your Company Ltd"
                               class="form-control @error('company') is-invalid @enderror">
                        @error('company')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="reg-country">Country *</label>
                    <select id="reg-country" name="country" required
                            class="form-control @error('country') is-invalid @enderror">
                        <option value="">Select Country</option>
                        @foreach(['United States','United Kingdom','Canada','Australia','Germany','France','Netherlands','Japan','China','India','UAE','Saudi Arabia','Singapore','Sri Lanka','Other'] as $c)
                            <option value="{{ $c }}" {{ old('country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('country')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="reg-password">Password *</label>
                        <div class="input-pwd-wrap">
                            <input type="password" id="reg-password" name="password" required minlength="8"
                                   autocomplete="new-password" placeholder="Min 8 characters"
                                   class="form-control @error('password') is-invalid @enderror"
                                   oninput="updatePwdStrength(this)">
                            <button type="button" class="pwd-toggle" aria-label="Show password" data-target="reg-password">
                                <span class="eye-on"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                                <span class="eye-off"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg></span>
                            </button>
                        </div>
                        <div class="pwd-strength-bar"><div class="pwd-strength-fill" id="pwd-bar"></div></div>
                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="reg-password-confirm">Confirm Password *</label>
                        <div class="input-pwd-wrap">
                            <input type="password" id="reg-password-confirm" name="password_confirmation" required
                                   autocomplete="new-password" placeholder="Repeat password"
                                   class="form-control" oninput="checkPwdMatch()">
                            <button type="button" class="pwd-toggle" aria-label="Show password" data-target="reg-password-confirm">
                                <span class="eye-on"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                                <span class="eye-off"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg></span>
                            </button>
                        </div>
                        <p class="pwd-match-hint" id="pwd-match-hint"></p>
                    </div>
                </div>
                {{-- Math CAPTCHA --}}
                @php $q = session('captcha_question', $question ?? ''); @endphp
                <div class="form-group captcha-group">
                    <label class="captcha-label" for="reg-captcha">Security Check</label>
                    <div class="captcha-row">
                        <div class="captcha-question">{{ $q ?: ($question ?? '? + ? = ?') }}</div>
                        <input type="number" id="reg-captcha" name="captcha"
                               class="form-control captcha-input @if(session('captcha_error')) is-invalid @endif"
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

@push('scripts')
<script>
/* Password toggles */
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

/* Password strength meter */
function updatePwdStrength(inp) {
    var v = inp.value, score = 0;
    if (v.length >= 8)  score++;
    if (v.length >= 12) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    var colors = ['','#dc2626','#d97706','#ca8a04','#16a34a','#15803d'];
    var bar = document.getElementById('pwd-bar');
    if (bar) { bar.style.width = (score*20)+'%'; bar.style.background = colors[score] || '#dc2626'; }
    checkPwdMatch();
}

/* Password match indicator */
function checkPwdMatch() {
    var p1 = document.getElementById('reg-password');
    var p2 = document.getElementById('reg-password-confirm');
    var hint = document.getElementById('pwd-match-hint');
    if (!p1 || !p2 || !hint || !p2.value) return;
    if (p1.value === p2.value) {
        hint.textContent = 'Passwords match';
        hint.className = 'pwd-match-hint show-ok';
    } else {
        hint.textContent = 'Passwords do not match';
        hint.className = 'pwd-match-hint show-err';
    }
}
</script>
@endpush
@endsection
