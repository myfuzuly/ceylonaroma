@extends('layouts.app')

@section('title', 'Submit Inquiry')

@section('content')
<section class="checkout-section">
    <div class="container">
        <h1 class="page-title">Submit Inquiry</h1>

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
                            <label for="co-name">Full Name *</label>
                            <input type="text" id="co-name" name="name" value="{{ old('name', $customer?->name) }}" required autocomplete="name"
                                   class="form-control @error('name') is-invalid @enderror" placeholder="John Smith">
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="co-email">Email Address *</label>
                            <input type="email" id="co-email" name="email" value="{{ old('email', $customer?->email) }}" required autocomplete="email"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="john@company.com">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="co-phone">Phone</label>
                            <input type="text" id="co-phone" name="phone" value="{{ old('phone', $customer?->phone) }}" autocomplete="tel"
                                   class="form-control" placeholder="+1 234 567 8900">
                        </div>
                        <div class="form-group">
                            <label for="co-company">Company</label>
                            <input type="text" id="co-company" name="company" value="{{ old('company', $customer?->company) }}" autocomplete="organization"
                                   class="form-control" placeholder="Your Company Ltd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="co-country">Country *</label>
                        <select id="co-country" name="country" required class="form-control @error('country') is-invalid @enderror">
                            <option value="">Select Country</option>
                            @include('partials.country-options', ['fieldName' => 'country', 'selected' => old('country', $customer?->country)])
                        </select>
                        @error('country')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="co-address">Shipping Address</label>
                        <textarea id="co-address" name="address" rows="3" class="form-control" placeholder="Street, City, State, ZIP" autocomplete="street-address">{{ old('address', $customer?->address) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="co-notes">Order Notes / Specifications</label>
                        <textarea id="co-notes" name="notes" rows="3" class="form-control" placeholder="Packaging requirements, certifications needed, delivery window, etc.">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Payment Method (PayHere hidden — inquiry only for now) --}}
                    <input type="hidden" name="payment_method" value="inquiry">

                    <div id="checkout-error" style="display:none;margin-top:.75rem;padding:.75rem 1rem;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:8px;color:#b91c1c;font-size:.875rem"></div>
                    <button type="submit" class="btn btn-gold btn-block mt-4" id="submit-btn">
                        Submit Inquiry
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

@push('scripts')
<script>
(function(){
    var btn = document.getElementById('submit-btn');
    document.getElementById('checkout-form').addEventListener('submit', function() {
        btn.disabled = true;
        btn.textContent = 'Submitting…';
    });
})();
</script>
@endpush
@endsection
