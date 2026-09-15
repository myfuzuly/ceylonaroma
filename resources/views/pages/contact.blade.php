@extends('layouts.app')

@section('title', 'Contact & Export Inquiry')
@section('meta_description', 'Contact Ceylon Aroma for export inquiries, product samples, and wholesale pricing. Based in Kegalle, Sri Lanka — serving importers in 60+ countries. Response within 24 hours.')

@section('content')

<div class="contact-hero">
    <div class="container">
        <span class="section-label contact-hero-label">Get in Touch</span>
        <h1>Export Inquiry</h1>
        <p>Send us your requirements and our team will respond with a personalised quote within 24 hours.</p>
    </div>
</div>

<section class="form-section">
    <div class="container">
        <div class="form-grid">

            {{-- ── Form ── --}}
            <div class="form-card">
                <h3 class="form-card-title">Send Your Requirements</h3>

                @if(session('success'))
                <div class="alert alert-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">
                    <ul class="alert-list">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('inquiry.store') }}" method="POST" id="inquiry-form" novalidate>
                    @csrf
                    {{-- Honeypot — bots fill this, humans don't --}}
                    <div style="position:absolute;left:-9999px;top:-9999px;opacity:0;height:0;overflow:hidden" aria-hidden="true" tabindex="-1">
                        <input type="text" name="_pot" autocomplete="nope" tabindex="-1" value="">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Your full name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="you@company.com">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone / WhatsApp</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+94 71 XXX XXXX">
                        </div>
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}" placeholder="Your company">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country *</label>
                        <select id="country" name="country" class="form-control" required>
                            <option value="">Select your country</option>
                            @include('partials.country-options', ['fieldName' => 'country', 'selected' => old('country')])
                        </select>
                    </div>

                    {{-- Products of interest — main categories as pill checkboxes --}}
                    @if($categories->count())
                    <fieldset class="form-fieldset">
                        <legend class="form-fieldset legend">Products of Interest</legend>
                        <div class="cat-pill-group">
                            @foreach($categories as $cat)
                            <label class="cat-pill">
                                <input type="checkbox" name="products[]" value="{{ $cat->name }}"
                                    {{ in_array($cat->name, old('products', request('product') ? [request('product')] : [])) ? 'checked' : '' }}>
                                <span>{{ $cat->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </fieldset>
                    @endif

                    <div class="form-group">
                        <label for="message">Your Requirements *</label>
                        <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Describe the products you need, quantities, packaging requirements, destination…">{{ old('message') }}</textarea>
                    </div>

                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                    <button type="submit" class="btn btn-primary btn-submit-full" id="inquiry-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Send Inquiry
                    </button>
                    <p class="recaptcha-notice">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.</p>
                </form>
            </div>

            {{-- ── Info sidebar ── --}}
            <div class="contact-sidebar">

                <div class="contact-info-card">
                    <h4 class="contact-card-title">Contact Details</h4>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Address</strong>
                            <span>{{ $settings['site_address'] ?? 'No: F – 05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka' }}</span>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.09 3h3a2 2 0 012 1.72c.127.96.36 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 11a16 16 0 006.91 6.91l1.27-1.27a2 2 0 012.11-.45c.907.34 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Mobile / WhatsApp</strong>
                            <span><a href="tel:+{{ $settings['phone_whatsapp'] ?? '94712930930' }}" class="contact-tel">+94 712 930 930</a> (WhatsApp)</span>
                            <span><a href="tel:+{{ $settings['phone_hotline'] ?? '94713930930' }}" class="contact-tel">+94 713 930 930</a> (Sales Hotline)</span>
                            <span class="contact-tel-sub">Landline: <a href="tel:+94352234433" class="contact-tel">+94 35 223 4433</a></span>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Email</strong>
                            <a href="mailto:{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}" class="contact-tel">{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}</a>
                        </div>
                    </div>
                    <a href="https://wa.me/{{ $settings['phone_whatsapp'] ?? '94712930930' }}" target="_blank" rel="noopener" class="whatsapp-cta-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat on WhatsApp
                    </a>
                </div>

                <div class="contact-info-card contact-info-card-parchment">
                    <h4 class="contact-card-title">Our Commitment</h4>
                    <ul class="contact-promise-list">
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Quotes within <strong>24 hours</strong>
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Samples dispatched in <strong>3–5 days</strong>
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Full export documentation
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Custom packaging available
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            ISO 22000 &amp; HACCP certified
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- Map --}}
<section class="map-section">
    <div class="container">
        <div class="map-embed-wrap">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.5!2d80.3392055!3d7.2523383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae31700244cfb57%3A0xbb8ad2c3b6373572!2sCEYLON+AROMA+COMMODITIES+EXPORTS+(PRIVATE)+LIMITED!5e0!3m2!1sen!2slk!4v1724000000000!5m2!1sen!2slk"
                width="100%" height="360" style="border:0;display:block"
                allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Ceylon Aroma Commodities — Kegalle, Sri Lanka">
            </iframe>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
<script>
(function(){
    var form = document.getElementById('inquiry-form');
    var btn = document.getElementById('inquiry-submit-btn');
    if (!form) return;
    form.addEventListener('submit', function(e){
        if (form.dataset.recaptchaDone === '1') return; // token already attached, let it submit
        e.preventDefault();
        btn.classList.add('btn-loading');
        btn.disabled = true;
        grecaptcha.ready(function(){
            grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'inquiry'}).then(function(token){
                document.getElementById('recaptcha_token').value = token;
                form.dataset.recaptchaDone = '1';
                form.submit();
            });
        });
    });
})();
</script>
@endpush

@endsection
