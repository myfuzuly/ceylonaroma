@extends('layouts.admin')
@section('title', isset($slider->id) ? 'Edit Slide' : 'New Slide')
@section('breadcrumb')
    <a href="{{ route('admin.sliders.index') }}" style="color:var(--a-muted)">Hero Slider</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ isset($slider->id) ? 'Edit Slide' : 'New Slide' }}</span>
@endsection

@section('content')
<div class="page-title">{{ isset($slider->id) ? 'Edit Slide' : 'Add Slide' }}</div>

<form action="{{ isset($slider->id) ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($slider->id)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Image upload --}}
            <div class="form-card">
                <div class="form-section-title">Slide Image *</div>
                <div class="img-upload-zone" id="uploadZone" style="min-height:200px">
                    <input type="file" name="image" accept="image/*" id="imageInput" class="iuz-input"
                           {{ isset($slider->id) ? '' : 'required' }}>
                    @if(isset($slider->id) && $slider->image)
                        <img src="{{ asset('storage/'.$slider->image) }}" id="img-preview" class="iuz-preview-cover" style="width:100%">
                        <div class="iuz-overlay">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Click or drag to replace
                        </div>
                    @else
                        <div class="iuz-placeholder" id="uploadHint">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.4"><rect x="3" y="3" width="18" height="14" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span class="iuz-placeholder-text">Click or drag to upload</span>
                            <span class="f-hint">JPG, PNG, WebP — max 4 MB — 1920×900px recommended</span>
                        </div>
                        <img id="img-preview" style="display:none;width:100%" class="iuz-preview-cover">
                    @endif
                </div>
            </div>

            {{-- Caption text --}}
            <div class="form-card">
                <div class="form-section-title">Caption Text <span style="font-weight:400;color:var(--a-muted)">(optional overlay on slide)</span></div>
                <div class="f-group">
                    <label class="f-label">Slide Title</label>
                    <input type="text" name="title" class="f-control"
                           value="{{ old('title', $slider->title ?? '') }}"
                           placeholder="e.g. Premium Ceylon Cinnamon">
                </div>
                <div class="f-group" style="margin-top:.9rem">
                    <label class="f-label">Subtitle</label>
                    <input type="text" name="subtitle" class="f-control"
                           value="{{ old('subtitle', $slider->subtitle ?? '') }}"
                           placeholder="e.g. Sourced from the finest farms in Sri Lanka">
                </div>
            </div>

            {{-- Link --}}
            <div class="form-card">
                <div class="form-section-title">Click-through Link <span style="font-weight:400;color:var(--a-muted)">(optional)</span></div>
                <div class="f-group">
                    <label class="f-label">URL</label>
                    <input type="url" name="link" class="f-control"
                           value="{{ old('link', $slider->link ?? '') }}"
                           placeholder="https://...">
                    <p style="font-size:.72rem;color:var(--a-muted);margin:.4rem 0 0">If set, the slide image becomes a clickable link.</p>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <div class="form-section-title">Visibility</div>
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="status" value="1"
                               {{ old('status', $slider->status ?? true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span>Active (show on homepage)</span>
                </div>
            </div>

            <div class="form-card">
                <div class="form-section-title">Sort Order</div>
                <div class="f-group">
                    <label class="f-label">Order</label>
                    <input type="number" name="sort_order" class="f-control"
                           value="{{ old('sort_order', $slider->sort_order ?? 0) }}" min="0" max="99">
                    <p style="font-size:.72rem;color:var(--a-muted);margin:.4rem 0 0">Lower numbers appear first (0 = first).</p>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:.75rem">
                <button type="submit" class="a-btn a-btn-primary" style="justify-content:center">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ isset($slider->id) ? 'Save Changes' : 'Add Slide' }}
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="a-btn a-btn-ghost" style="justify-content:center">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
(function(){
    var zone    = document.getElementById('uploadZone');
    var input   = document.getElementById('imageInput');
    var preview = document.getElementById('img-preview');
    var hint    = document.getElementById('uploadHint');
    if(!zone || !input) return;

    function showPreview(src){
        preview.src = src;
        preview.style.display = '';
        if(hint) hint.style.display = 'none';
        if(!zone.querySelector('.iuz-overlay')){
            var ov = document.createElement('div');
            ov.className = 'iuz-overlay';
            ov.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Click or drag to replace';
            zone.appendChild(ov);
        }
    }

    input.addEventListener('change', function(){
        if(!input.files[0]) return;
        var r = new FileReader();
        r.onload = function(e){ showPreview(e.target.result); };
        r.readAsDataURL(input.files[0]);
    });

    zone.addEventListener('dragover', function(e){ e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', function(){ zone.classList.remove('drag-over'); });
    zone.addEventListener('drop', function(e){
        e.preventDefault();
        zone.classList.remove('drag-over');
        var files = e.dataTransfer && e.dataTransfer.files;
        if(files && files[0]){
            var r = new FileReader();
            r.onload = function(ev){ showPreview(ev.target.result); };
            r.readAsDataURL(files[0]);
            try{ var dt=new DataTransfer(); dt.items.add(files[0]); input.files=dt.files; }catch(ex){}
        }
    });
})();
</script>
@endpush
@endsection
