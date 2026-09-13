<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reset Your Password</title>
<style>
body{margin:0;padding:0;font-family:Inter,'Helvetica Neue',Arial,sans-serif;background:#f5edd8;color:#1a2a20}
.wrap{max-width:580px;margin:2rem auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
.header{background:#1b4332;padding:2rem 2.5rem;text-align:center}
.header img{height:44px;display:inline-block}
.body{padding:2.5rem 2.5rem 2rem}
h2{font-size:1.35rem;font-weight:700;margin:0 0 .75rem;color:#1b4332}
p{line-height:1.65;color:#3a4a3e;margin:0 0 1rem;font-size:.93rem}
.btn{display:inline-block;background:#c8922a;color:#fff;padding:.85rem 2rem;border-radius:8px;font-weight:600;font-size:.93rem;text-decoration:none;margin:1.25rem 0}
.note{font-size:.8rem;color:#6b7a70;border-top:1px solid #e8e3d8;padding-top:1rem;margin-top:1.5rem}
.link-wrap{word-break:break-all;font-size:.78rem;color:#5d8a6c;background:#f5edd8;padding:.6rem .75rem;border-radius:6px;margin-top:.4rem}
.footer{background:#f5edd8;padding:1.25rem 2.5rem;text-align:center;font-size:.75rem;color:#6b7a70}
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <img src="https://ceylonaroma.com/images/ceylonaroma4.png" alt="Ceylon Aroma">
    </div>
    <div class="body">
        <h2>Reset Your Password</h2>
        <p>Hi {{ $customerName }},</p>
        <p>We received a request to reset the password for your Ceylon Aroma account. Click the button below to choose a new password. This link expires in <strong>60 minutes</strong>.</p>
        <div style="text-align:center">
            <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
        </div>
        <div class="note">
            <p style="margin:0 0 .5rem">If the button above doesn't work, copy and paste this link into your browser:</p>
            <div class="link-wrap">{{ $resetUrl }}</div>
        </div>
        <div class="note">
            If you did not request a password reset, you can safely ignore this email — your password will not be changed.
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Ceylon Aroma Commodities Exports (Pvt) Ltd &middot; Kegalle, Sri Lanka
    </div>
</div>
</body>
</html>
