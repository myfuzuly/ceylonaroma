@extends('layouts.app')

@section('title', 'My Wishlist')
@section('meta_description', 'Your saved products on Ceylon Aroma — premium Ceylon spices, teas and natural exports.')

@section('content')
<section class="wishlist-section">
    <div class="container">
        <h1 class="page-title">My Wishlist</h1>

        <div id="wishlist-empty" class="wishlist-empty wishlist-empty-hidden">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.2" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            <h2>Your wishlist is empty</h2>
            <p>Save products you love by clicking the heart icon on any product card.</p>
            <a href="{{ route('products.index') }}" class="btn btn-gold">Browse Products</a>
        </div>

        <div id="wishlist-grid" class="wishlist-grid"></div>
    </div>
</section>

<template id="wishlist-card-tpl">
    <article class="product-card">
        <div class="product-img-wrap">
            <a class="product-img-link wish-link">
                <div class="product-img">
                    <img class="wish-img" loading="lazy" alt="">
                </div>
            </a>
            <button type="button" class="product-wish wish-remove-btn" aria-label="Remove from wishlist" title="Remove from wishlist">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
        </div>
        <div class="product-body">
            <div class="product-category wish-cat"></div>
            <h3 class="product-name"><a class="wish-name-link"></a></h3>
            <div class="product-card-footer">
                <div class="product-card-btns wishlist-card-btns">
                    <a class="btn btn-gold btn-sm wish-quote-link">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Get Quote
                    </a>
                    <a class="btn btn-outline btn-sm wish-view-link">
                        View
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </article>
</template>

@push('scripts')
<script>
(function(){
    var wishKey = 'ca_wishlist';
    var grid    = document.getElementById('wishlist-grid');
    var empty   = document.getElementById('wishlist-empty');
    var tpl     = document.getElementById('wishlist-card-tpl');

    function getWish(){ try{ return JSON.parse(localStorage.getItem(wishKey)||'[]'); }catch{ return []; } }
    function saveWish(arr){ localStorage.setItem(wishKey, JSON.stringify(arr)); }

    function render(){
        var list = getWish();
        grid.innerHTML = '';
        if(!list.length){ empty.classList.remove('wishlist-empty-hidden'); grid.style.display='none'; return; }
        empty.classList.add('wishlist-empty-hidden');
        grid.style.display  = '';
        list.forEach(function(item){
            var node = tpl.content.cloneNode(true);
            var id   = typeof item === 'object' ? item.id   : item;
            var name = typeof item === 'object' ? item.name : 'Product';
            var slug = typeof item === 'object' ? item.slug : '';
            var img  = typeof item === 'object' ? item.image : '';
            var cat  = typeof item === 'object' ? item.category : '';
            var href = slug ? '/products/'+slug : '/products';

            node.querySelector('.wish-link').href = href;
            if(img){
                node.querySelector('.wish-img').src = img;
                node.querySelector('.wish-img').alt = name;
            } else {
                node.querySelector('.wish-img').parentElement.innerHTML = '<div class="product-img-placeholder"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.2" opacity=".5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg></div>';
            }
            if(cat) node.querySelector('.wish-cat').textContent = cat;
            node.querySelector('.wish-name-link').textContent = name;
            node.querySelector('.wish-name-link').href        = href;
            node.querySelector('.wish-quote-link').href = '/contact?product='+encodeURIComponent(name);
            node.querySelector('.wish-view-link').href  = href;
            var rmBtn = node.querySelector('.wish-remove-btn');
            rmBtn.dataset.id = id;
            rmBtn.addEventListener('click', function(){
                var w = getWish().filter(function(x){ return (typeof x==='object'?x.id:x) != String(id); });
                saveWish(w);
                render();
                /* sync badge elsewhere */
                document.querySelectorAll('.nav-wish-badge').forEach(function(b){ b.textContent = w.length || ''; b.style.display = w.length ? 'flex' : 'none'; });
            });
            grid.appendChild(node);
        });
    }

    render();
})();
</script>
@endpush
@endsection
