@extends('layouts.admin')
@section('title', isset($category->id) ? 'Edit Category' : 'New Category')
@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}" style="color:var(--a-muted)">Categories</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ isset($category->id) ? 'Edit' : 'New' }}</span>
@endsection

@section('content')
<div class="page-title">{{ isset($category->id) ? 'Edit Category' : 'Add Category' }}</div>

<form action="{{ isset($category->id) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category->id)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem">
        <div class="form-card">
            <div class="f-group">
                <label class="f-label">Name *</label>
                <input type="text" name="name" class="f-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="f-group">
                <label class="f-label">Description</label>
                <textarea name="description" class="f-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="f-group">
                <label class="f-label">Parent Category</label>
                <select name="parent_id" class="f-control">
                    <option value="">— None (Top Level / Main Category) —</option>
                    @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                    @endforeach
                </select>
                <small style="color:var(--a-muted);font-size:.73rem">Leave blank to make this a main category shown on the homepage.</small>
            </div>
            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Icon (Emoji)</label>
                    <input type="text" name="icon" class="f-control" value="{{ old('icon', $category->icon) }}" placeholder="🌿">
                </div>
                <div class="f-group">
                    <label class="f-label">Sort Order</label>
                    <input type="number" name="sort_order" class="f-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <div class="form-section-title">Category Image</div>
                <div class="img-upload-zone" id="imgZone">
                    <input type="file" name="image" accept="image/*" id="imgInput" class="iuz-input">
                    @if(isset($category->id) && $category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" id="img-preview" class="iuz-preview">
                        <div class="iuz-overlay">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Replace Image
                        </div>
                    @else
                        <div class="iuz-placeholder" id="iuzPlaceholder">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.4"><rect x="3" y="3" width="18" height="14" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span class="iuz-placeholder-text">Click or drag to upload</span>
                            <span class="f-hint">JPG, PNG, WebP — max 2 MB</span>
                        </div>
                        <img id="img-preview" style="display:none" class="iuz-preview">
                    @endif
                </div>
                @if(isset($category->id) && $category->image)
                <label class="iuz-remove-label">
                    <input type="checkbox" name="remove_image" value="1" id="removeImgCheck">
                    Remove current image
                </label>
                @endif
            </div>
            <div class="form-card">
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="status" value="1" {{ old('status', $category->status ?? true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span>Active</span>
                </div>
            </div>
            <div style="display:flex;gap:.75rem">
                <button type="submit" class="a-btn a-btn-primary" style="flex:1;justify-content:center">Save</button>
                <a href="{{ route('admin.categories.index') }}" class="a-btn a-btn-ghost">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
(function(){
    var zone=document.getElementById('imgZone'),input=document.getElementById('imgInput'),
        preview=document.getElementById('img-preview'),pholder=document.getElementById('iuzPlaceholder'),
        rmCheck=document.getElementById('removeImgCheck');
    if(!zone||!input)return;
    function showPreview(src){
        preview.src=src; preview.style.display=''; preview.className='iuz-preview';
        if(pholder)pholder.style.display='none';
        if(!zone.querySelector('.iuz-overlay')){
            var ov=document.createElement('div'); ov.className='iuz-overlay';
            ov.innerHTML='<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Replace Image';
            zone.appendChild(ov);
        }
    }
    input.addEventListener('change',function(){ if(!input.files[0])return; var r=new FileReader(); r.onload=function(e){showPreview(e.target.result);}; r.readAsDataURL(input.files[0]); if(rmCheck)rmCheck.checked=false; });
    zone.addEventListener('dragover',function(e){e.preventDefault();zone.classList.add('drag-over');});
    zone.addEventListener('dragleave',function(){zone.classList.remove('drag-over');});
    zone.addEventListener('drop',function(e){
        e.preventDefault();zone.classList.remove('drag-over');
        var files=e.dataTransfer&&e.dataTransfer.files;
        if(files&&files[0]){var r=new FileReader();r.onload=function(ev){showPreview(ev.target.result);};r.readAsDataURL(files[0]);try{var dt=new DataTransfer();dt.items.add(files[0]);input.files=dt.files;}catch(ex){}}
    });
    if(rmCheck)rmCheck.addEventListener('change',function(){if(rmCheck.checked){preview.style.display='none';if(pholder)pholder.style.display='';}else{if(preview.src)preview.style.display='';if(pholder)pholder.style.display='none';}});
})();
</script>
@endpush
@endsection
