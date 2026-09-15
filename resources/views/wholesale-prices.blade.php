@extends('layouts.app')

@section('title', 'Wholesale Prices')
@section('meta_description', 'Daily wholesale market prices for Ceylon spices, tea, coffee and natural products. Updated every weekday at 11:00 AM Sri Lanka time.')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════════════════════════
   Wholesale Prices — Premium Equal-Column Layout
   ═══════════════════════════════════════════════════════════════════ */
:root {
    --canopy:    #1B4332;
    --canopy-2:  #13311F;
    --canopy-3:  #245040;
    --sage:      #5D8A6C;
    --gold:      #C8922A;
    --gold-2:    #D4A845;
    --gold-pale: rgba(200,146,42,.09);
    --gold-glow: rgba(200,146,42,.22);
    --parchment: #F0EBE0;
    --ink:       #1A2A20;
    --muted:     #546A5E;
    --border:    rgba(27,67,50,.10);
    --border-2:  rgba(27,67,50,.07);
    --surface:   #ffffff;
    --bg:        #F4F2EE;
    --radius:    16px;
    --radius-sm: 10px;
    --shadow-xs: 0 1px 3px rgba(27,67,50,.05);
    --shadow:    0 2px 14px rgba(27,67,50,.06), 0 1px 4px rgba(27,67,50,.05);
    --shadow-md: 0 6px 24px rgba(27,67,50,.09), 0 2px 6px rgba(27,67,50,.06);
    --shadow-lg: 0 16px 48px rgba(27,67,50,.12), 0 4px 12px rgba(27,67,50,.07);
    --font-head: 'Fraunces', Georgia, serif;
    --font-body: 'Inter', system-ui, sans-serif;
    --col-h:     78vh;
}

* { box-sizing: border-box; }

/* ─── Google font override for this page ─── */
.wph-hero h1, .wph-hist-empty h3, .wph-cta-band-text h3 {
    font-family: var(--font-head);
}

/* ══ HERO ══════════════════════════════════════════════════════════ */
.wph-hero {
    position: relative;
    background: linear-gradient(155deg, var(--canopy-2) 0%, var(--canopy) 50%, var(--canopy-3) 100%);
    overflow: hidden;
    padding: 5rem 0 3.75rem;
}
.wph-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 80% 80% at 115% -10%, rgba(200,146,42,.18) 0%, transparent 55%),
        radial-gradient(ellipse 60% 70% at -15% 115%, rgba(93,138,108,.14) 0%, transparent 55%);
    pointer-events: none;
}
.wph-hero::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(200,146,42,.3) 10%,
        var(--gold) 35%,
        var(--gold-2) 50%,
        var(--gold) 65%,
        rgba(200,146,42,.3) 90%,
        transparent 100%);
}
.wph-hero-inner { position: relative; z-index: 1; }
.wph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    font-size: .56rem;
    font-weight: 700;
    letter-spacing: .25em;
    text-transform: uppercase;
    color: var(--gold-2);
    margin-bottom: 1.1rem;
    font-family: var(--font-body);
}
.wph-eyebrow-line { width: 24px; height: 1.5px; background: var(--gold-2); opacity: .5; flex-shrink: 0; }
.wph-hero h1 {
    color: #fff;
    font-size: clamp(2rem, 4vw, 3rem);
    margin: 0 0 .85rem;
    line-height: 1.06;
    letter-spacing: -.025em;
    font-weight: 600;
}
.wph-hero h1 em { color: var(--gold-2); font-style: italic; }
.wph-hero-desc {
    color: rgba(255,255,255,.48);
    font-size: .88rem;
    max-width: 52ch;
    line-height: 1.85;
    margin: 0 0 1.75rem;
    font-family: var(--font-body);
}
.wph-meta-stack { display: flex; flex-wrap: wrap; gap: .6rem; align-items: center; }
.wph-update-pill {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.11);
    border-radius: 100px;
    padding: .5rem 1.15rem;
    font-size: .71rem;
    color: rgba(255,255,255,.68);
    backdrop-filter: blur(8px);
    font-family: var(--font-body);
}
.wph-update-pill svg { flex-shrink: 0; color: var(--gold-2); }
.wph-update-pill strong { color: #fff; font-weight: 700; }
.wph-live-pill {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .68rem;
    font-weight: 600;
    color: rgba(200,146,42,.9);
    font-family: var(--font-body);
}
.wph-live-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--gold);
    animation: wpulse 2.2s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes wpulse {
    0%,100%{ opacity:1; transform:scale(1); box-shadow:0 0 0 0 rgba(200,146,42,.4); }
    50%{ opacity:.5; transform:scale(1.3); box-shadow:0 0 0 5px rgba(200,146,42,0); }
}

