@extends('layouts.admin')
@section('title', 'Menu Management')
@section('breadcrumb') <span>Menu Management</span> @endsection

@section('content')
<div class="page-title">
    Menu Management
</div>
<p style="margin:-1rem 0 1.5rem;font-size:.83rem;color:var(--a-muted)">Control which categories appear in the navigation mega menu and their order.</p>

<div style="display:grid;grid-template-columns:1fr 360px;gap:1.25rem;align-items:start">

    {{-- ── Section 1: Nav Categories ── --}}
    <div>
        <div class="form-card" style="padding:0;overflow:hidden">
            <div style="padding:1.1rem 1.25rem;border-bottom:1px solid var(--a-border);display:flex;align-items:center;justify-content:space-between;gap:1rem">
                <div>
                    <div style="font-size:.93rem;font-weight:700;color:var(--a-text)">Nav Categories</div>
                    <div style="font-size:.75rem;color:var(--a-muted);margin-top:.15rem">Drag to reorder. Toggle to show/hide in the mega menu.</div>
                </div>
                <button type="button" id="saveOrderBtn" class="a-btn a-btn-primary a-btn-sm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Save Order
                </button>
            </div>

            @if($categories->isEmpty())
            <div style="text-align:center;padding:3rem 2rem;color:var(--a-muted)">
                <p>No root categories found. <a href="{{ route('admin.categories.create') }}" style="color:var(--a-gold)">Create one</a>.</p>
            </div>
            @else
            <ul id="sortableMenu" style="list-style:none;margin:0;padding:.5rem 0">
                @foreach($categories as $cat)
                <li class="menu-row" data-id="{{ $cat->id }}">
                    <span class="menu-drag-handle" title="Drag to reorder">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </span>
                    <div class="menu-row-info">
                        <span class="menu-row-name">{{ $cat->name }}</span>
                        @if($cat->children_count > 0)
                        <span class="menu-children-badge">{{ $cat->children_count }} sub</span>
                        @endif
                    </div>
                    <div style="display:flex;align-items:center;gap:.75rem;margin-left:auto">
                        <span class="a-badge {{ $cat->status ? 'a-badge-success' : 'a-badge-muted' }}" style="font-size:.68rem">
                            {{ $cat->status ? 'Active' : 'Hidden' }}
                        </span>
                        <label class="nav-toggle" title="{{ $cat->show_in_nav ? 'Shown in nav' : 'Hidden from nav' }}">
                            <input type="checkbox" class="nav-toggle-input"
                                   data-id="{{ $cat->id }}"
                                   {{ $cat->show_in_nav ? 'checked' : '' }}>
                            <span class="nav-toggle-slider"></span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
        <p style="font-size:.73rem;color:var(--a-muted);margin-top:.6rem">
            Nav order is saved separately from Sort Order — changes here do not affect the product listing page.
        </p>
    </div>

    {{-- ── Section 2: Featured Panel ── --}}
    <div class="form-card">
        <div class="form-section-title" style="margin-bottom:1rem">Featured Panel</div>
        <form action="{{ route('admin.menu.featured') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="f-group">
                <label class="f-label">Title</label>
                <input type="text" name="nav_featured_title" class="f-control"
                       value="{{ old('nav_featured_title', $settings['nav_featured_title'] ?? '') }}"
                       placeholder="Seasonal Special">
            </div>
            <div class="f-group">
                <label class="f-label">Description</label>
                <textarea name="nav_featured_desc" class="f-control" rows="3"
                          placeholder="A short teaser shown in the mega menu...">{{ old('nav_featured_desc', $settings['nav_featured_desc'] ?? '') }}</textarea>
            </div>
            <div class="f-group">
                <label class="f-label">Link URL</label>
                <input type="url" name="nav_featured_url" class="f-control"
                       value="{{ old('nav_featured_url', $settings['nav_featured_url'] ?? '') }}"
                       placeholder="https://ceylonaroma.com/...">
            </div>
            <div class="f-group">
                <label class="f-label">Image <span style="font-weight:400;color:var(--a-muted)">(optional)</span></label>
                @php $featImg = $settings['nav_featured_image'] ?? null; @endphp
                @if($featImg)
                <div style="margin-bottom:.65rem;border-radius:8px;overflow:hidden;border:1px solid var(--a-border)">
                    <img src="{{ asset($featImg) }}" alt="Featured" style="width:100%;display:block;max-height:140px;object-fit:cover">
                </div>
                @endif
                <input type="file" name="nav_featured_image" class="f-control" accept="image/*" id="featImgInput">
                <small style="color:var(--a-muted);font-size:.72rem">JPG, PNG, WebP — max 2 MB. Leave empty to keep current image.</small>
                <div id="featImgPreview" style="margin-top:.5rem;display:none;border-radius:8px;overflow:hidden;border:1px solid var(--a-border)">
                    <img id="featImgPreviewImg" src="" alt="Preview" style="width:100%;display:block;max-height:140px;object-fit:cover">
                </div>
            </div>
            <button type="submit" class="a-btn a-btn-primary" style="width:100%;justify-content:center;margin-top:.5rem">
                Update Featured Panel
            </button>
        </form>
    </div>

