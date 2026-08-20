@extends('layouts.app')
@section('title', 'Privacy Policy')
@section('meta_description', 'Privacy Policy for Ceylon Aroma Commodities Exports (Private) Limited — how we collect, use and protect your personal information.')

@section('content')
<div class="contact-hero">
    <div class="container">
        <span class="section-label contact-hero-label">Legal</span>
        <h1>Privacy Policy</h1>
        <p>Last updated: {{ date('d F Y') }}</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:820px">
        <div class="blog-content" style="color:var(--ink)">

            <h2>1. Introduction</h2>
            <p>Ceylon Aroma Commodities Exports (Private) Limited ("Ceylon Aroma", "we", "us", or "our"), registered in Sri Lanka, operates the website <strong>ceylonaroma.com</strong>. This Privacy Policy explains how we collect, use, disclose and safeguard your personal information when you visit our website or submit an export inquiry.</p>

            <h2>2. Information We Collect</h2>
            <p>We may collect the following personal information:</p>
            <ul>
                <li><strong>Contact information</strong> — name, email address, phone number, company name and country when you submit an inquiry or create an account.</li>
                <li><strong>Order information</strong> — products requested, quantities, shipping destination and payment details when you place an order.</li>
                <li><strong>Technical data</strong> — IP address, browser type, pages visited and time spent, collected automatically via server logs and cookies.</li>
            </ul>

            <h2>3. How We Use Your Information</h2>
            <p>Your information is used to:</p>
            <ul>
                <li>Respond to your export inquiries and provide quotations</li>
                <li>Process and fulfil orders</li>
                <li>Send transactional emails (order confirmations, shipping updates)</li>
                <li>Improve our website and services</li>
                <li>Comply with legal obligations</li>
            </ul>
            <p>We do <strong>not</strong> sell, rent or share your personal information with third parties for marketing purposes.</p>

            <h2>4. Cookies</h2>
            <p>We use essential cookies to maintain your session and shopping cart. We do not use tracking or advertising cookies. You may disable cookies in your browser settings; however, some features of the website may not function correctly.</p>

            <h2>5. Data Retention</h2>
            <p>We retain your personal information for as long as necessary to fulfil the purposes outlined above, or as required by applicable law. Inquiry records are retained for up to 3 years. Account data is retained until you request deletion.</p>

            <h2>6. Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access the personal information we hold about you</li>
                <li>Request correction of inaccurate data</li>
                <li>Request deletion of your personal data</li>
                <li>Object to or restrict processing of your data</li>
            </ul>
            <p>To exercise any of these rights, please contact us at <a href="mailto:info@ceylonaroma.com" style="color:var(--forest)">info@ceylonaroma.com</a>.</p>

            <h2>7. Security</h2>
            <p>We implement appropriate technical and organisational measures to protect your personal information against unauthorised access, alteration, disclosure or destruction. All data is transmitted over HTTPS (TLS encryption).</p>

            <h2>8. International Transfers</h2>
            <p>As an export company serving clients worldwide, your data may be processed on servers located outside your country. We ensure that appropriate safeguards are in place in accordance with applicable data protection laws.</p>

            <h2>9. Contact Us</h2>
            <p>For any privacy-related questions or requests, please contact:</p>
            <p>
                <strong>Ceylon Aroma Commodities Exports (Pvt) Ltd</strong><br>
                No: F – 05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka<br>
                Email: <a href="mailto:info@ceylonaroma.com" style="color:var(--forest)">info@ceylonaroma.com</a><br>
                Phone: <a href="tel:+94718821234" style="color:var(--forest)">+94 71 882 1234</a>
            </p>

            <h2>10. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. The updated version will be indicated by the "Last updated" date at the top of this page. Continued use of our website after any changes constitutes acceptance of the updated policy.</p>

        </div>
    </div>
</section>
@endsection