/* ══ PAGE WRAPPER ═══════════════════════════════════════════════════ */
.wph-page {
    background: var(--bg);
    padding: 2.5rem 0 4.5rem;
    font-family: var(--font-body);
}

/* ══ EQUAL-HEIGHT SPLIT ═════════════════════════════════════════════ */
.wph-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: stretch;   /* ← equal height */
}
/* Each column is a flex column that fills the grid cell */
.wph-col-wrap {
    display: flex;
    flex-direction: column;
    min-height: 500px;
}

/* ── Premium column panel ── */
.wph-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

/* ── Panel header ── */
.wph-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    padding: 1.2rem 1.6rem;
    background: linear-gradient(135deg, var(--canopy) 0%, var(--canopy-3) 100%);
    flex-shrink: 0;
}
.wph-panel-head-left { display: flex; align-items: center; gap: .75rem; }
.wph-panel-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: rgba(200,146,42,.15);
    border: 1px solid rgba(200,146,42,.22);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.wph-panel-icon svg { color: var(--gold-2); }
.wph-panel-title {
    font-size: .9rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -.01em;
}
.wph-panel-badge {
    font-size: .54rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    background: rgba(200,146,42,.18);
    color: var(--gold-2);
    border: 1px solid rgba(200,146,42,.28);
    border-radius: 4px;
    padding: .22rem .6rem;
}
.wph-panel-meta {
    font-size: .67rem;
    color: rgba(255,255,255,.45);
    white-space: nowrap;
}

/* ── Gold divider beneath header ── */
.wph-panel-divider {
    height: 2px;
    background: linear-gradient(90deg, var(--gold-2) 0%, var(--gold) 50%, rgba(200,146,42,.3) 100%);
    flex-shrink: 0;
}

/* ── Scrollable body ── */
.wph-panel-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
    scroll-behavior: smooth;
}
.wph-panel-body::-webkit-scrollbar { width: 5px; }
.wph-panel-body::-webkit-scrollbar-track { background: transparent; }
.wph-panel-body::-webkit-scrollbar-thumb { background: rgba(27,67,50,.15); border-radius: 10px; }
.wph-panel-body::-webkit-scrollbar-thumb:hover { background: rgba(200,146,42,.4); }

/* Fade at bottom of scroll area */
.wph-scroll-fade {
    position: relative;
}
.wph-scroll-fade::after {
    content: '';
    position: sticky;
    bottom: 0; left: 0; right: 0;
    height: 32px;
    background: linear-gradient(to bottom, transparent 0%, rgba(255,255,255,.9) 100%);
    display: block;
    pointer-events: none;
    margin-top: -32px;
}

/* ── Panel footer ── */
.wph-panel-foot {
    flex-shrink: 0;
    border-top: 1px solid var(--border);
    background: rgba(240,235,224,.3);
    padding-top: 1.35rem;
}

