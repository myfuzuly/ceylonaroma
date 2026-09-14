@extends('layouts.app')

@section('title', 'Wholesale Prices')
@section('meta_description', 'Daily wholesale market prices for Ceylon spices, tea, coffee and natural products. Updated every weekday around 11:00 AM Sri Lanka time.')

@section('content')
<style>
/* ════════════════════════════════════════════════════════
   Wholesale Prices — Premium Design
   ════════════════════════════════════════════════════════ */

/* ── Hero ── */
.wph-hero {
    position: relative;
    background: var(--canopy);
    overflow: hidden;
    padding: 4.5rem 0 3.5rem;
}
.wph-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 90% at 105% -10%, rgba(200,146,42,.14), transparent 60%),
        radial-gradient(ellipse 40% 50% at -5% 110%, rgba(200,146,42,.07), transparent 60%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C8922A' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.wph-hero-inner {
    position: relative;
    z-index: 1;
}
.wph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--gold-2);
    margin-bottom: 1rem;
}
.wph-eyebrow-line {
    width: 22px;
    height: 1.5px;
    background: var(--gold-2);
    opacity: .7;
}
.wph-hero h1 {
    color: #fff;
    font-size: clamp(1.9rem, 3.8vw, 2.9rem);
    margin: 0 0 .85rem;
    line-height: 1.1;
    font-family: var(--font-display, serif);
    letter-spacing: -.01em;
}
.wph-hero-desc {
    color: rgba(255,255,255,.58);
    font-size: .88rem;
    max-width: 50ch;
    line-height: 1.75;
    margin: 0 0 1.75rem;
}
.wph-meta-stack {
    display: flex;
    flex-wrap: wrap;
    gap: .65rem;
    align-items: center;
}
.wph-update-pill {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 100px;
    padding: .45rem 1.1rem;
    font-size: .72rem;
    color: rgba(255,255,255,.75);
    backdrop-filter: blur(4px);
}
.wph-update-pill svg { flex-shrink: 0; color: var(--gold-2); }
.wph-update-pill strong { color: #fff; font-weight: 700; }
.wph-schedule-pill {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .68rem;
    font-weight: 600;
    color: rgba(200,146,42,.85);
    letter-spacing: .03em;
}
.wph-schedule-pill::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #C8922A;
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0%,100%{opacity:1;transform:scale(1)}
    50%{opacity:.5;transform:scale(1.3)}
}
.wph-hero-cta {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .73rem;
    font-weight: 600;
    color: var(--gold-2);
    text-decoration: none;
    border: 1px solid rgba(200,146,42,.3);
    border-radius: 100px;
    padding: .45rem 1.1rem;
    transition: all .18s;
    margin-left: .25rem;
}
.wph-hero-cta:hover {
    background: rgba(200,146,42,.12);
    border-color: rgba(200,146,42,.55);
    color: var(--gold-2);
}

/* ── Filter strip ── */
.wph-filter-strip {
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: .9rem 0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 8px rgba(27,67,50,.06);
}
.wph-filter-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.wph-filter-left {
    display: flex;
    align-items: center;
    gap: .7rem;
    flex-wrap: wrap;
}
.wph-date-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
    white-space: nowrap;
}
.wph-date-select {
    padding: .42rem .9rem;
    border: 1px solid var(--border);
    border-radius: 7px;
    background: var(--parchment, #F0EBE0);
    color: var(--ink);
    font-size: .8rem;
    font-family: inherit;
    cursor: pointer;
    transition: border-color .15s, box-shadow .15s;
    max-width: 200px;
}
.wph-date-select:focus {
    outline: none;
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,146,42,.12);
}
.wph-per-kg-note {
    font-size: .7rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: .45rem;
    opacity: .8;
}
.wph-per-kg-note svg { color: var(--gold); }

/* ── Main content ── */
.wph-content { padding: 2.5rem 0 4rem; }

/* Commodity group cards */
.wph-groups { display: flex; flex-direction: column; gap: 1.5rem; }

