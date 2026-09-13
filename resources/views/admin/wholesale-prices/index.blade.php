@extends('layouts.admin')
@section('title', 'Wholesale Prices')
@section('breadcrumb') <span>Wholesale Prices</span> @endsection

@section('content')
<div class="page-title">
    Wholesale Prices
</div>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(198,134,42,.12);color:var(--a-accent)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $rows->count() }}</div>
            <div class="stat-card-label">Products Priced</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(96,165,250,.12);color:var(--a-blue)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $lastUpdated ? $lastUpdated->format('d M') : '—' }}</div>
            <div class="stat-card-label">Last Updated</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(52,211,153,.12);color:var(--a-green)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        </div>
        <div>
            <div class="stat-card-num">{{ $products->count() - $rows->count() }}</div>
            <div class="stat-card-label">Not Yet Priced</div>
        </div>
    </div>
</div>

<div class="form-card" style="margin-bottom:1.5rem" id="wp-form-card">
    <div class="form-section-title" id="wp-form-title">Update Today's Price</div>
    <form action="{{ route('admin.wholesale-prices.store') }}" method="POST" class="wp-form">
        @csrf
        <div class="f-group wp-combo-wrap">
            <label class="f-label">Product *</label>
            <input type="hidden" name="product_id" id="wp-product-id" required>
            <input type="text" id="wp-product-search" class="f-control" placeholder="Search product…" autocomplete="off">
            <div class="wp-combo-list" id="wp-combo-list"></div>
        </div>
        <div class="f-group">
            <label class="f-label">Price *</label>
            <input type="number" name="price" id="wp-price" class="f-control" step="0.01" min="0" placeholder="0.00" required>
        </div>
        <div class="f-group">
            <label class="f-label">Currency</label>
            <select name="currency" id="wp-currency" class="f-select">
                <option value="USD">USD</option>
                <option value="LKR">LKR</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select>
        </div>
        <div class="f-group">
            <label class="f-label">Unit</label>
            <select name="unit" id="wp-unit" class="f-select">
                <option value="kg">per kg</option>
                <option value="g">per g</option>
                <option value="mt">per metric ton</option>
                <option value="lb">per lb</option>
                <option value="unit">per unit</option>
            </select>
        </div>
        <button type="submit" class="a-btn a-btn-primary">Save Price</button>
    </form>
    <p class="wp-form-hint">Saving a price never deletes the old one — every update is kept as history under that product.</p>
</div>

<div class="wp-tabs">
    <button type="button" class="wp-tab wp-tab-active" data-view="wp-view-product">By Product</button>
    <button type="button" class="wp-tab" data-view="wp-view-date">By Date</button>
</div>

<div id="wp-view-product">
<div class="filter-bar">
    <div class="f-search-wrap">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="wp-table-search" placeholder="Search product…">
    </div>
</div>