/* ══ COMMODITY CARDS ════════════════════════════════════════════════ */
.wph-groups { display: flex; flex-direction: column; gap: 1.15rem; }
.wph-group-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    box-shadow: var(--shadow-xs);
    transition: box-shadow .2s, transform .18s;
}
.wph-group-card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }
.wph-group-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .9rem 1.3rem;
    background: linear-gradient(135deg, rgba(27,67,50,.055) 0%, rgba(27,67,50,.022) 100%);
    border-bottom: 1px solid var(--border-2);
    gap: .75rem;
    cursor: pointer;
    user-select: none;
    transition: background .15s;
}
.wph-group-header:hover { background: linear-gradient(135deg, rgba(27,67,50,.09) 0%, rgba(27,67,50,.045) 100%); }
.wph-group-chevron {
    display: flex; align-items: center; justify-content: center;
    width: 22px; height: 22px; border-radius: 6px; flex-shrink: 0;
    background: rgba(200,146,42,.1); border: 1px solid rgba(200,146,42,.2);
    color: var(--gold);
    transition: transform .28s cubic-bezier(.4,0,.2,1), background .15s;
}
.wph-group-card.is-collapsed .wph-group-chevron { transform: rotate(-90deg); }
.wph-group-table-wrap {
    overflow-x: auto;
    max-height: 2000px;
    opacity: 1;
    transition: max-height .32s ease, opacity .22s ease;
}
.wph-group-card.is-collapsed .wph-group-table-wrap {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
}
.wph-group-title { display: flex; align-items: center; gap: .6rem; }
.wph-group-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    background: var(--gold-pale);
    border: 1px solid rgba(200,146,42,.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.wph-group-icon svg { color: var(--gold); }
.wph-group-name { font-size: .84rem; font-weight: 700; color: var(--ink); }
.wph-group-count {
    font-size: .57rem; color: var(--muted);
    font-weight: 600; letter-spacing: .07em; text-transform: uppercase;
    background: rgba(27,67,50,.06);
    border-radius: 20px; padding: .18rem .55rem; white-space: nowrap;
}
.wph-group-table-wrap { overflow-x: auto; }
.wph-group-table { width: 100%; border-collapse: collapse; font-size: .81rem; }
.wph-group-table thead th {
    padding: .6rem 1.2rem;
    background: rgba(240,235,224,.45);
    font-size: .56rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
    text-align: left;
    border-bottom: 1px solid var(--border);
}
.wph-group-table thead th:not(:first-child) { text-align: right; }
.wph-group-table tbody tr { border-bottom: 1px solid rgba(27,67,50,.05); }
.wph-group-table tbody tr:last-child { border-bottom: none; }
.wph-group-table tbody tr:nth-child(even) { background: rgba(240,235,224,.2); }
.wph-group-table tbody tr:hover { background: rgba(200,146,42,.05); }
.wph-td-grade {
    padding: .68rem 1.2rem;
    color: var(--ink);
    font-weight: 500;
    font-size: .8rem;
    line-height: 1.45;
}
.wph-td-lkr {
    padding: .68rem 1.2rem;
    text-align: right;
    color: var(--ink);
    font-weight: 700;
    font-size: .81rem;
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}
.wph-td-usd {
    padding: .68rem 1.2rem;
    text-align: right;
    font-size: .77rem;
    color: var(--muted);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}
.wph-lkr-prefix { font-size: .6rem; font-weight: 600; color: var(--sage); opacity: .8; margin-right: .17rem; }
.wph-usd-prefix { font-size: .6rem; color: var(--muted); opacity: .55; margin-right: .12rem; }
.wph-na { color: rgba(27,67,50,.18); font-size: .73rem; }

/* ══ NOTES + FOOTER CONTENT ═════════════════════════════════════════ */
.wph-notes {
    display: flex; gap: .8rem;
    background: rgba(240,235,224,.55);
    border-radius: 9px;
    padding: 1rem 1.15rem;
    font-size: .74rem;
    color: var(--muted);
    line-height: 1.75;
    margin: 0 1.5rem 1.1rem;
}
.wph-notes svg { flex-shrink: 0; color: var(--gold); margin-top: 2px; }
.wph-notes a { color: var(--canopy); font-weight: 600; }
.wph-notes a:hover { color: var(--gold); }

.wph-bulk-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin: 0 1.5rem 1.1rem;
    padding: 1rem 1.3rem;
    background: var(--gold-pale);
    border: 1.5px solid rgba(200,146,42,.25);
    border-radius: 11px;
    text-decoration: none;
    transition: background .15s, border-color .15s, transform .15s;
}
.wph-bulk-link:hover {
    background: var(--gold-glow);
    border-color: rgba(200,146,42,.5);
    transform: translateX(3px);
}
.wph-bulk-link-left { display: flex; align-items: center; gap: .85rem; }
.wph-bulk-link-icon {
    width: 38px; height: 38px;
    border-radius: 9px;
    background: var(--gold);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(200,146,42,.32);
}
.wph-bulk-link-text strong { display: block; font-size: .82rem; font-weight: 700; color: var(--ink); margin-bottom: .1rem; }
.wph-bulk-link-text span { font-size: .7rem; color: var(--muted); }

/* CTA band */
.wph-cta-band {
    margin: 0 1.5rem 1.5rem;
    background: linear-gradient(135deg, var(--canopy) 0%, var(--canopy-3) 100%);
    border-radius: var(--radius-sm);
    padding: 1.65rem 1.85rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.25rem;
    flex-wrap: wrap;
    box-shadow: 0 4px 18px rgba(27,67,50,.14);
}
.wph-cta-band-text h3 { color: #fff; font-size: 1.02rem; margin: 0 0 .35rem; font-weight: 600; }
.wph-cta-band-text p { color: rgba(255,255,255,.48); font-size: .76rem; margin: 0; max-width: 36ch; line-height: 1.65; }

/* ══ HISTORY COLUMN ══════════════════════════════════════════════════ */

/* ══ CALENDAR — compact premium ══════════════════════════════════════ */
.wph-hcal {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-xs);
}

/* Header: dark green strip with month + legend */
.wph-hcal-head {
    background: linear-gradient(135deg, var(--canopy) 0%, var(--canopy-3) 100%);
    padding: .65rem 1rem;
    display: flex; align-items: center; justify-content: space-between;
}
.wph-hcal-head-title {
    font-size: .56rem; font-weight: 700; letter-spacing: .15em;
    text-transform: uppercase; color: rgba(255,255,255,.55);
}
.wph-hcal-head-legend {
    display: flex; align-items: center; gap: .35rem;
    font-size: .62rem; color: var(--gold-2); font-weight: 600;
}
.wph-hcal-head-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--gold); flex-shrink: 0;
    box-shadow: 0 0 5px rgba(200,146,42,.5);
}

