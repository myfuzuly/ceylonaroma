@extends('layouts.admin')
@section('title', 'Commodity Prices')
@section('breadcrumb') <span>Commodity Prices</span> @endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
    <div>
        <div class="page-title" style="margin-bottom:.25rem">Commodity Prices</div>
        <p style="font-size:.8rem;color:var(--a-muted);margin:0">Prices repeat daily — publish today's list to record a new snapshot. Toggle the eye to hide/show a row on the public page.</p>
    </div>
    @if($todayCount > 0)
    <span style="background:rgba(52,211,153,.12);color:#34D399;font-size:.75rem;font-weight:700;padding:.35rem .85rem;border-radius:20px;border:1px solid rgba(52,211,153,.25)">
        ✓ Today's prices published ({{ $todayCount }} items)
    </span>
    @else
    <span style="background:rgba(251,191,36,.1);color:#FBBF24;font-size:.75rem;font-weight:700;padding:.35rem .85rem;border-radius:20px;border:1px solid rgba(251,191,36,.25)">
        Not yet published today
    </span>
    @endif
</div>

{{-- Stats --}}
<div class="stats-row" style="margin-bottom:1.5rem">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(198,134,42,.12);color:var(--a-accent)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $totalCount }}</div>
            <div class="stat-card-label">Commodities Tracked</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(96,165,250,.12);color:var(--a-blue)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M') : '—' }}</div>
            <div class="stat-card-label">Last Published</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(52,211,153,.12);color:var(--a-green)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $historyDates->count() }}</div>
            <div class="stat-card-label">Historical Snapshots</div>
        </div>
    </div>
</div>

{{-- Tabs --}}
<div class="wp-tabs" style="margin-bottom:1.5rem">
    <button type="button" class="wp-tab wp-tab-active" data-view="cp-edit-view">Edit Prices</button>
    <button type="button" class="wp-tab" data-view="cp-history-view">Price History</button>
</div>

{{-- ── Edit Prices Tab ── --}}
<div id="cp-edit-view">
<div class="form-card" style="padding:0;overflow:hidden">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--a-border);display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
        <div>
            <div style="font-size:.93rem;font-weight:700;color:var(--a-text)">Today's Price List</div>
            <div style="font-size:.75rem;color:var(--a-muted);margin-top:.15rem">Pre-filled with the most recent prices. Toggle
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                to hide a row from the public page.
            </div>
        </div>
        <div style="display:flex;gap:.65rem;align-items:center">
            <span style="font-size:.72rem;color:var(--a-muted)">Publishing for: <strong style="color:var(--a-text)">{{ \Carbon\Carbon::parse($todayDate)->format('d M Y') }}</strong></span>
            <button type="submit" form="cp-bulk-form" class="a-btn a-btn-primary a-btn-sm">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Publish Today's Prices
            </button>
        </div>
    </div>

    <form id="cp-bulk-form" action="{{ route('admin.commodity-prices.bulk-update') }}" method="POST">
        @csrf
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:.82rem">
                <thead>
                    <tr style="background:var(--a-bg-alt,rgba(0,0,0,.03))">
                        <th style="padding:.6rem 1rem;text-align:left;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);font-weight:700;border-bottom:1px solid var(--a-border);white-space:nowrap">Commodity</th>
                        <th style="padding:.6rem 1rem;text-align:left;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);font-weight:700;border-bottom:1px solid var(--a-border)">Grade / Type</th>
                        <th style="padding:.6rem 1rem;text-align:right;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);font-weight:700;border-bottom:1px solid var(--a-border);white-space:nowrap">LKR / kg</th>
                        <th style="padding:.6rem 1rem;text-align:right;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);font-weight:700;border-bottom:1px solid var(--a-border);white-space:nowrap">USD / kg</th>
                        <th style="padding:.6rem 1rem;text-align:center;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);font-weight:700;border-bottom:1px solid var(--a-border);white-space:nowrap" title="Visible on public page">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($grouped as $commodity => $rows)
                    @foreach($rows as $row)
                    @php $isFirst = $row === $rows->first(); $rowspan = $rows->count(); @endphp
                    <tr class="cp-row{{ $isFirst ? ' cp-group-first' : '' }}" data-visible="{{ $row->is_visible ? '1' : '0' }}"
                        style="{{ $isFirst ? 'border-top:2px solid var(--a-border)' : '' }}{{ !$row->is_visible ? ';opacity:.45' : '' }}">
                        @if($isFirst)
                        <td rowspan="{{ $rowspan }}" style="padding:.6rem 1rem;font-weight:700;color:var(--a-text);vertical-align:top;border-right:1px solid var(--a-border);white-space:nowrap;font-size:.82rem">
                            {{ $commodity }}
                        </td>
                        @endif
                        <td style="padding:.45rem 1rem;color:var(--a-muted);border-bottom:1px solid rgba(0,0,0,.04)">{{ $row->grade }}</td>
                        <td style="padding:.45rem .75rem;border-bottom:1px solid rgba(0,0,0,.04)">
                            <input type="hidden" name="rows[{{ $i }}][commodity]" value="{{ $row->commodity }}">
                            <input type="hidden" name="rows[{{ $i }}][grade]" value="{{ $row->grade }}">
                            <input type="hidden" name="rows[{{ $i }}][sort_order]" value="{{ $row->sort_order }}">
                            <input type="number" name="rows[{{ $i }}][price_lkr]"
                                   value="{{ $row->price_lkr !== null ? (float)$row->price_lkr : '' }}"
                                   step="0.01" min="0" placeholder="—"
                                   class="cp-price-input cp-lkr-input"
                                   style="width:100%;max-width:110px;text-align:right;padding:.3rem .5rem;border:1px solid var(--a-border);border-radius:5px;background:var(--a-surface);color:var(--a-text);font-size:.82rem;font-family:inherit">
                        </td>
                        <td style="padding:.45rem .75rem;border-bottom:1px solid rgba(0,0,0,.04)">
                            <input type="number" name="rows[{{ $i }}][price_usd]"
                                   value="{{ $row->price_usd !== null ? (float)$row->price_usd : '' }}"
                                   step="0.0001" min="0" placeholder="—"
                                   class="cp-price-input cp-usd-input"
                                   style="width:100%;max-width:90px;text-align:right;padding:.3rem .5rem;border:1px solid var(--a-border);border-radius:5px;background:var(--a-surface);color:var(--a-text);font-size:.82rem;font-family:inherit">
                        </td>
                        <td style="padding:.45rem .75rem;border-bottom:1px solid rgba(0,0,0,.04);text-align:center">
                            <input type="hidden" name="rows[{{ $i }}][is_visible]" value="0">
                            <label class="cp-vis-toggle" title="{{ $row->is_visible ? 'Visible — click to hide' : 'Hidden — click to show' }}">
                                <input type="checkbox" name="rows[{{ $i }}][is_visible]" value="1"
                                       class="cp-vis-cb"{{ $row->is_visible ? ' checked' : '' }}>
                                <span class="cp-vis-icon">
                                    {{-- eye open --}}
                                    <svg class="cp-eye-on" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    {{-- eye closed --}}
                                    <svg class="cp-eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                </span>
                            </label>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--a-border);display:flex;justify-content:space-between;align-items:center;gap:.65rem;flex-wrap:wrap">
            <p style="font-size:.72rem;color:var(--a-muted);margin:0">Leave a price blank to show <strong>—</strong> on the public page. Hidden rows (
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                ) do not appear on the public page.
            </p>
            <button type="submit" class="a-btn a-btn-primary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Publish Today's Prices
            </button>
        </div>
    </form>
