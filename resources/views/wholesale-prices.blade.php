@extends('layouts.app')

@section('title', 'Wholesale Prices')
@section('meta_description', 'Daily wholesale price history for Ceylon Aroma export products — updated regularly with current market rates.')

@section('content')

<div class="products-hero">
    <div class="container">
        <h1>Wholesale Prices</h1>
        <p>Current wholesale rates for our export products, with a full price history browsable by date.</p>
    </div>
</div>

<section class="section wholesale-section">
    <div class="container">
        @if(count($history))
        @php $current = $history[0]; $past = array_slice($history, 1); @endphp

        {{-- ── Today's prices ── --}}
        <div class="wp-date-card wp-date-card-current reveal">
            <div class="wp-date-head wp-date-head-static">
                <div class="wp-date-heading">
                    <span class="wp-date-label">{{ $current['date']->format('l, d F Y') }}</span>
                    <span class="wp-date-badge">Current</span>
                </div>
                <span class="wp-date-count">{{ $current['items']->count() }} {{ Str::plural('product', $current['items']->count()) }}</span>
            </div>
            <div class="wholesale-table-wrap wp-date-table-wrap">
                <table class="wholesale-table">
                    <thead><tr><th>Product</th><th>Price</th></tr></thead>
                    <tbody>
                        @foreach($current['items'] as $wp)
                        <tr>
                            <td>
                                <div class="wholesale-product-cell">
                                    @if($wp->product?->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($wp->product->image, ['http','/']) ? $wp->product->image : asset('storage/'.$wp->product->image) }}" alt="{{ $wp->product->name }}" loading="lazy">
                                    @endif
                                    <a href="{{ route('products.show', $wp->product->slug) }}">{{ $wp->product->name }}</a>
                                </div>
                            </td>
                            <td class="wholesale-price">{{ $wp->currency }} {{ number_format($wp->price, 2) }} <span>/ {{ $wp->unit }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Price history calendar ── --}}
        @if(count($past))
        <div class="wp-history-section reveal reveal-delay-1">
            <div class="wp-history-head">
                <span class="section-label">Price Archive</span>
                <h2 class="wp-history-title">Browse Past Prices</h2>
                <p class="wp-history-sub">Select any highlighted date to view our wholesale rates on that day.</p>
            </div>

            <div class="wp-cal-wrap">
                <div class="wp-cal">
                    <div class="wp-cal-head">
                        <button type="button" class="wp-cal-nav" id="wpCalPrev" aria-label="Previous month">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <span class="wp-cal-month" id="wpCalMonth"></span>
                        <button type="button" class="wp-cal-nav" id="wpCalNext" aria-label="Next month">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                    <div class="wp-cal-dow">
                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                    </div>
                    <div class="wp-cal-grid" id="wpCalGrid"></div>
                    <p class="wp-cal-legend"><span class="wp-cal-dot"></span> Prices recorded on this date</p>
                </div>

                <div class="wp-cal-result" id="wpCalResult">
                    <div class="wp-cal-placeholder">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.4"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p>Pick a highlighted date on the calendar to see prices from that day.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <h3>No wholesale prices published yet</h3>
            <p>Check back soon, or contact us directly for current rates.</p>
            <a href="{{ route('contact') }}" class="btn btn-outline empty-state-btn">Contact Us</a>
        </div>
        @endif
    </div>
</section>