.wph-group-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(27,67,50,.04), 0 1px 3px rgba(27,67,50,.06);
    transition: box-shadow .2s;
}
.wph-group-card:hover {
    box-shadow: 0 8px 32px rgba(27,67,50,.09), 0 2px 8px rgba(27,67,50,.06);
}
.wph-group-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .85rem 1.5rem;
    background: linear-gradient(135deg, var(--canopy) 0%, #1e4d38 100%);
    gap: 1rem;
}
.wph-group-title {
    display: flex;
    align-items: center;
    gap: .65rem;
}
.wph-group-icon {
    width: 28px; height: 28px;
    border-radius: 6px;
    background: rgba(200,146,42,.2);
    border: 1px solid rgba(200,146,42,.3);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.wph-group-icon svg { color: var(--gold-2); }
.wph-group-name {
    font-size: .85rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: .01em;
}
.wph-group-count {
    font-size: .65rem;
    font-weight: 600;
    color: rgba(255,255,255,.45);
    background: rgba(255,255,255,.08);
    border-radius: 100px;
    padding: .2rem .65rem;
    white-space: nowrap;
}

/* Table within group */
.wph-group-table-wrap { overflow-x: auto; }
.wph-group-table {
    width: 100%;
    border-collapse: collapse;
}
.wph-group-table thead tr {
    background: rgba(27,67,50,.03);
    border-bottom: 1px solid var(--border);
}
.wph-group-table thead th {
    padding: .5rem 1.25rem;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
    text-align: left;
    white-space: nowrap;
}
.wph-group-table thead th.th-lkr,
.wph-group-table thead th.th-usd { text-align: right; }
.wph-group-table thead th.th-lkr { color: var(--canopy); }

.wph-group-table tbody tr {
    border-bottom: 1px solid rgba(27,67,50,.055);
    transition: background .1s;
}
.wph-group-table tbody tr:last-child { border-bottom: none; }
.wph-group-table tbody tr:hover { background: rgba(200,146,42,.03); }

.wph-td-grade {
    padding: .6rem 1.25rem;
    font-size: .84rem;
    color: var(--ink);
    font-weight: 500;
}
.wph-td-lkr {
    padding: .6rem 1.25rem;
    text-align: right;
    font-size: .9rem;
    font-weight: 700;
    color: var(--canopy);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}
.wph-td-usd {
    padding: .6rem 1.25rem;
    text-align: right;
    font-size: .8rem;
    color: var(--muted);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}
.wph-lkr-prefix {
    font-size: .66rem;
    font-weight: 600;
    color: var(--sage);
    opacity: .8;
    margin-right: .2rem;
    letter-spacing: .03em;
}
.wph-usd-prefix {
    font-size: .66rem;
    color: var(--muted);
    opacity: .7;
    margin-right: .15rem;
}
.wph-na { color: rgba(27,67,50,.2); font-size: .75rem; font-weight: 400; }

/* Loading state */
.wph-loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(240,235,224,.7);
    z-index: 999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
}
.wph-loading-overlay.visible { display: flex; }
.wph-loading-box {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    gap: .75rem;
    font-size: .84rem;
    color: var(--muted);
    box-shadow: 0 8px 32px rgba(27,67,50,.12);
}
@keyframes spin { to{transform:rotate(360deg)} }
.wph-spin { animation: spin .7s linear infinite; }

/* Notes bar */
.wph-notes {
    margin-top: 1.25rem;
    display: flex;
    gap: .75rem;
    align-items: flex-start;
    background: rgba(200,146,42,.04);
    border: 1px solid rgba(200,146,42,.14);
    border-radius: 10px;
    padding: .95rem 1.25rem;
}
.wph-notes svg { color: var(--gold); flex-shrink: 0; margin-top: .1rem; }
.wph-notes p { margin: 0; font-size: .76rem; color: var(--muted); line-height: 1.72; }
.wph-notes a { color: var(--gold); text-decoration: none; }
.wph-notes a:hover { text-decoration: underline; }