</div>
</div>

{{-- ── History Tab ── --}}
<div id="cp-history-view" hidden>
@if($historyDates->count())
<div style="display:grid;grid-template-columns:220px 1fr;gap:1.25rem;align-items:start">
    <div class="form-card" style="padding:0;overflow:hidden;max-height:600px;overflow-y:auto">
        <div style="padding:.75rem 1rem;border-bottom:1px solid var(--a-border);font-size:.78rem;font-weight:700;color:var(--a-text)">Price Snapshots</div>
        <ul style="list-style:none;margin:0;padding:.35rem 0">
            @foreach($historyDates as $hd)
            <li>
                <button type="button" class="cp-hist-date-btn{{ $loop->first ? ' active' : '' }}"
                        data-date="{{ $hd->price_date instanceof \Carbon\Carbon ? $hd->price_date->format('Y-m-d') : $hd->price_date }}"
                        style="width:100%;text-align:left;padding:.55rem 1rem;background:none;border:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-size:.8rem;border-left:2px solid transparent;transition:all .15s;color:var(--a-text)">
                    <span>{{ $hd->price_date instanceof \Carbon\Carbon ? $hd->price_date->format('d M Y') : \Carbon\Carbon::parse($hd->price_date)->format('d M Y') }}</span>
                    <span style="background:rgba(198,134,42,.1);color:var(--a-accent);font-size:.67rem;font-weight:700;padding:.1rem .45rem;border-radius:20px">{{ $hd->total }}</span>
                </button>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="form-card" id="cp-hist-detail" style="padding:0;overflow:hidden">
        <div style="padding:.85rem 1.25rem;border-bottom:1px solid var(--a-border);display:flex;align-items:center;justify-content:space-between">
            <span id="cp-hist-title" style="font-weight:700;font-size:.88rem;color:var(--a-text)">Select a date</span>
            <span id="cp-hist-count" style="font-size:.72rem;color:var(--a-muted)"></span>
        </div>
        <div id="cp-hist-body" style="overflow-x:auto">
            <div style="text-align:center;padding:3rem;color:var(--a-muted);font-size:.82rem">Click a date to view its prices.</div>
        </div>
    </div>
</div>
@else
<div class="form-card" style="text-align:center;padding:3rem">
    <p style="color:var(--a-muted)">No price history yet. Publish today's prices to start tracking.</p>