/* Nav row */
.wph-hcal-body { padding: .7rem .85rem .8rem; }
.wph-hcal-nav {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .6rem;
}
.wph-hcal-month { font-size: .82rem; font-weight: 700; color: var(--ink); letter-spacing: -.01em; }
.wph-hcal-arrow {
    width: 26px; height: 26px;
    border-radius: 6px;
    border: 1px solid var(--border);
    background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--muted);
    transition: border-color .12s, color .12s, background .12s;
    flex-shrink: 0;
}
.wph-hcal-arrow:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-pale); }

/* 7-column grid — fixed-height cells so the calendar stays compact */
.wph-hcal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
}
.wph-hcal-dow {
    text-align: center;
    font-size: .49rem; font-weight: 700; letter-spacing: .09em;
    text-transform: uppercase; color: var(--muted);
    padding: .15rem 0 .32rem;
    line-height: 1;
}
.wph-hcal-day {
    height: 28px;           /* ← fixed height keeps calendar compact */
    display: flex; align-items: center; justify-content: center;
    border-radius: 5px;
    font-size: .7rem; font-variant-numeric: tabular-nums;
    color: rgba(27,67,50,.22);
    cursor: default; user-select: none;
    transition: background .1s, transform .12s, color .1s, box-shadow .12s;
    position: relative;
}
/* Dot indicator under dates that have data */
.wph-hcal-day.has-data {
    color: var(--ink);
    font-weight: 700;
    cursor: pointer;
    background: rgba(200,146,42,.08);
    border: 1px solid rgba(200,146,42,.16);
}
.wph-hcal-day.has-data::after {
    content: '';
    position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%);
    width: 4px; height: 4px;
    border-radius: 50%;
    background: var(--gold);
    opacity: .8;
}
.wph-hcal-day.has-data:hover {
    background: rgba(200,146,42,.16);
    transform: scale(1.08);
    border-color: rgba(200,146,42,.35);
}
.wph-hcal-day.is-active {
    background: var(--gold) !important;
    color: #fff !important;
    border-color: transparent !important;
    transform: scale(1.06) !important;
    box-shadow: 0 3px 10px rgba(200,146,42,.42);
    font-weight: 700;
}
.wph-hcal-day.is-active::after { display: none; }
.wph-hcal-day.is-today:not(.is-active) {
    box-shadow: inset 0 0 0 1.5px var(--sage);
    color: var(--sage);
}

/* Responsive: slightly smaller cells on narrow columns */
@media (max-width: 1200px) {
    .wph-hcal-day { height: 26px; font-size: .66rem; }
}
@media (max-width: 640px) {
    .wph-hcal-day { height: 30px; font-size: .71rem; }
    .wph-hcal-body { padding: .75rem; }
}

/* Chips */
.wph-chips-wrap {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: .9rem 1.15rem;
    margin-bottom: 1.15rem;
    box-shadow: var(--shadow-xs);
}
.wph-chips-label { font-size: .55rem; font-weight: 700; letter-spacing: .13em; text-transform: uppercase; color: var(--muted); margin-bottom: .6rem; }
.wph-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
.wph-chip {
    font-size: .68rem; font-weight: 600;
    padding: .33rem .72rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--ink);
    cursor: pointer;
    transition: all .12s;
    line-height: 1;
}
.wph-chip:hover { background: var(--gold-pale); border-color: var(--gold); color: var(--gold); }
.wph-chip.active { background: var(--gold); border-color: var(--gold); color: #fff; box-shadow: 0 2px 8px rgba(200,146,42,.3); }

/* History empty */
.wph-hist-empty {
    background: rgba(240,235,224,.4);
    border: 1.5px dashed rgba(200,146,42,.28);
    border-radius: var(--radius-sm);
    padding: 3.25rem 2rem;
    text-align: center; color: var(--muted);
}
.wph-hist-empty-icon {
    width: 52px; height: 52px; border-radius: 13px;
    background: var(--gold-pale);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
}
.wph-hist-empty-icon svg { color: var(--gold); }
.wph-hist-empty h3 { font-size: .95rem; color: var(--ink); margin: 0 0 .38rem; font-family: var(--font-head); }
.wph-hist-empty p { font-size: .77rem; max-width: 26ch; margin: 0 auto; line-height: 1.7; }

/* History date badge */
.wph-hist-date-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--canopy); color: #fff;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .76rem; font-weight: 700; margin-bottom: 1rem;
}
.wph-hist-date-badge svg { color: var(--gold-2); flex-shrink: 0; }
.wph-hist-item-count {
    font-size: .68rem; color: var(--muted); margin-left: .6rem;
    font-weight: 600;
}