/* CTA band */
.wph-cta-band {
    margin-top: 3rem;
    background: linear-gradient(135deg, var(--canopy) 0%, #1e4d38 100%);
    border-radius: 16px;
    padding: 2.5rem 2.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.75rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.wph-cta-band::after {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(200,146,42,.07);
    pointer-events: none;
}
.wph-cta-band-text h3 {
    color: #fff;
    font-size: 1.15rem;
    margin: 0 0 .4rem;
    line-height: 1.2;
}
.wph-cta-band-text p {
    color: rgba(255,255,255,.55);
    margin: 0;
    font-size: .84rem;
    line-height: 1.6;
    max-width: 44ch;
}
.wph-cta-band .btn {
    background: linear-gradient(135deg, #C8922A, #D4A843);
    color: #fff;
    border-color: transparent;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    transition: all .2s;
}
.wph-cta-band .btn:hover {
    background: linear-gradient(135deg, #B87E22, #C8922A);
    box-shadow: 0 8px 24px rgba(200,146,42,.45);
    transform: translateY(-2px);
}

@media(max-width:640px){
    .wph-group-table thead th.th-usd,
    .wph-group-table tbody td.wph-td-usd { display:none; }
    .wph-cta-band { padding: 1.75rem 1.5rem; }
    .wph-filter-strip { position: static; }
}
</style>

{{-- Loading overlay --}}
<div class="wph-loading-overlay" id="wphLoadingOverlay">
    <div class="wph-loading-box">
        <svg class="wph-spin" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><path d="M21 12a9 9 0 11-18 0"/></svg>
        Loading price data…
    </div>
</div>

{{-- Hero --}}
<div class="wph-hero">
    <div class="container wph-hero-inner">
        <div class="wph-eyebrow">
            <span class="wph-eyebrow-line"></span>
            Ceylon Aroma Export
        </div>
        <h1>Wholesale Price List</h1>
        <p class="wph-hero-desc">Indicative market prices for Ceylon spices, teas, coffees, essential oils and agricultural commodities — published every business day.</p>
        <div class="wph-meta-stack">
            @if($lastUpdated)
            <div class="wph-update-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Prices as of <strong>{{ \Carbon\Carbon::parse($lastUpdated)->format('d M Y') }}</strong>
            </div>
            @endif
            <div class="wph-schedule-pill">Updated daily at 11:00 AM Sri Lanka Time</div>
            <a href="{{ route('contact') }}" class="wph-hero-cta">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Request Export Quote
            </a>
        </div>
    </div>
</div>

{{-- Filter strip --}}
<div class="wph-filter-strip">
    <div class="container">
        <div class="wph-filter-inner">
            <div class="wph-filter-left">
                <span class="wph-date-label">Price Date:</span>
                @if($availableDates->count() > 1)
                <select class="wph-date-select" id="wphDateSelect">
                    @foreach($availableDates as $d)
                    @php $dStr = $d instanceof \Carbon\Carbon ? $d->format('Y-m-d') : (string)$d; @endphp
                    <option value="{{ $dStr }}" {{ $loop->first ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($dStr)->format('d M Y') }}{{ $loop->first ? ' — Latest' : '' }}
                    </option>
                    @endforeach
                </select>
                @else
                <span style="font-size:.82rem;color:var(--ink);font-weight:600">
                    {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M Y') : 'No data' }}
                </span>
                @endif
            </div>
            <div class="wph-per-kg-note">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                All prices per kilogram &nbsp;·&nbsp; LKR = Sri Lankan Rupees &nbsp;·&nbsp; USD = US Dollars
            </div>
        </div>
    </div>
</div>

{{-- Content --}}
<section class="wph-content">
    <div class="container">

        @if($grouped->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <h3>No prices published yet</h3>
            <p>Check back soon or <a href="{{ route('contact') }}">contact us</a> for current export rates.</p>
        </div>
        @else

        <div class="wph-groups" id="wphGroups">
            @foreach($grouped as $commodity => $rows)
            @php
                $icons = [
                    'Cinnamon'       => '<path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 12c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    'Pepper'         => '<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 8V4M8.5 9.5l-2.5-2.5M15.5 9.5l2.5-2.5" stroke="currentColor" stroke-width="1.5"/>',
                    'Cloves'         => '<path d="M12 2v12M9 7c0 0 3 3 3 7s3-4 3-7" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="12" cy="20" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    'Cardamom'       => '<rect x="7" y="4" width="10" height="16" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="12" y1="8" x2="12" y2="16" stroke="currentColor" stroke-width="1.5"/>',
                    'Nutmeg & Mace'  => '<ellipse cx="12" cy="12" rx="5" ry="8" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 12h10" stroke="currentColor" stroke-width="1.5"/>',
                    'Turmeric'       => '<path d="M12 3c0 0-6 4-6 9s3 9 6 9 6-4 6-9-6-9-6-9z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    'Ginger'         => '<path d="M8 20c2-4 4-8 4-12 0 4 2 8 4 12" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M6 14c2-2 4-2 6 0 2-2 4-2 6 0" stroke="currentColor" stroke-width="1.5"/>',
                    'Tea'            => '<path d="M4 6h16v10a4 4 0 01-4 4H8a4 4 0 01-4-4V6z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M16 6c0-2-4-2-4-4 0 2-4 2-4 4" stroke="currentColor" stroke-width="1.5"/>',
                    'Coffee'         => '<path d="M6 4h12v8a6 6 0 01-12 0V4z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M18 6c2 0 4 1 4 3s-2 3-4 3" stroke="currentColor" stroke-width="1.5"/>',
                    'Coconut'        => '<circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 4c-2 4-2 8 0 16M4 9c4 2 8 2 16 0M4 15c4-2 8-2 16 0" stroke="currentColor" stroke-width="1.5"/>',
                    'Essential Oils' => '<path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    'Herbs'          => '<path d="M6 20c0-6 3-12 6-16 3 4 6 10 6 16" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M9 10c-2 0-4-2-4-4 2 0 4 2 4 4z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M15 10c2 0 4-2 4-4-2 0-4 2-4 4z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    'Rice'           => '<path d="M12 3c0 0-8 5-8 11s8 7 8 7 8-1 8-7-8-11-8-11z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                ];
                $iconSvg = $icons[$commodity] ?? '<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/>';
            @endphp
            <div class="wph-group-card">
                <div class="wph-group-header">
                    <div class="wph-group-title">
                        <div class="wph-group-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24">{!! $iconSvg !!}</svg>
                        </div>
                        <span class="wph-group-name">{{ $commodity }}</span>
                    </div>
                    <span class="wph-group-count">{{ $rows->count() }} grades</span>
                </div>
                <div class="wph-group-table-wrap">
                    <table class="wph-group-table">
                        <thead>
                            <tr>
                                <th style="width:46%">Grade / Type</th>
                                <th class="th-lkr" style="width:27%">LKR / kg</th>
                                <th class="th-usd" style="width:27%">USD / kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            <tr>
                                <td class="wph-td-grade">{{ $row->grade }}</td>
                                <td class="wph-td-lkr">
                                    @if($row->price_lkr !== null)
                                    <span class="wph-lkr-prefix">Rs</span>{{ number_format((float)$row->price_lkr, 0) }}
                                    @else<span class="wph-na">—</span>@endif
                                </td>
                                <td class="wph-td-usd">
                                    @if($row->price_usd !== null)
                                    <span class="wph-usd-prefix">$</span>{{ number_format((float)$row->price_usd, 2) }}
                                    @else<span class="wph-na">—</span>@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

        <div class="wph-notes">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p>All prices are indicative wholesale rates and subject to change without notice. Prices marked <strong>—</strong> are available on request. USD rates are approximate equivalents. For confirmed export quotes, bulk pricing, FOB/CIF terms and full compliance documentation, please <a href="{{ route('contact') }}">contact our export team</a>.</p>
        </div>

        <div class="wph-cta-band">
            <div class="wph-cta-band-text">
                <h3>Need a confirmed export price?</h3>
                <p>Our team provides FOB, CIF and DDP quotes with ISO 22000, HACCP and organic certifications for all commodities.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
                Request Export Quote
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
        @endif

    </div>
</section>

@if($availableDates->count() > 1)
<script>
(function(){
    var sel     = document.getElementById('wphDateSelect');
    var overlay = document.getElementById('wphLoadingOverlay');
    var groups  = document.getElementById('wphGroups');
    if (!sel || !groups) return;

    sel.addEventListener('change', function(){
        overlay.classList.add('visible');

        fetch('/wholesale-prices/by-date?date=' + encodeURIComponent(sel.value), {
            headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
        })
        .then(function(r){ return r.json(); })
        .then(function(rows){
            overlay.classList.remove('visible');
            renderGroups(rows);
        })
        .catch(function(){
            overlay.classList.remove('visible');
        });
    });

    var ICONS = {
        'Cinnamon'      : '<path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 12c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Pepper'        : '<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 8V4M8.5 9.5l-2.5-2.5M15.5 9.5l2.5-2.5" stroke="currentColor" stroke-width="1.5"/>',
        'Cloves'        : '<path d="M12 2v12M9 7c0 0 3 3 3 7s3-4 3-7" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="12" cy="20" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Cardamom'      : '<rect x="7" y="4" width="10" height="16" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="12" y1="8" x2="12" y2="16" stroke="currentColor" stroke-width="1.5"/>',
        'Nutmeg & Mace' : '<ellipse cx="12" cy="12" rx="5" ry="8" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 12h10" stroke="currentColor" stroke-width="1.5"/>',
        'Tea'           : '<path d="M4 6h16v10a4 4 0 01-4 4H8a4 4 0 01-4-4V6z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M16 6c0-2-4-2-4-4 0 2-4 2-4 4" stroke="currentColor" stroke-width="1.5"/>',
        'Coffee'        : '<path d="M6 4h12v8a6 6 0 01-12 0V4z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M18 6c2 0 4 1 4 3s-2 3-4 3" stroke="currentColor" stroke-width="1.5"/>',
        'Coconut'       : '<circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 4c-2 4-2 8 0 16M4 9c4 2 8 2 16 0M4 15c4-2 8-2 16 0" stroke="currentColor" stroke-width="1.5"/>',
        'Essential Oils': '<path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Herbs'         : '<path d="M6 20c0-6 3-12 6-16 3 4 6 10 6 16" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Rice'          : '<path d="M12 3c0 0-8 5-8 11s8 7 8 7 8-1 8-7-8-11-8-11z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        '_default'      : '<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/>',
    };

    function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
    function fmtLkr(v){ return v!=null?'<span class="wph-lkr-prefix">Rs</span>'+parseInt(v).toLocaleString():'<span class="wph-na">—</span>'; }
    function fmtUsd(v){ return v!=null?'<span class="wph-usd-prefix">$</span>'+parseFloat(v).toFixed(2):'<span class="wph-na">—</span>'; }

    function renderGroups(rows){
        // group by commodity
        var map = {}, order = [];
        rows.forEach(function(r){
            if (!map[r.commodity]){ map[r.commodity]=[]; order.push(r.commodity); }
            map[r.commodity].push(r);
        });
        var html = '';
        order.forEach(function(comm){
            var icon = ICONS[comm] || ICONS._default;
            var gradeRows = map[comm];
            var tbody = gradeRows.map(function(r){
                return '<tr>'
                    +'<td class="wph-td-grade">'+esc(r.grade)+'</td>'
                    +'<td class="wph-td-lkr">'+fmtLkr(r.price_lkr)+'</td>'
                    +'<td class="wph-td-usd">'+fmtUsd(r.price_usd)+'</td>'
                    +'</tr>';
            }).join('');
            html += '<div class="wph-group-card">'
                  +'<div class="wph-group-header">'
                  +'<div class="wph-group-title">'
                  +'<div class="wph-group-icon"><svg width="14" height="14" viewBox="0 0 24 24">'+icon+'</svg></div>'
                  +'<span class="wph-group-name">'+esc(comm)+'</span>'
                  +'</div>'
                  +'<span class="wph-group-count">'+gradeRows.length+' grades</span>'
                  +'</div>'
                  +'<div class="wph-group-table-wrap"><table class="wph-group-table">'
                  +'<thead><tr><th style="width:46%">Grade / Type</th><th class="th-lkr" style="width:27%">LKR / kg</th><th class="th-usd" style="width:27%">USD / kg</th></tr></thead>'
                  +'<tbody>'+tbody+'</tbody>'
                  +'</table></div>'
                  +'</div>';
        });
        groups.innerHTML = html;
    }
})();
</script>
@endif

@endsection
