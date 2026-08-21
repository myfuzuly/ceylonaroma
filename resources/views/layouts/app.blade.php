@include('layouts.app-top')

{{-- Toast container --}}
<div id="toast-container" aria-live="polite" aria-atomic="false"></div>
<div id="page-progress"></div>

{{-- Flash → toast (auto-fired via JS below) --}}
@if(session('success'))
<div data-flash="success" data-msg="{{ session('success') }}" style="display:none"></div>
@endif
@if(session('error'))
<div data-flash="error" data-msg="{{ session('error') }}" style="display:none"></div>
@endif

<main id="main-content">
@yield('content')
</main>
@include('layouts.app-foot')

<script>
(function(){
    /* ── Toast system ── */
    var ICONS = {
        success:'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
        error  :'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning:'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info   :'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };

    window.showToast = function(msg, type, duration) {
        type = type || 'success';
        duration = duration || 4000;
        var c = document.getElementById('toast-container');
        var t = document.createElement('div');
        t.className = 'toast toast-' + type;
        t.setAttribute('role', 'alert');
        t.innerHTML =
            '<span class="toast-icon">' + (ICONS[type] || ICONS.info) + '</span>' +
            '<span class="toast-msg">' + msg + '</span>' +
            '<button class="toast-close" aria-label="Dismiss">&times;</button>';
        c.appendChild(t);

        function dismiss() {
            t.classList.add('toast-out');
            t.addEventListener('animationend', function(){ if(t.parentNode) t.parentNode.removeChild(t); }, {once:true});
        }
        t.querySelector('.toast-close').addEventListener('click', dismiss);
        setTimeout(dismiss, duration);
    };

    /* Auto-fire PHP flash messages */
    document.querySelectorAll('[data-flash]').forEach(function(el){
        window.showToast(el.dataset.msg, el.dataset.flash);
    });

    /* ── Page progress bar ── */
    var bar = document.getElementById('page-progress');
    if (bar) {
        document.addEventListener('click', function(e){
            var a = e.target.closest('a');
            if (a && a.href && !a.href.startsWith('#') && !a.href.startsWith('javascript') &&
                a.target !== '_blank' && a.getAttribute('href') !== '#') {
                bar.style.transform = 'scaleX(.4)';
                setTimeout(function(){ bar.style.transform = 'scaleX(.7)'; }, 200);
            }
        });
        window.addEventListener('pageshow', function(){
            bar.style.transform = 'scaleX(1)';
            setTimeout(function(){ bar.style.transition = 'opacity .3s'; bar.style.opacity = '0'; }, 300);
            setTimeout(function(){ bar.style.transform = 'scaleX(0)'; bar.style.transition = 'transform .25s ease'; bar.style.opacity = '1'; }, 700);
        });
    }

    /* ── Global AJAX add-to-cart ── */
    window.ajaxAddToCart = function(form, btn) {
        btn.classList.add('is-adding');
        var data = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
            body: data
        })
        .then(function(r){ return r.json(); })
        .then(function(json) {
            btn.classList.remove('is-adding');
            btn.classList.add('is-added');
            var orig = btn.innerHTML;
            btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Added';
            setTimeout(function(){ btn.classList.remove('is-added'); btn.innerHTML = orig; }, 2000);
            /* update nav cart badge */
            document.querySelectorAll('.cart-count,.cart-badge').forEach(function(el){
                el.textContent = json.count;
                if (json.count > 0) {
                    el.classList.remove('nav-cart-badge-hidden');
                    el.style.display = '';
                } else {
                    el.style.display = 'none';
                }
            });
            window.showToast(json.message || 'Added to cart', 'success');
        })
        .catch(function(){
            btn.classList.remove('is-adding');
            window.showToast('Could not add to cart. Please try again.', 'error');
        });
    };
})();
</script>
