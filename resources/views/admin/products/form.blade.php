@extends('layouts.admin')

@section('title', isset($product->id) ? 'Edit Product' : 'New Product')

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" style="color:var(--a-muted)">Products</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ isset($product->id) ? 'Edit' : 'New' }}</span>
@endsection

@section('content')

<div class="page-title">{{ isset($product->id) ? 'Edit Product' : 'Add Product' }}</div>

<form action="{{ isset($product->id) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product->id)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start">
        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <div class="form-section-title">Product Details</div>
                <div class="f-group">
                    <label class="f-label">Product Name *</label>
                    <input type="text" name="name" class="f-control" value="{{ old('name', $product->name) }}" required placeholder="e.g. Ceylon Cinnamon Quills">
                </div>
                <div class="f-group">
                    <label class="f-label">Short Description</label>
                    <textarea name="short_description" class="f-control" rows="2" placeholder="Brief description for listings">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
                <div class="f-group">
                    <label class="f-label">Full Description</label>
                    <textarea name="description" class="f-control" rows="6" placeholder="Detailed product description, origin, specs…">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <div class="form-section-title">Image</div>
                <div class="f-group">
                    <label class="f-label">Product Image</label>
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" id="img-preview" class="img-preview">
                    @else
                        <div class="img-preview-placeholder" id="img-preview-placeholder">🌿</div>
                        <img id="img-preview" class="img-preview" style="display:none">
                    @endif
                    <input type="file" name="image" accept="image/*" data-preview="img-preview" style="margin-top:.5rem;font-size:.8rem;color:var(--a-muted)">
                    <span class="f-hint">JPG, PNG, WebP — max 4MB, auto-converted to WebP</span>
                </div>
            </div>

            <div class="form-card">
                <div class="form-section-title">Category & Order</div>
                <div class="f-group">
                    <label class="f-label">Category</label>
                    <select name="category_id" class="f-control">
                        <option value="">— No Category —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Sort Order</label>
                    <input type="number" name="sort_order" class="f-control" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0">
                </div>
            </div>

            <div class="form-card">
                <div class="form-section-title">Flags</div>
                <div class="checkbox-group">
                    @foreach(['is_featured'=>'Featured','is_bestseller'=>'Best Seller','is_new_arrival'=>'New Arrival','is_export_ready'=>'Export Ready'] as $key => $label)
                    <label class="a-checkbox">
                        <input type="checkbox" name="{{ $key }}" value="1" {{ old($key, $product->$key) ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-card">
                <div class="form-section-title">Status</div>
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="status" value="1" {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="f-hint">Published</span>
                </div>
            </div>

            <div style="display:flex;gap:.75rem">
                <button type="submit" class="a-btn a-btn-primary" style="flex:1;justify-content:center">
                    {{ isset($product->id) ? 'Save Changes' : 'Create Product' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="a-btn a-btn-ghost">Cancel</a>
            </div>
        </div>
    </div>
</form>

@endsection
