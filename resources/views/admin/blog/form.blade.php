@extends('layouts.admin')
@section('title', isset($post->id) ? 'Edit Post' : 'New Post')
@section('breadcrumb')
    <a href="{{ route('admin.blog.index') }}" style="color:var(--a-muted)">Blog</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>{{ isset($post->id) ? 'Edit' : 'New' }}</span>
@endsection

@section('content')
<div class="page-title">{{ isset($post->id) ? 'Edit Post' : 'New Post' }}</div>

<form action="{{ isset($post->id) ? route('admin.blog.update', $post) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($post->id)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem">

        {{-- Left: content --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <div class="f-group">
                    <label class="f-label">Title *</label>
                    <input type="text" name="title" class="f-control" value="{{ old('title', $post->title) }}" required>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label class="f-label">Category</label>
                        <input type="text" name="category" class="f-control" value="{{ old('category', $post->category) }}" placeholder="e.g. Import Guide">
                    </div>
                    <div class="f-group">
                        <label class="f-label">Published Date</label>
                        <input type="datetime-local" name="published_at" class="f-control" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="f-group">
                    <label class="f-label">Excerpt</label>
                    <textarea name="excerpt" class="f-control" rows="2" placeholder="Short summary shown on listing cards…">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>
                <div class="f-group">
                    <label class="f-label">Content</label>
                    <textarea name="content" class="f-control" rows="12" placeholder="Full article content…">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Right: sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Featured image upload zone --}}
            <div class="form-card">
                <div class="form-section-title">Featured Image</div>
                <div class="img-upload-zone" id="blogImgZone">
                    <input type="file" name="image" accept="image/*" id="blogImgInput" class="iuz-input">
                    @if(isset($post->id) && $post->image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($post->image, ['http', '/']) ? $post->image : asset('storage/'.$post->image) }}" id="img-preview" class="iuz-preview-cover">
                        <div class="iuz-overlay">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Replace Image
                        </div>
                    @else
                        <div class="iuz-placeholder" id="iuzPlaceholder">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.4"><rect x="3" y="3" width="18" height="14" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span class="iuz-placeholder-text">Click or drag to upload</span>
                            <span class="f-hint">JPG, PNG, WebP — max 2 MB</span>
                        </div>
                        <img id="img-preview" style="display:none" class="iuz-preview-cover">
                    @endif
                </div>
                @if(isset($post->id) && $post->image)
                <label class="iuz-remove-label">
                    <input type="checkbox" name="remove_image" value="1" id="removeImgCheck">
                    Remove current image
                </label>
                @endif
            </div>

            {{-- Status --}}
            <div class="form-card">
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="status" value="1" {{ old('status', $post->status ?? true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span>Published</span>
                </div>
            </div>

            <div style="display:flex;gap:.75rem">
                <button type="submit" class="a-btn a-btn-primary" style="flex:1;justify-content:center">
                    {{ isset($post->id) ? 'Save Changes' : 'Publish Post' }}
                </button>
                <a href="{{ route('admin.blog.index') }}" class="a-btn a-btn-ghost">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
(function(){
    var zone    = document.getElementById('blogImgZone');
    var input   = document.getElementById('blogImgInput');
    var preview = document.getElementById('img-preview');
    var pholder = document.getElementById('iuzPlaceholder');
    var rmCheck = document.getElementById('removeImgCheck');
    if(!zone || !input) return;

    function showPreview(src){
        preview.src = src;
        preview.style.display = '';
        preview.className = 'iuz-preview-cover';
        if(pholder) pholder.style.display = 'none';
        // ensure overlay exists
        if(!zone.querySelector('.iuz-overlay')){
            var ov = document.createElement('div');
            ov.className = 'iuz-overlay';
            ov.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Replace Image';
            zone.appendChild(ov);
        }
    }

    input.addEventListener('change', function(){
        if(!input.files[0]) return;
        var r = new FileReader();
        r.onload = function(e){ showPreview(e.target.result); };
        r.readAsDataURL(input.files[0]);
        if(rmCheck) rmCheck.checked = false;
    });

    // Drag & drop
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

    if(rmCheck){
        rmCheck.addEventListener('change', function(){
            if(rmCheck.checked){
                preview.style.display = 'none';
                if(pholder){ pholder.style.display = ''; }
            } else {
                if(preview.src) preview.style.display = '';
                if(pholder) pholder.style.display = 'none';
            }
        });
    }
})();
</script>
@endpush

@endsection