/* ══ LOADING ═════════════════════════════════════════════════════════ */
.wph-loading-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(244,242,238,.72);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}
.wph-loading-overlay.visible { display: flex; }
.wph-loading-box {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.2rem 1.85rem;
    display: flex; align-items: center; gap: .75rem;
    font-size: .81rem; color: var(--muted);
    box-shadow: var(--shadow-lg);
}
.wph-spinner {
    width: 18px; height: 18px;
    border: 2.5px solid var(--border);
    border-top-color: var(--gold);
    border-radius: 50%;
    animation: wspin .65s linear infinite;
    flex-shrink: 0;
}
@keyframes wspin { to { transform: rotate(360deg); } }

/* ══ RESPONSIVE ══════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .wph-split { grid-template-columns: 1fr; }
    :root { --col-h: auto; }
    .wph-col-wrap { min-height: 0; }
    .wph-panel-body { max-height: 65vh; }
}
@media (max-width: 640px) {
    .wph-hero { padding: 3.5rem 0 2.75rem; }
    .wph-page { padding: 1.5rem 0 3rem; }
    .wph-split { gap: 1.25rem; }
    .wph-group-table thead th.th-usd,
    .wph-group-table tbody td.wph-td-usd { display: none; }
    .wph-cta-band { flex-direction: column; align-items: flex-start; }
    .wph-panel-body { max-height: 60vh; }
    .wph-panel-meta { display: none; }
    .wph-panel-title { white-space: nowrap; }
}
</style>

{{-- Loading overlay --}}
<div id="wphLoadingOverlay" class="wph-loading-overlay" role="status" aria-live="polite">
    <div class="wph-loading-box">
        <div class="wph-spinner"></div>
        <span>Loading prices…</span>
    </div>
</div>

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
<section class="wph-hero">
    <div class="container">
        <div class="wph-hero-inner">
            <div class="wph-eyebrow">
                <span class="wph-eyebrow-line"></span>
                Ceylon Aroma &nbsp;·&nbsp; Market Intelligence
                <span class="wph-eyebrow-line"></span>
            </div>
            <h1>Ceylon Commodity<br><em>Wholesale Prices</em></h1>
            <p class="wph-hero-desc">
                Indicative daily market rates for premium Ceylon spices, tea, coffee, oils &amp; natural products — updated every weekday at 11:00 AM.
            </p>
            <div class="wph-meta-stack">
                @if($lastUpdatedFormatted)
                <span class="wph-update-pill">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Last updated: <strong>{{ $lastUpdatedFormatted }}</strong>
                </span>
                @endif
                <span class="wph-live-pill"><span class="wph-live-dot"></span>Updated daily at 11:00 AM Sri Lanka Time</span>
            </div>
        </div>
    </div>
</section>

{{-- ══ SPLIT PAGE ════════════════════════════════════════════════════ --}}
<div class="wph-page">
<div class="container">
<div class="wph-split">

    {{-- ──────────────────────────────────────────────────────────────
         LEFT COLUMN — Current Prices
    ────────────────────────────────────────────────────────────────── --}}
    <div class="wph-col-wrap">
    <div class="wph-panel">

        {{-- Panel header --}}
        <div class="wph-panel-head">
            <div class="wph-panel-head-left">
                <div class="wph-panel-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
                <span class="wph-panel-title">Current Prices</span>
                <span class="wph-panel-badge">Live · Today</span>
            </div>
            <span class="wph-panel-meta">Per kg &nbsp;·&nbsp; LKR &amp; USD</span>
        </div>
        <div class="wph-panel-divider"></div>

        {{-- Scrollable commodity list --}}
        @if($grouped->isEmpty())
        <div class="wph-panel-body" style="display:flex;align-items:center;justify-content:center">
            <p style="color:var(--muted);font-size:.83rem;text-align:center">No prices published yet.<br>Check back soon.</p>
        </div>
        @else
        <div class="wph-panel-body wph-scroll-fade">
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
                        'Ginger'         => '<path d="M8 20c2-4 4-8 4-12 0 4 2 8 4 12" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                        'Tea'            => '<path d="M4 6h16v10a4 4 0 01-4 4H8a4 4 0 01-4-4V6z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M16 6c0-2-4-2-4-4 0 2-4 2-4 4" stroke="currentColor" stroke-width="1.5"/>',
                        'Coffee'         => '<path d="M6 4h12v8a6 6 0 01-12 0V4z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M18 6c2 0 4 1 4 3s-2 3-4 3" stroke="currentColor" stroke-width="1.5"/>',
                        'Coconut'        => '<circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                        'Essential Oils' => '<path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                        'Herbs'          => '<path d="M6 20c0-6 3-12 6-16 3 4 6 10 6 16" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                        'Rice'           => '<path d="M12 3c0 0-8 5-8 11s8 7 8 7 8-1 8-7-8-11-8-11z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
                    ];
                    $iconSvg = $icons[$commodity] ?? '<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/>';
                @endphp
                <div class="wph-group-card">
                    <div class="wph-group-header">
                        <div class="wph-group-title">
                            <div class="wph-group-icon">
                                <svg width="12" height="12" viewBox="0 0 24 24">{!! $iconSvg !!}</svg>
                            </div>
                            <span class="wph-group-name">{{ $commodity }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:.5rem">
                            <span class="wph-group-count">{{ $rows->count() }} {{ Str::plural('grade', $rows->count()) }}</span>
                            <span class="wph-group-chevron" aria-hidden="true">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </div>
                    </div>
                    <div class="wph-group-table-wrap">
                        <table class="wph-group-table">
                            <thead><tr>
                                <th style="width:46%">Grade / Type</th>
                                <th class="th-lkr" style="width:27%">LKR / kg</th>
                                <th class="th-usd" style="width:27%">USD / kg</th>
                            </tr></thead>
                            <tbody>
                            @foreach($rows as $row)
                            <tr>
                                <td class="wph-td-grade">{{ $row->grade }}</td>
                                <td class="wph-td-lkr">
                                    @if($row->price_lkr !== null)<span class="wph-lkr-prefix">Rs</span>{{ number_format((float)$row->price_lkr, 0) }}
                                    @else<span class="wph-na">—</span>@endif
                                </td>
                                <td class="wph-td-usd">
                                    @if($row->price_usd !== null)<span class="wph-usd-prefix">$</span>{{ number_format((float)$row->price_usd, 2) }}
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
        </div>

        {{-- Panel footer --}}
        <div class="wph-panel-foot">
            <div class="wph-notes">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p>Indicative wholesale rates, subject to change. Prices marked — available on request. For confirmed export quotes or <a href="{{ route('contact') }}">bulk order enquiries</a>, contact our export team.</p>
            </div>
            <a href="{{ route('contact') }}" class="wph-bulk-link">
                <div class="wph-bulk-link-left">
                    <div class="wph-bulk-link-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                    </div>
                    <div class="wph-bulk-link-text">
                        <strong>Wholesale Bulk Order Enquiry</strong>
                        <span>Confirmed FOB/CIF quote with full certifications</span>
                    </div>
                </div>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5" style="flex-shrink:0"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <div class="wph-cta-band">
                <div class="wph-cta-band-text">
                    <h3>Need a confirmed export price?</h3>
                    <p>FOB, CIF and DDP quotes with ISO 22000, HACCP and organic certifications.</p>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-primary" style="white-space:nowrap;flex-shrink:0;font-size:.8rem">
                    Request Export Quote
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:.3rem"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
        @endif

    </div>{{-- /wph-panel --}}
    </div>{{-- /wph-col-wrap --}}

    {{-- ──────────────────────────────────────────────────────────────
         RIGHT COLUMN — Price History
    ────────────────────────────────────────────────────────────────── --}}
    <div class="wph-col-wrap">
    <div class="wph-panel">

        {{-- Panel header --}}
        <div class="wph-panel-head">
            <div class="wph-panel-head-left">
                <div class="wph-panel-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <span class="wph-panel-title">Price History</span>
            </div>
            <span class="wph-panel-meta">Select a past date</span>
        </div>
        <div class="wph-panel-divider" style="background:linear-gradient(90deg,rgba(93,138,108,.7) 0%,var(--sage) 50%,rgba(93,138,108,.3) 100%)"></div>

        @if($availableDates->count() >= 1)
        @php
            $allDatesJson = $availableDates->map(fn($d) => $d instanceof \Carbon\Carbon ? $d->format('Y-m-d') : (string)$d)->toJson();
            $recentDates  = $availableDates->take(10)->map(fn($d) => $d instanceof \Carbon\Carbon ? $d->format('Y-m-d') : (string)$d);
        @endphp
        <script>window._wphDates = {!! $allDatesJson !!};</script>

        {{-- Scrollable history body --}}
        <div class="wph-panel-body" id="wphHistBody">

            {{-- Calendar --}}
            <div class="wph-hcal">
                <div class="wph-hcal-head">
                    <span class="wph-hcal-head-title">Price Calendar</span>
                    <span class="wph-hcal-head-sub">Gold = published prices</span>
                </div>
                <div class="wph-hcal-body">
                    <div class="wph-hcal-nav">
                        <button type="button" class="wph-hcal-arrow" id="wphHcalPrev" aria-label="Previous month">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <span class="wph-hcal-month" id="wphHcalMonth"></span>
                        <button type="button" class="wph-hcal-arrow" id="wphHcalNext" aria-label="Next month">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                    <div class="wph-hcal-grid" id="wphHcalGrid"></div>
                </div>
            </div>

            {{-- Date chips --}}
            <div class="wph-chips-wrap">
                <div class="wph-chips-label">Recent Dates</div>
                <div class="wph-chips" id="wphChips">
                    @foreach($recentDates as $rd)
                    @php $rdStr = (string)$rd; @endphp
                    <span class="wph-chip{{ $loop->first ? ' active' : '' }}" data-date="{{ $rdStr }}">
                        {{ \Carbon\Carbon::parse($rdStr)->format('d M Y') }}
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Empty state --}}
            <div id="wphHistEmpty" class="wph-hist-empty">
                <div class="wph-hist-empty-icon">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3>Select a Date</h3>
                <p>Click a highlighted date or a chip above to view historical prices.</p>
            </div>

            {{-- History data --}}
            <div id="wphHistPanel" style="display:none">
                <div id="wphHistMeta" style="display:flex;align-items:center;flex-wrap:wrap;margin-bottom:.85rem"></div>
                <div class="wph-groups" id="wphHistGroups"></div>
            </div>

        </div>{{-- /wph-panel-body --}}

        @else
        <div class="wph-panel-body" style="display:flex;align-items:center;justify-content:center">
            <p style="color:var(--muted);font-size:.83rem;text-align:center">No historical data available yet.</p>
        </div>
        @endif

    </div>{{-- /wph-panel --}}
    </div>{{-- /wph-col-wrap --}}

</div>{{-- /wph-split --}}
</div>{{-- /container --}}
</div>{{-- /wph-page --}}

<script>
(function(){
    var overlay   = document.getElementById('wphLoadingOverlay');
    var dates     = window._wphDates || [];
    if (!dates.length) return;

    var dateSet = {};
    dates.forEach(function(d){ dateSet[d] = true; });

    var grid      = document.getElementById('wphHcalGrid');
    var monthLbl  = document.getElementById('wphHcalMonth');
    var prevBtn   = document.getElementById('wphHcalPrev');
    var nextBtn   = document.getElementById('wphHcalNext');
    var chips     = document.querySelectorAll('.wph-chip');
    var histEmpty = document.getElementById('wphHistEmpty');
    var histPanel = document.getElementById('wphHistPanel');
    var histGrps  = document.getElementById('wphHistGroups');
    var histMeta  = document.getElementById('wphHistMeta');

    if (!grid) return;

    var MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    var DOW    = ['Su','Mo','Tu','We','Th','Fr','Sa'];
    var ICONS  = {
        'Cinnamon'      :'<path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 12c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Pepper'        :'<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 8V4" stroke="currentColor" stroke-width="1.5"/>',
        'Cloves'        :'<path d="M12 2v12M9 7c0 0 3 3 3 7s3-4 3-7" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Cardamom'      :'<rect x="7" y="4" width="10" height="16" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Nutmeg & Mace' :'<ellipse cx="12" cy="12" rx="5" ry="8" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Tea'           :'<path d="M4 6h16v10a4 4 0 01-4 4H8a4 4 0 01-4-4V6z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'Coffee'        :'<path d="M6 4h12v8a6 6 0 01-12 0V4z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        '_default'      :'<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/>',
    };

    function pad2(n){ return n<10?'0'+n:''+n; }
    function ymd(y,m,d){ return y+'-'+pad2(m+1)+'-'+pad2(d); }
    function todayStr(){ var t=new Date(); return ymd(t.getFullYear(),t.getMonth(),t.getDate()); }
    function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
    function fmtLkr(v){ return v!=null?'<span class="wph-lkr-prefix">Rs</span>'+parseInt(v).toLocaleString():'<span class="wph-na">—</span>'; }
    function fmtUsd(v){ return v!=null?'<span class="wph-usd-prefix">$</span>'+parseFloat(v).toFixed(2):'<span class="wph-na">—</span>'; }

    var viewDate   = new Date(dates[0]+'T00:00:00');
    var activeDate = null;
    var td         = todayStr();

    function renderCal(){
        var y=viewDate.getFullYear(), m=viewDate.getMonth();
        monthLbl.textContent = MONTHS[m]+' '+y;
        var first=new Date(y,m,1).getDay(), days=new Date(y,m+1,0).getDate();
        var html=DOW.map(function(d){ return '<div class="wph-hcal-dow">'+d+'</div>'; }).join('');
        for(var i=0;i<first;i++) html+='<div class="wph-hcal-day"></div>';
        for(var d=1;d<=days;d++){
            var s=ymd(y,m,d);
            var cls='wph-hcal-day'+(dateSet[s]?' has-data':'')+(s===activeDate?' is-active':'')+(s===td?' is-today':'');
            html+='<div class="'+cls+'" data-date="'+s+'">'+d+'</div>';
        }
        grid.innerHTML=html;
        grid.querySelectorAll('.has-data').forEach(function(el){
            el.addEventListener('click',function(){ loadDate(el.dataset.date); });
        });
    }

    function setChip(date){
        chips.forEach(function(c){ c.classList.toggle('active', c.dataset.date===date); });
    }

    var CHEVRON = '<span class="wph-group-chevron" aria-hidden="true"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="6 9 12 15 18 9"/></svg></span>';

    function buildCards(rows, container){
        var map={}, order=[];
        rows.forEach(function(r){ if(!map[r.commodity]){map[r.commodity]=[];order.push(r.commodity);} map[r.commodity].push(r); });
        var html='';
        order.forEach(function(comm){
            var icon=ICONS[comm]||ICONS._default;
            var tbody=map[comm].map(function(r){
                return '<tr><td class="wph-td-grade">'+esc(r.grade)+'</td>'
                    +'<td class="wph-td-lkr">'+fmtLkr(r.price_lkr)+'</td>'
                    +'<td class="wph-td-usd">'+fmtUsd(r.price_usd)+'</td></tr>';
            }).join('');
            html+='<div class="wph-group-card">'
                +'<div class="wph-group-header"><div class="wph-group-title">'
                +'<div class="wph-group-icon"><svg width="12" height="12" viewBox="0 0 24 24">'+icon+'</svg></div>'
                +'<span class="wph-group-name">'+esc(comm)+'</span></div>'
                +'<div style="display:flex;align-items:center;gap:.5rem">'
                +'<span class="wph-group-count">'+map[comm].length+' grade'+(map[comm].length!==1?'s':'')+'</span>'
                +CHEVRON+'</div></div>'
                +'<div class="wph-group-table-wrap"><table class="wph-group-table">'
                +'<thead><tr><th style="width:46%">Grade / Type</th><th class="th-lkr" style="width:27%">LKR / kg</th><th class="th-usd" style="width:27%">USD / kg</th></tr></thead>'
                +'<tbody>'+tbody+'</tbody></table></div></div>';
        });
        container.innerHTML=html;
        initAccordion(container);
    }

    function initAccordion(container){
        container.querySelectorAll('.wph-group-header').forEach(function(header){
            header.addEventListener('click', function(){
                var card = header.closest('.wph-group-card');
                if(card) card.classList.toggle('is-collapsed');
            });
        });
    }

    function loadDate(dateStr){
        if(dateStr===activeDate) return;
        activeDate=dateStr; setChip(dateStr); renderCal();
        overlay.classList.add('visible');
        fetch('/wholesale-prices/by-date?date='+encodeURIComponent(dateStr),{
            headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
        })
        .then(function(r){return r.json();})
        .then(function(rows){
            overlay.classList.remove('visible');
            var d=new Date(dateStr+'T00:00:00');
            var label=d.getDate()+' '+MONTHS[d.getMonth()]+' '+d.getFullYear();
            histMeta.innerHTML=
                '<div class="wph-hist-date-badge">'
                +'<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'
                +label+'</div>'
                +'<span class="wph-hist-item-count">'+rows.length+' item'+(rows.length!==1?'s':'')+'</span>';
            buildCards(rows, histGrps);
            histEmpty.style.display='none';
            histPanel.style.display='block';
        })
        .catch(function(){ overlay.classList.remove('visible'); });
    }

    prevBtn.addEventListener('click',function(){ viewDate.setMonth(viewDate.getMonth()-1); renderCal(); });
    nextBtn.addEventListener('click',function(){ viewDate.setMonth(viewDate.getMonth()+1); renderCal(); });
    chips.forEach(function(chip){
        chip.addEventListener('click',function(){
            var d=chip.dataset.date;
            if(d){ viewDate=new Date(d+'T00:00:00'); loadDate(d); }
        });
    });

    renderCal();
    if(dates.length) loadDate(dates[0]);

    // Init accordion on static (blade-rendered) price cards
    var staticGroups = document.getElementById('wphGroups');
    if(staticGroups) initAccordion(staticGroups);
})();
</script>

@endsection
