<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>We received your inquiry — Ceylon Aroma</title>
</head>
<body style="margin:0;padding:0;background:#f0ece4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f0ece4;">
<tr><td align="center" style="padding:32px 16px;">

  <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

    {{-- ── Header ── --}}
    <tr>
      <td style="background:#173C2C;border-radius:10px 10px 0 0;padding:32px 40px;text-align:center;">
        <p style="margin:0;font-size:13px;letter-spacing:5px;color:#C6862A;font-weight:800;text-transform:uppercase;">Ceylon Aroma</p>
        <p style="margin:5px 0 0;font-size:11px;letter-spacing:2px;color:rgba(255,255,255,0.5);text-transform:uppercase;">Export Spices · Tea · Botanicals</p>
      </td>
    </tr>

    {{-- ── Hero message ── --}}
    <tr>
      <td style="background:#2B6248;padding:28px 40px;text-align:center;">
        <p style="margin:0;font-size:22px;font-weight:700;color:#fff;line-height:1.3;">
          Thank you, {{ $inquiry->name }}.
        </p>
        <p style="margin:8px 0 0;font-size:14px;color:rgba(255,255,255,0.75);line-height:1.5;">
          Your inquiry has been received. Our export team<br>will respond within <strong style="color:#DFA84C;">24 business hours</strong>.
        </p>
      </td>
    </tr>

    {{-- ── Body ── --}}
    <tr>
      <td style="background:#ffffff;padding:36px 40px;">

        <p style="margin:0 0 20px;font-size:15px;color:#333;line-height:1.7;">
          We've noted your interest and will prepare a tailored response including product specifications, pricing, and export documentation.
        </p>

        @if($inquiry->products && count((array)$inquiry->products) > 0)
        {{-- Products you enquired about --}}
        <div style="background:#f9f6f0;border-radius:8px;padding:20px 24px;margin-bottom:24px;">
          <p style="margin:0 0 12px;font-size:11px;font-weight:700;color:#C6862A;letter-spacing:1.5px;text-transform:uppercase;">Products in your inquiry</p>
          @foreach((array)$inquiry->products as $product)
          <p style="margin:0 0 6px;font-size:14px;color:#333;">
            <span style="color:#173C2C;font-weight:700;margin-right:8px;">&#10003;</span>{{ $product }}
          </p>
          @endforeach
        </div>
        @endif

        {{-- What happens next --}}
        <div style="margin-bottom:28px;">
          <p style="margin:0 0 14px;font-size:11px;font-weight:700;color:#888;letter-spacing:1.5px;text-transform:uppercase;">What happens next</p>
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            @php $steps = [
              ['Within 2 hours',      'Your inquiry is assigned to our export team.'],
              ['Within 24 hours',     'You receive a personalised quote with pricing, MOQ, and lead time.'],
              ['Within 48 hours',     'Sample arrangement and documentation can be initiated on request.'],
            ]; @endphp
            @foreach($steps as $i => [$time, $desc])
            <tr>
              <td width="32" valign="top" style="padding-bottom:14px;">
                <div style="width:24px;height:24px;border-radius:50%;background:#173C2C;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#fff;">{{ $i + 1 }}</div>
              </td>
              <td valign="top" style="padding-bottom:14px;padding-left:10px;">
                <p style="margin:0;font-size:12px;font-weight:700;color:#C6862A;">{{ $time }}</p>
                <p style="margin:2px 0 0;font-size:13px;color:#555;line-height:1.5;">{{ $desc }}</p>
              </td>
            </tr>
            @endforeach
          </table>
        </div>

        {{-- Divider --}}
        <hr style="border:none;border-top:1px solid #e8e2d8;margin:0 0 24px;">

        {{-- Reference + contact --}}
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td style="background:#f9f6f0;border-radius:8px;padding:16px 20px;">
              <p style="margin:0;font-size:12px;color:#888;">
                <strong style="color:#173C2C;">Reference:</strong> &nbsp;
                #{{ str_pad($inquiry->id, 6, '0', STR_PAD_LEFT) }} &nbsp;·&nbsp;
                {{ now()->format('d M Y') }}
              </p>
              <p style="margin:8px 0 0;font-size:12px;color:#888;">
                Questions? Email us at &nbsp;
                <a href="mailto:info@ceylonaroma.com" style="color:#173C2C;font-weight:600;text-decoration:none;">info@ceylonaroma.com</a>
              </p>
            </td>
          </tr>
        </table>

      </td>
    </tr>

    {{-- ── CTA ── --}}
    <tr>
      <td style="background:#f9f6f0;border-top:1px solid #e8e2d8;padding:24px 40px;text-align:center;">
        <p style="margin:0 0 16px;font-size:13px;color:#666;">Explore our full range while you wait</p>
        <a href="https://ceylonaroma.com/products"
           style="display:inline-block;background:#173C2C;color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:13px 32px;border-radius:6px;letter-spacing:0.3px;">
          Browse Products &rarr;
        </a>
      </td>
    </tr>

    {{-- ── Footer ── --}}
    <tr>
      <td style="background:#173C2C;border-radius:0 0 10px 10px;padding:20px 40px;text-align:center;">
        <p style="margin:0 0 6px;font-size:12px;color:rgba(255,255,255,0.5);line-height:1.6;">
          Ceylon Aroma &nbsp;·&nbsp; Premium Export Spices, Tea &amp; Botanicals<br>
          <a href="https://ceylonaroma.com" style="color:#C6862A;text-decoration:none;">ceylonaroma.com</a>
          &nbsp;&middot;&nbsp;
          <a href="mailto:info@ceylonaroma.com" style="color:#C6862A;text-decoration:none;">info@ceylonaroma.com</a>
        </p>
        <p style="margin:8px 0 0;font-size:10px;color:rgba(255,255,255,0.3);">
          You received this email because you submitted an inquiry on ceylonaroma.com.
        </p>
      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>