@if(count($history) && count($past))
<script>
(function(){
    var HISTORY = {
        @foreach($past as $entry)
        {!! json_encode($entry['date']->format('Y-m-d')) !!}: {
            label: {!! json_encode($entry['date']->format('l, d F Y')) !!},
            items: [
                @foreach($entry['items'] as $wp)
                {
                    name: {!! json_encode($wp->product->name ?? 'Product') !!},
                    slug: {!! json_encode($wp->product->slug ?? '') !!},
                    image: {!! json_encode($wp->product && $wp->product->image ? (\Illuminate\Support\Str::startsWith($wp->product->image, ['http','/']) ? $wp->product->image : asset('storage/'.$wp->product->image)) : null) !!},
                    price: {{ number_format($wp->price, 2, '.', '') }},
                    currency: {!! json_encode($wp->currency) !!},
                    unit: {!! json_encode($wp->unit) !!}
                },
                @endforeach
            ]
        },
        @endforeach
    };

    var dates = Object.keys(HISTORY).sort();
    var newestDate = new Date(dates[dates.length - 1] + 'T00:00:00');
    var viewYear = newestDate.getFullYear();
    var viewMonth = newestDate.getMonth();

    var monthEl  = document.getElementById('wpCalMonth');
    var gridEl   = document.getElementById('wpCalGrid');
    var resultEl = document.getElementById('wpCalResult');
    var prevBtn  = document.getElementById('wpCalPrev');
    var nextBtn  = document.getElementById('wpCalNext');
    var monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    function pad(n){ return n < 10 ? '0'+n : ''+n; }
    function key(y,m,d){ return y+'-'+pad(m+1)+'-'+pad(d); }

    function renderCalendar(){
        monthEl.textContent = monthNames[viewMonth] + ' ' + viewYear;
        gridEl.innerHTML = '';
        var firstDow = new Date(viewYear, viewMonth, 1).getDay();
        var daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
        for (var i = 0; i < firstDow; i++){
            var blank = document.createElement('span');
            blank.className = 'wp-cal-cell wp-cal-cell-blank';
            gridEl.appendChild(blank);
        }
        for (var d = 1; d <= daysInMonth; d++){
            var k = key(viewYear, viewMonth, d);
            var cell = document.createElement('button');
            cell.type = 'button';
            cell.className = 'wp-cal-cell';
            cell.textContent = d;
            if (HISTORY[k]){
                cell.classList.add('wp-cal-has-data');
                cell.addEventListener('click', (function(kk){
                    return function(){ selectDate(kk); };
                })(k));
            } else {
                cell.disabled = true;
            }
            gridEl.appendChild(cell);
        }
    }

    function selectDate(k){
        var data = HISTORY[k];
        if (!data) return;
        gridEl.querySelectorAll('.wp-cal-cell').forEach(function(c){ c.classList.remove('wp-cal-selected'); });
        gridEl.querySelectorAll('.wp-cal-has-data').forEach(function(c){
            if (c.textContent == parseInt(k.split('-')[2], 10)) c.classList.add('wp-cal-selected');
        });

        var rows = data.items.map(function(item){
            var img = item.image ? '<img src="'+item.image+'" alt="'+item.name+'" loading="lazy">' : '';
            var link = item.slug ? '/products/'+item.slug : '#';
            return '<tr><td><div class="wholesale-product-cell">'+img+'<a href="'+link+'">'+item.name+'</a></div></td>'
                 + '<td class="wholesale-price">'+item.currency+' '+item.price.toFixed(2)+' <span>/ '+item.unit+'</span></td></tr>';
        }).join('');

        resultEl.innerHTML =
            '<div class="wp-cal-result-head">' +
                '<span class="wp-date-label">'+data.label+'</span>' +
                '<span class="wp-date-count">'+data.items.length+' product'+(data.items.length===1?'':'s')+'</span>' +
            '</div>' +
            '<div class="wholesale-table-wrap wp-date-table-wrap"><table class="wholesale-table"><thead><tr><th>Product</th><th>Price</th></tr></thead><tbody>'+rows+'</tbody></table></div>';
    }

    prevBtn.addEventListener('click', function(){
        viewMonth--; if (viewMonth < 0){ viewMonth = 11; viewYear--; }
        renderCalendar();
    });
    nextBtn.addEventListener('click', function(){
        viewMonth++; if (viewMonth > 11){ viewMonth = 0; viewYear++; }
        renderCalendar();
    });

    renderCalendar();
    selectDate(dates[dates.length - 1]);
})();
</script>
@endif
@endsection
