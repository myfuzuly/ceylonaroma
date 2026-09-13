<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Ceylon Aroma</title>
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/admin.css'])
<style>
body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--a-bg)}
.login-wrap{width:100%;max-width:400px;padding:1rem}
.login-card{background:var(--a-surface);border:1px solid var(--a-border);border-radius:16px;padding:2.5rem}
.login-logo{text-align:center;margin-bottom:2rem}
.login-logo svg{margin:0 auto 1rem}
.login-logo h2{font-size:1.25rem;color:var(--a-text)}
.login-logo p{font-size:.8rem;color:var(--a-muted);margin-top:.25rem}
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <svg width="48" height="48" viewBox="0 0 36 36" fill="none"><circle cx="18" cy="18" r="17" fill="rgba(198,134,42,.2)"/><path d="M18 8C13 8 9 12.5 10 18c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-5.5-3-10-8-10z" fill="none" stroke="rgba(198,134,42,.6)" stroke-width="1.5"/><path d="M18 8c0 3-1.5 6-4 8.5C16 18 18 20 18 24c0-4 2-6 4-7.5C19.5 14 18 11 18 8z" fill="#C6862A" opacity=".9"/><circle cx="18" cy="18" r="2" fill="#DFA84C"/></svg>
            <h2>Ceylon Aroma Admin</h2>
            <p>Sign in to manage your site</p>
        </div>

        @if(session('error'))
        <div class="a-alert a-alert-error" style="margin-bottom:1.25rem">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            <div class="f-group">
                <label class="f-label">Email Address</label>
                <input type="email" name="email" class="f-control" value="{{ old('email') }}" required autofocus placeholder="admin@ceylonaroma.com">
                @error('email')<span class="f-error">{{ $message }}</span>@enderror
            </div>
            <div class="f-group">
                <label class="f-label">Password</label>
                <input type="password" name="password" id="pass" class="f-control" required placeholder="••••••••">
                @error('password')<span class="f-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="a-btn a-btn-primary" style="width:100%;justify-content:center;padding:.75rem;font-size:.9rem;margin-top:.5rem">
                Sign In
            </button>
        </form>

        <p style="text-align:center;font-size:.75rem;color:var(--a-muted);margin-top:1.5rem">
            <a href="{{ route('home') }}" style="color:var(--a-accent)">← Back to Site</a>
        </p>
    </div>
</div>
@vite(['resources/js/admin.js'])
</body>
</html>
