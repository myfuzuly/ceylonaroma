@extends('layouts.admin')
@section('title', 'Settings')
@section('breadcrumb') <span>Settings</span> @endsection

@section('content')
<div class="page-title">Site Settings</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">

        {{-- General --}}
        <div class="form-card">
            <div class="form-section-title">General</div>
            <div class="f-group">
                <label class="f-label">Site Name</label>
                <input type="text" name="site_name" class="f-control" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            <div class="f-group">
                <label class="f-label">Tagline</label>
                <input type="text" name="site_tagline" class="f-control" value="{{ $settings['site_tagline'] ?? '' }}">
            </div>
            <div class="f-group">
                <label class="f-label">Meta Description</label>
                <textarea name="meta_description" class="f-control" rows="2">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>
            <div class="f-group">
                <label class="f-label">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="f-control" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="spices, tea, coffee, sri lanka">
            </div>
        </div>

        {{-- Contact --}}
        <div class="form-card">
            <div class="form-section-title">Contact Information</div>
            <div class="f-group">
                <label class="f-label">Email</label>
                <input type="email" name="site_email" class="f-control" value="{{ $settings['site_email'] ?? '' }}">
            </div>
            <div class="f-group">
                <label class="f-label">Phone</label>
                <input type="text" name="site_phone" class="f-control" value="{{ $settings['site_phone'] ?? '' }}">
            </div>
            <div class="f-group">
                <label class="f-label">Address</label>
                <textarea name="site_address" class="f-control" rows="2">{{ $settings['site_address'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- Stats --}}
        <div class="form-card">
            <div class="form-section-title">Homepage Stats</div>
            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Countries Served</label>
                    <input type="text" name="stat_countries" class="f-control" value="{{ $settings['stat_countries'] ?? '60+' }}" placeholder="60+">
                </div>
                <div class="f-group">
                    <label class="f-label">Products</label>
                    <input type="text" name="stat_products" class="f-control" value="{{ $settings['stat_products'] ?? '500+' }}" placeholder="500+">
                </div>
            </div>
            <div class="f-group">
                <label class="f-label">Years Experience</label>
                <input type="text" name="stat_years" class="f-control" value="{{ $settings['stat_years'] ?? '15+' }}" placeholder="15+">
            </div>
        </div>

        {{-- Social --}}
        <div class="form-card">
            <div class="form-section-title">Social Media Links</div>
            @foreach(['facebook_url'=>'Facebook','instagram_url'=>'Instagram','linkedin_url'=>'LinkedIn','youtube_url'=>'YouTube'] as $key => $label)
            <div class="f-group">
                <label class="f-label">{{ $label }}</label>
                <input type="url" name="{{ $key }}" class="f-control" value="{{ $settings[$key] ?? '' }}" placeholder="https://">
            </div>
            @endforeach
        </div>

    </div>

    <div style="margin-top:1.25rem;display:flex;justify-content:flex-end">
        <button type="submit" class="a-btn a-btn-primary" style="padding:.75rem 2rem">Save Settings</button>
    </div>
</form>
@endsection
