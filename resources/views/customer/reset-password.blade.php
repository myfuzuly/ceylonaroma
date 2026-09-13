@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma" class="auth-logo-img">
            </div>
            <h1 class="auth-title">Set New Password</h1>
            <p class="auth-subtitle">Choose a strong password for your account.</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    <ul style="margin:0;padding-left:1.1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.reset-password.post') }}" class="auth-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label for="rp-password">New Password</label>
                    <div class="input-pwd-wrap">
                        <input type="password" id="rp-password" name="password" required minlength="8"
                               autocomplete="new-password" placeholder="Min 8 characters"
                               class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="pwd-toggle" aria-label="Show password" data-target="rp-password">
                            <span class="eye-on"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                            <span class="eye-off"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg></span>
                        </button>
                    </div>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="rp-confirm">Confirm New Password</label>
                    <div class="input-pwd-wrap">
                        <input type="password" id="rp-confirm" name="password_confirmation" required
                               autocomplete="new-password" placeholder="Repeat password"
                               class="form-control">
                        <button type="button" class="pwd-toggle" aria-label="Show password" data-target="rp-confirm">
                            <span class="eye-on"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                            <span class="eye-off"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg></span>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-block">Update Password</button>
            </form>
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
    });
});
</script>
@endpush
@endsection
