@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="checkout-section">
    <div class="container">
        <h1 class="page-title">Checkout</h1>

        @if(session('error'))
            <div class="auth-alert auth-alert-error">{{ session('error') }}</div>
        @endif

        <div class="checkout-layout">
            {{-- Form --}}
            <div class="checkout-form-wrap">
                @if(!session('customer_id'))
                    <div class="checkout-login-prompt">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        <span>Have an account? <a href="{{ route('customer.login') }}">Sign in</a> to autofill your details.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                    @csrf

                    <div class="checkout-section-title">Contact & Shipping</div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $customer?->name) }}" required
                                   class="form-control @error('name') is-invalid @enderror" placeholder="John Smith">
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', $customer?->email) }}" required
                                   class="form-control @error('email') is-invalid @enderror" placeholder="john@company.com">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $customer?->phone) }}"
                                   class="form-control" placeholder="+1 234 567 8900">
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" value="{{ old('company', $customer?->company) }}"
                                   class="form-control" placeholder="Your Company Ltd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Country *</label>
                        <select name="country" required class="form-control @error('country') is-invalid @enderror">
                            <option value="">Select Country</option>
                            @foreach(['United States','United Kingdom','Canada','Australia','Germany','France','Netherlands','Japan','China','India','UAE','Saudi Arabia','Singapore','Sri Lanka','Other'] as $c)
                                <option value="{{ $c }}" {{ old('country', $customer?->country) == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        @error('country')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Shipping Address</label>
                        <textarea name="address" rows="3" class="form-control" placeholder="Street, City, State, ZIP">{{ old('address', $customer?->address) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Order Notes / Specifications</label>
                        <textarea name="notes" rows="3" class="form-control" placeholder="Packaging requirements, certifications needed, delivery window, etc.">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Payment Method --}}
                    <div class="checkout-section-title mt-4">Payment Method</div>
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="inquiry" checked>
                            <div class="payment-option-body">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                <div>
                                    <strong>Send Inquiry</strong>
                                    <small>Place order as a quote request — we'll contact you within 24 hours with pricing</small>
                                </div>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="payhere">
                            <div class="payment-option-body">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                <div>
                                    <strong>Pay Online (PayHere)</strong>
                                    <small>Secure card or bank payment via PayHere — Sri Lanka's trusted payment gateway</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-gold btn-block mt-4" id="submit-btn">
                        Place Order
                    </button>
                </form>
            </div>

            {{-- Cart Summary --}}
            <div class="checkout-summary">
                <div class="cart-summary-card">
                    <h3>Order Summary</h3>
                    @foreach($cart as $item)
                    <div class="checkout-item-row">
                        <span class="checkout-item-name">{{ $item['name'] }}</span>
                        <span class="checkout-item-qty">× {{ $item['qty'] }}</span>
                    </div>
                    @endforeach
                    <div class="checkout-summary-divider"></div>
                    <div class="checkout-total-row">
                        <span>{{ count($cart) }} item(s)</span>
                        <span class="checkout-total-note">Price on request</span>
                    </div>
                    <p class="checkout-note-text">Pricing is discussed post-submission based on your requirements and quantity.</p>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline btn-block mt-3">← Edit Cart</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    if (method === 'payhere') {
        e.preventDefault();
        submitPayhere();
    }
});

function submitPayhere() {
    const form = document.getElementById('checkout-form');
    const data = new FormData(form);

    fetch('{{ route("checkout.payhere.init") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: data
    })
    .then(r => r.json())
    .then(json => {
        if (json.error) { alert(json.error); return; }
        // Build PayHere form and submit
        const ph = document.createElement('form');
        ph.method = 'POST';
        ph.action = json.checkout_url;
        Object.entries(json.fields).forEach(([k, v]) => {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = k; inp.value = v;
            ph.appendChild(inp);
        });
        document.body.appendChild(ph);
        ph.submit();
    })
    .catch(() => alert('Payment initiation failed. Please try again.'));
}
</script>
@endsection