<div class="table-wrap">
    <div class="table-scroll">
        <table id="wp-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Price</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                @php $wp = $row['current']; $product = $row['product']; @endphp
                <tr data-product-name="{{ strtolower($product->name) }}" class="wp-row">
                    <td>
                        <div class="td-name" style="display:flex;align-items:center;gap:.6rem">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="td-img" alt="">
                            @else
                                <div class="td-img-placeholder">📦</div>
                            @endif
                            <strong>{{ $product->name }}</strong>
                        </div>
                    </td>
                    <td class="wp-price-cell">{{ $wp->currency }} {{ number_format($wp->price, 2) }} <span style="color:var(--a-muted);font-weight:400">/ {{ $wp->unit }}</span></td>
                    <td style="color:var(--a-muted)">{{ $wp->updated_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="a-btn-icon wp-edit-btn" title="Update this product's price"
                                    data-id="{{ $product->id }}" data-price="{{ $wp->price }}"
                                    data-currency="{{ $wp->currency }}" data-unit="{{ $wp->unit }}"
                                    data-name="{{ $product->name }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form action="{{ route('admin.wholesale-prices.destroy', $wp) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Remove the current price for '{{ $product->name }}'? Older history for this product will stay.">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;padding:3rem;color:var(--a-muted)">No wholesale prices set yet. Use the form above to add one.</td></tr>
                @endforelse
            </tbody>
        </table>
        <p id="wp-no-match" class="wp-form-hint" style="display:none;padding:1.5rem;text-align:center">No products match your search.</p>
    </div>
</div>
</div>

<div id="wp-view-date" hidden>
    @if($byDate->count())
    <div class="wp-cal-wrap wp-cal-wrap-admin">
        <div class="wp-cal">
            <div class="wp-cal-head">
                <button type="button" class="wp-cal-nav" id="wpAdminCalPrev" aria-label="Previous month">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <span class="wp-cal-month" id="wpAdminCalMonth"></span>
                <button type="button" class="wp-cal-nav" id="wpAdminCalNext" aria-label="Next month">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
            <div class="wp-cal-dow">
                <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
            </div>
            <div class="wp-cal-grid" id="wpAdminCalGrid"></div>
            <p class="wp-cal-legend"><span class="wp-cal-dot"></span> Prices updated on this date</p>
        </div>

        <div class="wp-cal-result" id="wpAdminCalResult">
            @foreach($byDate as $date => $records)
            <div class="wp-cal-panel" data-date="{{ $date }}" @if(!$loop->first) hidden @endif>
                <div class="wp-cal-result-head">
                    <span class="wp-date-label">{{ \Illuminate\Support\Carbon::parse($date)->format('l, d F Y') }}</span>
                    <span class="wp-date-count">{{ $records->count() }} {{ Str::plural('update', $records->count()) }}</span>
                </div>
                <table class="wp-hist-table wp-date-group-table">
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Time</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($records as $wp)
                        <tr>
                            <td>
                                <div class="td-name" style="display:flex;align-items:center;gap:.5rem">
                                    @if($wp->product?->image)
                                        <img src="{{ asset('storage/'.$wp->product->image) }}" class="td-img" style="width:32px;height:32px" alt="">
                                    @endif
                                    {{ $wp->product->name ?? 'Deleted product' }}
                                </div>
                            </td>
                            <td>{{ $wp->currency }} {{ number_format($wp->price, 2) }} / {{ $wp->unit }}</td>
                            <td style="color:var(--a-muted)">{{ $wp->updated_at->format('h:i A') }}</td>
                            <td>
                                <div class="action-group">
                                    @if($wp->product)
                                    <button type="button" class="a-btn-icon wp-edit-btn" title="Reuse this price as a starting point"
                                            data-id="{{ $wp->product_id }}" data-price="{{ $wp->price }}"
                                            data-currency="{{ $wp->currency }}" data-unit="{{ $wp->unit }}"
                                            data-name="{{ $wp->product->name }}">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    @endif
                                    <form action="{{ route('admin.wholesale-prices.destroy', $wp) }}" method="POST" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="a-btn-icon" style="background:rgba(248,113,113,.1);color:var(--a-red)" data-confirm="Delete this price record for '{{ $wp->product->name ?? 'this product' }}'?">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="table-wrap"><p style="text-align:center;padding:3rem;color:var(--a-muted)">No wholesale prices recorded yet.</p></div>
    @endif
</div>

<script>
(function(){
    var PRODUCTS = [
        @foreach($products as $product)
        {id: {{ $product->id }}, name: {!! json_encode($product->name) !!}},
        @endforeach
    ];

    /* ── Searchable product combobox (form) ── */
    var searchInput = document.getElementById('wp-product-search');
    var hiddenId     = document.getElementById('wp-product-id');
    var list         = document.getElementById('wp-combo-list');

    function renderList(query){
        var q = query.trim().toLowerCase();
        var matches = q ? PRODUCTS.filter(function(p){ return p.name.toLowerCase().indexOf(q) !== -1; }) : PRODUCTS;
        list.innerHTML = '';
        if (!matches.length){
            list.innerHTML = '<div class="wp-combo-empty">No products found</div>';
        } else {
            matches.slice(0, 50).forEach(function(p){
                var opt = document.createElement('div');
                opt.className = 'wp-combo-opt';
                opt.textContent = p.name;
                opt.addEventListener('click', function(){
                    hiddenId.value = p.id;
                    searchInput.value = p.name;
                    list.classList.remove('open');
                });
                list.appendChild(opt);
            });
        }
        list.classList.add('open');
    }

    searchInput.addEventListener('input', function(){
        hiddenId.value = '';
        renderList(searchInput.value);
    });
    searchInput.addEventListener('focus', function(){ renderList(searchInput.value); });
    document.addEventListener('click', function(e){
        if (!e.target.closest('.wp-combo-wrap')) list.classList.remove('open');
    });

    /* ── Edit buttons prefill the combobox too ── */
    document.querySelectorAll('.wp-edit-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            hiddenId.value       = btn.dataset.id;
            searchInput.value    = btn.dataset.name;
            document.getElementById('wp-price').value    = btn.dataset.price;
            document.getElementById('wp-currency').value = btn.dataset.currency;
            document.getElementById('wp-unit').value      = btn.dataset.unit;
            document.getElementById('wp-form-title').textContent = 'Update Price — ' + btn.dataset.name;
            document.getElementById('wp-form-card').scrollIntoView({behavior:'smooth', block:'start'});
            document.getElementById('wp-price').focus();
        });
    });

    /* ── Live search/filter on the product list ── */
    var tableSearch = document.getElementById('wp-table-search');
    var mainRows = Array.prototype.slice.call(document.querySelectorAll('#wp-table tbody tr.wp-row'));
    var noMatch = document.getElementById('wp-no-match');
    tableSearch.addEventListener('input', function(){
        var q = tableSearch.value.trim().toLowerCase();
        var visible = 0;
        mainRows.forEach(function(row){
            var match = row.dataset.productName.indexOf(q) !== -1;
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        noMatch.style.display = (mainRows.length && !visible) ? '' : 'none';
    });

    /* ── By Product / By Date tabs ── */
    document.querySelectorAll('.wp-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            document.querySelectorAll('.wp-tab').forEach(function(t){ t.classList.remove('wp-tab-active'); });
            tab.classList.add('wp-tab-active');
            document.getElementById('wp-view-product').hidden = tab.dataset.view !== 'wp-view-product';
            document.getElementById('wp-view-date').hidden = tab.dataset.view !== 'wp-view-date';
        });
    });

    /* ── By Date calendar ── */
    var calGrid = document.getElementById('wpAdminCalGrid');
    if (calGrid) {
        var panels = Array.prototype.slice.call(document.querySelectorAll('#wpAdminCalResult .wp-cal-panel'));
        var DATES = panels.map(function(p){ return p.dataset.date; });

        var newest = new Date(DATES[0] + 'T00:00:00');
        var viewYear = newest.getFullYear();
        var viewMonth = newest.getMonth();

        var monthEl = document.getElementById('wpAdminCalMonth');
        var prevBtn = document.getElementById('wpAdminCalPrev');
        var nextBtn = document.getElementById('wpAdminCalNext');
        var monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        function pad(n){ return n < 10 ? '0'+n : ''+n; }
        function key(y,m,d){ return y+'-'+pad(m+1)+'-'+pad(d); }

        function renderCal(){
            monthEl.textContent = monthNames[viewMonth] + ' ' + viewYear;
            calGrid.innerHTML = '';
            var firstDow = new Date(viewYear, viewMonth, 1).getDay();
            var daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
            for (var i = 0; i < firstDow; i++){
                var blank = document.createElement('span');
                blank.className = 'wp-cal-cell wp-cal-cell-blank';
                calGrid.appendChild(blank);
            }
            for (var d = 1; d <= daysInMonth; d++){
                var k = key(viewYear, viewMonth, d);
                var cell = document.createElement('button');
                cell.type = 'button';
                cell.className = 'wp-cal-cell';
                cell.textContent = d;
                if (DATES.indexOf(k) !== -1){
                    cell.classList.add('wp-cal-has-data');
                    if (DATES.indexOf(k) === 0) cell.classList.add('wp-cal-selected');
                    cell.addEventListener('click', (function(kk){ return function(){ selectDate(kk); }; })(k));
                } else {
                    cell.disabled = true;
                }
                calGrid.appendChild(cell);
            }
        }

        function selectDate(k){
            panels.forEach(function(p){ p.hidden = p.dataset.date !== k; });
            calGrid.querySelectorAll('.wp-cal-cell').forEach(function(c){ c.classList.remove('wp-cal-selected'); });
            calGrid.querySelectorAll('.wp-cal-has-data').forEach(function(c){
                var d = viewYear+'-'+pad(viewMonth+1)+'-'+pad(parseInt(c.textContent,10));
                if (d === k) c.classList.add('wp-cal-selected');
            });
        }

        prevBtn.addEventListener('click', function(){
            viewMonth--; if (viewMonth < 0){ viewMonth = 11; viewYear--; }
            renderCal();
        });
        nextBtn.addEventListener('click', function(){
            viewMonth++; if (viewMonth > 11){ viewMonth = 0; viewYear++; }
            renderCal();
        });

        renderCal();
    }
})();
</script>
@endsection
