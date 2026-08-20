<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>New Export Inquiry — Ceylon Aroma</title>
</head>
<body style="margin:0;padding:0;background:#f0ece4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f0ece4;">
<tr><td align="center" style="padding:32px 16px;">

  <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

    {{-- ── Header ── --}}
    <tr>
      <td style="background:#173C2C;border-radius:10px 10px 0 0;padding:28px 40px;text-align:center;">
        <p style="margin:0;font-size:11px;letter-spacing:4px;color:#C6862A;font-weight:700;text-transform:uppercase;">Ceylon Aroma</p>
        <p style="margin:6px 0 0;font-size:11px;letter-spacing:2px;color:rgba(255,255,255,0.55);text-transform:uppercase;">Export Notification</p>
      </td>
    </tr>

    {{-- ── Alert bar ── --}}
    <tr>
      <td style="background:#C6862A;padding:12px 40px;">
        <p style="margin:0;color:#fff;font-size:13px;font-weight:600;letter-spacing:0.5px;">
          &#128181; New Export Inquiry Received
        </p>
      </td>
    </tr>

    {{-- ── Body ── --}}
    <tr>
      <td style="background:#ffffff;padding:36px 40px;">

        {{-- Buyer name + meta --}}
        <h1 style="margin:0 0 4px;font-size:24px;font-weight:700;color:#173C2C;">{{ $inquiry->name }}</h1>
        <p style="margin:0 0 28px;font-size:14px;color:#888;">
          {{ implode(' &nbsp;·&nbsp; ', array_filter([
              $inquiry->company,
              $inquiry->country,
          ])) ?: '—' }}
        </p>

        {{-- Detail table --}}
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e8e2d8;border-radius:8px;overflow:hidden;margin-bottom:28px;">
          @php $rows = array_filter([
            'Email'    => $inquiry->email,
            'Phone'    => $inquiry->phone,
            'Company'  => $inquiry->company,
            'Country'  => $inquiry->country,
            'Products' => is_array($inquiry->products) ? implode(', ', $inquiry->products) : $inquiry->products,
          ]); @endphp
          @foreach($rows as $label => $value)
          <tr style="{{ $loop->even ? 'background:#faf8f4;' : 'background:#fff;' }}">
            <td style="padding:11px 16px;font-size:12px;font-weight:700;color:#888;letter-spacing:0.5px;text-transform:uppercase;width:90px;border-bottom:{{ $loop->last ? 'none' : '1px solid #e8e2d8' }};">{{ $label }}</td>
            <td style="padding:11px 16px;font-size:14px;color:#222;border-bottom:{{ $loop->last ? 'none' : '1px solid #e8e2d8' }};">
              @if($label === 'Email')
                <a href="mailto:{{ $value }}" style="color:#173C2C;text-decoration:none;font-weight:600;">{{ $value }}</a>
              @else
                {{ $value }}
              @endif
            </td>
          </tr>
          @endforeach
        </table>

        @if($inquiry->message)
        {{-- Message block --}}
        <div style="background:#f9f6f0;border-left:3px solid #C6862A;border-radius:0 6px 6px 0;padding:16px 20px;margin-bottom:28px;">
          <p style="margin:0 0 6px;font-size:11px;font-weight:700;color:#C6862A;letter-spacing:1px;text-transform:uppercase;">Message</p>
          <p style="margin:0;font-size:14px;color:#444;line-height:1.65;white-space:pre-line;">{{ $inquiry->message }}</p>
        </div>
        @endif

        {{-- CTA --}}
        <table cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td style="background:#173C2C;border-radius:6px;">
              <a href="{{ url('/admin/inquiries/' . $inquiry->id) }}"
                 style="display:inline-block;padding:13px 28px;font-size:14px;font-weight:600;color:#fff;text-decoration:none;letter-spacing:0.3px;">
                View in Admin Panel &rarr;
              </a>
            </td>
            <td width="12"></td>
            <td>
              <a href="mailto:{{ $inquiry->email }}"
                 style="display:inline-block;padding:12px 24px;font-size:14px;font-weight:600;color:#173C2C;text-decoration:none;border:1.5px solid #173C2C;border-radius:6px;letter-spacing:0.3px;">
                Reply to Buyer
              </a>
            </td>
          </tr>
        </table>

      </td>
    </tr>

    {{-- ── Footer ── --}}
    <tr>
      <td style="background:#f9f6f0;border-top:1px solid #e8e2d8;border-radius:0 0 10px 10px;padding:20px 40px;text-align:center;">
        <p style="margin:0;font-size:11px;color:#aaa;line-height:1.6;">
          This notification was sent by the Ceylon Aroma contact system.<br>
          Received {{ now()->format('D, d M Y \a\t H:i') }} UTC &nbsp;·&nbsp;
          Ref #{{ str_pad($inquiry->id, 6, '0', STR_PAD_LEFT) }}<br>
          <a href="https://ceylonaroma.com" style="color:#888;text-decoration:none;">ceylonaroma.com</a>
        </p>
      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>