</div>

<style>
.menu-row{
    display:flex;align-items:center;gap:.85rem;
    padding:.65rem 1.25rem;
    border-bottom:1px solid var(--a-border);
    transition:background .15s;
}
.menu-row:last-child{border-bottom:none}
.menu-row:hover{background:rgba(198,134,42,.04)}
.menu-row.drag-over{background:rgba(198,134,42,.08);box-shadow:inset 0 2px 0 #C8922A}
.menu-drag-handle{
    cursor:grab;color:var(--a-muted);flex-shrink:0;
    opacity:.55;transition:opacity .15s;
    display:flex;align-items:center;
}
.menu-drag-handle:hover{opacity:1}
.menu-row-info{display:flex;align-items:center;gap:.5rem;min-width:0}
.menu-row-name{font-size:.85rem;font-weight:600;color:var(--a-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px}
.menu-children-badge{
    background:rgba(198,134,42,.12);color:var(--a-gold,#C6862A);
    font-size:.67rem;font-weight:700;padding:.15rem .45rem;border-radius:20px;white-space:nowrap;flex-shrink:0
}

/* Nav toggle switch */
.nav-toggle{position:relative;display:inline-block;width:36px;height:20px;flex-shrink:0;cursor:pointer}
.nav-toggle-input{opacity:0;width:0;height:0;position:absolute}
.nav-toggle-slider{
    position:absolute;inset:0;border-radius:20px;
    background:var(--a-border);transition:background .2s;
}
.nav-toggle-slider::before{
    content:'';position:absolute;
    width:14px;height:14px;border-radius:50%;
    left:3px;top:3px;
    background:#fff;transition:transform .2s;
    box-shadow:0 1px 3px rgba(0,0,0,.25);
}
.nav-toggle-input:checked + .nav-toggle-slider{background:#34D399}
.nav-toggle-input:checked + .nav-toggle-slider::before{transform:translateX(16px)}

/* Status badges (fallback if not in admin.css) */
.a-badge{display:inline-flex;align-items:center;padding:.2rem .55rem;border-radius:20px;font-size:.72rem;font-weight:600;white-space:nowrap}
.a-badge-success{background:rgba(52,211,153,.12);color:#34D399}
.a-badge-muted{background:rgba(156,163,175,.12);color:var(--a-muted)}
</style>

@push('scripts')
<script>
(function(){
    /* ── Native drag-to-reorder ── */
    var list = document.getElementById('sortableMenu');
    var dragSrc = null;

    if(list){
        list.querySelectorAll('.menu-row').forEach(function(row){
            row.setAttribute('draggable','true');

            row.addEventListener('dragstart', function(e){
                dragSrc = row;
                setTimeout(function(){ row.style.opacity = '0.4'; }, 0);
                e.dataTransfer.effectAllowed = 'move';
            });
            row.addEventListener('dragend', function(){
                row.style.opacity = '';
                list.querySelectorAll('.menu-row').forEach(function(r){ r.classList.remove('drag-over'); });
            });
            row.addEventListener('dragover', function(e){
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });
            row.addEventListener('dragenter', function(e){
                e.preventDefault();
                if(row !== dragSrc) row.classList.add('drag-over');
            });
            row.addEventListener('dragleave', function(){
                row.classList.remove('drag-over');
            });
            row.addEventListener('drop', function(e){
                e.preventDefault();
                e.stopPropagation();
                if(dragSrc && dragSrc !== row){
                    var rect = row.getBoundingClientRect();
                    if(e.clientY < rect.top + rect.height / 2){
                        list.insertBefore(dragSrc, row);
                    } else {
                        list.insertBefore(dragSrc, row.nextSibling);
                    }
                }
                row.classList.remove('drag-over');
            });
        });
    }

    /* ── Save Order ── */
    var saveBtn = document.getElementById('saveOrderBtn');
    if(saveBtn){
        saveBtn.addEventListener('click', function(){
            var rows = list ? list.querySelectorAll('.menu-row') : [];
            var order = [];
            rows.forEach(function(r){ order.push(parseInt(r.dataset.id, 10)); });

            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving…';

            fetch('{{ route("admin.menu.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ order: order }),
            })
            .then(function(r){
                if(!r.ok) throw new Error(r.status);
                return r.json();
            })
            .then(function(){
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Saved!';
                showToast('Menu order saved successfully', 'success');
                setTimeout(function(){
                    saveBtn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Save Order';
                }, 2000);
            })
            .catch(function(){
                saveBtn.disabled = false;
                saveBtn.textContent = 'Error — try again';
                showToast('Failed to save order — try again', 'error');
            });
        });
    }

    /* ── Toggle show_in_nav ── */
    document.querySelectorAll('.nav-toggle-input').forEach(function(input){
        input.addEventListener('change', function(){
            var id = input.dataset.id;
            var newState = input.checked;
            var row = input.closest('li') || input.closest('[data-id]');
            var nameEl = row ? row.querySelector('.menu-row-name') : null;
            var label = nameEl ? nameEl.textContent.trim() : 'Category';

            fetch('/admin/menu/toggle/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(function(r){
                if(!r.ok) throw new Error(r.status);
                return r.json();
            })
            .then(function(data){
                input.checked = data.show_in_nav;
                showToast(label + (data.show_in_nav ? ' shown in nav' : ' hidden from nav'), 'success');
            })
            .catch(function(){
                input.checked = !newState;
                showToast('Failed to update — try again', 'error');
            });
        });
    });

    /* ── Featured panel — show toast on redirect-back success ── */
    @if(session('success'))
    showToast('{{ session('success') }}', 'success');
    @endif

    /* ── Featured image preview ── */
    var featInput   = document.getElementById('featImgInput');
    var featPreview = document.getElementById('featImgPreview');
    var featImg     = document.getElementById('featImgPreviewImg');
    if(featInput){
        featInput.addEventListener('change', function(){
            if(!featInput.files[0]) return;
            var r = new FileReader();
            r.onload = function(e){
                featImg.src = e.target.result;
                featPreview.style.display = '';
            };
            r.readAsDataURL(featInput.files[0]);
        });
    }
    /* ── Toast helper ── */
    function showToast(msg, type){
        var t = document.createElement('div');
        t.textContent = msg;
        t.style.cssText = [
            'position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999',
            'padding:.65rem 1.1rem;border-radius:8px;font-size:.83rem;font-weight:600',
            'box-shadow:0 4px 16px rgba(0,0,0,.18);pointer-events:none',
            'transition:opacity .35s',
            type === 'error'
                ? 'background:#ef4444;color:#fff'
                : 'background:#1A2A20;color:#C8922A;border:1px solid rgba(200,146,42,.3)',
        ].join(';');
        document.body.appendChild(t);
        setTimeout(function(){ t.style.opacity='0'; }, 2200);
        setTimeout(function(){ t.remove(); }, 2600);
    }
})();
</script>
@endpush
@endsection
