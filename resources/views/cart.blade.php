@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<section class="cart-section">
    <div class="container">
        <h1 class="page-title">Your Cart</h1>

        @if(session('success'))
            <div class="auth-alert auth-alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
        @endif

        @if(empty($cart))
            <div class="cart-empty">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                <h2>Your cart is empty</h2>
                <p>Explore our premium Ceylon spices and add items to your cart.</p>
                <a href="{{ route('products.index') }}" class="btn btn-gold">Browse Products</a>
            </div>
        @else
            <div class="cart-layout">
                <div class="cart-items">
                    @foreach($cart as $item)
                    <div class="cart-item" id="cart-item-{{ $item['id'] }}">
                        <div class="cart-item-img-wrap">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-img">
                            @else
                                <div class="cart-item-img-placeholder">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <a href="{{ route('products.show', $item['slug']) }}" class="cart-item-name">{{ $item['name'] }}</a>
                            @if($item['category'])<span class="cart-item-cat">{{ $item['category'] }}</span>@endif
                        </div>
                        <div class="cart-item-qty">
                            <form method="POST" action="{{ route('cart.update') }}" class="qty-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <button type="button" class="qty-btn qty-dec" data-id="{{ $item['id'] }}">−</button>
                                <input type="number" name="quantity" value="{{ $item['qty'] }}" min="1" max="999"
                                       class="qty-input" data-id="{{ $item['id'] }}" onchange="this.form.submit()">
                                <button type="button" class="qty-btn qty-inc" data-id="{{ $item['id'] }}">+</button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('cart.remove') }}" class="cart-remove-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <button type="submit" class="cart-remove-btn" title="Remove">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 5,6 21,6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <div class="cart-summary-card">
                        <h3>Order Summary</h3>
                        <div class="cart-summary-row">
                            <span>{{ count($cart) }} item(s) in cart</span>
                        </div>
                        <div class="cart-summary-note">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                            Pricing and shipping discussed upon order confirmation. We'll contact you within 24 hours.
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-gold btn-block mt-3">Proceed to Checkout</a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline btn-block mt-2">Continue Shopping</a>

                        <form method="POST" action="{{ route('cart.clear') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="cart-clear-btn">Clear Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
document.querySelectorAll('.qty-dec').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.querySelector(`.qty-input[data-id="${btn.dataset.id}"]`);
        if (parseInt(input.value) > 1) { input.value = parseInt(input.value) - 1; input.form.submit(); }
    });
});
document.querySelectorAll('.qty-inc').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.querySelector(`.qty-input[data-id="${btn.dataset.id}"]`);
        if (parseInt(input.value) < 999) { input.value = parseInt(input.value) + 1; input.form.submit(); }
    });
});
</script>
@endsection