</div>
@endif
</div>

<style>
.cp-price-input:focus{outline:none;border-color:var(--a-accent,#C6862A);box-shadow:0 0 0 2px rgba(198,134,42,.15)}
.cp-hist-date-btn:hover{background:rgba(198,134,42,.05);border-left-color:rgba(198,134,42,.4)}
.cp-hist-date-btn.active{background:rgba(198,134,42,.08);border-left-color:var(--a-accent,#C6862A);font-weight:600;color:var(--a-accent,#C6862A)}
/* visibility toggle */
.cp-vis-toggle{cursor:pointer;display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;transition:background .15s}
.cp-vis-toggle:hover{background:rgba(0,0,0,.07)}
.cp-vis-cb{position:absolute;opacity:0;width:0;height:0}
/* default = checked = visible */
.cp-vis-toggle .cp-eye-on{display:block;color:var(--a-accent,#C6862A)}
.cp-vis-toggle .cp-eye-off{display:none;color:var(--a-muted)}
/* when unchecked (hidden) */
.cp-vis-cb:not(:checked) ~ .cp-vis-icon .cp-eye-on{display:none}
.cp-vis-cb:not(:checked) ~ .cp-vis-icon .cp-eye-off{display:block}
tr[data-visible="0"]{opacity:.45}
</style>

@push('scripts')
<script>
(function(){
    /* ── Tab switch ── */
    document.querySelectorAll('.wp-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            document.querySelectorAll('.wp-tab').forEach(function(t){ t.classList.remove('wp-tab-active'); });
            tab.classList.add('wp-tab-active');
            document.getElementById('cp-edit-view').hidden    = tab.dataset.view !== 'cp-edit-view';
            document.getElementById('cp-history-view').hidden = tab.dataset.view !== 'cp-history-view';
        });
    });

    /* ── Visibility toggle: dim row on uncheck ── */
    document.querySelectorAll('.cp-vis-cb').forEach(function(cb){
        cb.addEventListener('change', function(){
            var row = cb.closest('tr');
            if (row) row.style.opacity = cb.checked ? '1' : '.45';
        });
    });

    /* ── History date picker ── */
    var histBtns  = document.querySelectorAll('.cp-hist-date-btn');
    var histTitle = document.getElementById('cp-hist-title');
    var histCount = document.getElementById('cp-hist-count');
    var histBody  = document.getElementById('cp-hist-body');

    function loadDate(btn) {
        histBtns.forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        var date = btn.dataset.date;
        histTitle.textContent = btn.querySelector('span:first-child').textContent;
        histBody.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--a-muted)">Loading…</div>';

        fetch('{{ route("admin.commodity-prices.history") }}?date=' + date, {
            headers: {'Accept': 'application/json'}
        })
        .then(function(r){ return r.json(); })
        .then(function(rows){
            histCount.textContent = rows.length + ' items';
            if (!rows.length) {
                histBody.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--a-muted)">No records for this date.</div>';
                return;
            }
            var prev = null;
            var html = '<table style="width:100%;border-collapse:collapse;font-size:.82rem"><thead><tr style="background:rgba(0,0,0,.03)"><th style="padding:.5rem 1rem;text-align:left;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);border-bottom:1px solid var(--a-border)">Commodity</th><th style="padding:.5rem 1rem;text-align:left;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);border-bottom:1px solid var(--a-border)">Grade</th><th style="padding:.5rem 1rem;text-align:right;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);border-bottom:1px solid var(--a-border)">LKR</th><th style="padding:.5rem 1rem;text-align:right;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--a-muted);border-bottom:1px solid var(--a-border)">USD</th></tr></thead><tbody>';
            rows.forEach(function(row){
                var borderStyle = (prev && prev !== row.commodity) ? 'border-top:2px solid var(--a-border)' : 'border-top:1px solid rgba(0,0,0,.04)';
                var lkr = row.price_lkr ? parseInt(row.price_lkr).toLocaleString() : '—';
                var usd = row.price_usd ? parseFloat(row.price_usd).toFixed(2) : '—';
                html += '<tr style="' + borderStyle + '"><td style="padding:.45rem 1rem;font-weight:600">' + row.commodity + '</td><td style="padding:.45rem 1rem;color:var(--a-muted)">' + row.grade + '</td><td style="padding:.45rem 1rem;text-align:right;font-variant-numeric:tabular-nums">' + lkr + '</td><td style="padding:.45rem 1rem;text-align:right;font-variant-numeric:tabular-nums">' + usd + '</td></tr>';
                prev = row.commodity;
            });
            html += '</tbody></table>';
            histBody.innerHTML = html;
        })
        .catch(function(){
            histBody.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--a-red)">Failed to load. Try again.</div>';
        });
    }

    if (histBtns.length) {
        histBtns.forEach(function(btn){
            btn.addEventListener('click', function(){ loadDate(btn); });
        });
        loadDate(histBtns[0]);
    }
})();
</script>
@endpush
@endsection
