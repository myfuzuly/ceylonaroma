<div style="display:grid;grid-template-columns:1fr 340px;gap:1.25rem;align-items:start">

    {{-- ── Left column ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- Basic Info --}}
        <div class="form-card">
            <div class="form-section-title">Product Details</div>
            <div style="display:grid;grid-template-columns:1fr 160px;gap:.75rem">
                <div class="f-group">
                    <label class="f-label">Product Name *</label>
                    <input type="text" name="name" class="f-control" value="{{ old('name', $product->name ?? '') }}" required placeholder="e.g. Ceylon Cinnamon Quills">
                </div>
                <div class="f-group">
                    <label class="f-label">SKU</label>
                    <input type="text" name="sku" class="f-control" value="{{ old('sku', $product->sku ?? '') }}" placeholder="CA-CIN-001">
                </div>
            </div>
            <div class="f-group">
                <label class="f-label">Short Description</label>
                <textarea name="short_description" class="f-control" rows="2" placeholder="Brief description shown on listing cards">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>
            <div class="f-group">
                <label class="f-label">Full Description</label>
                <textarea name="description" class="f-control" rows="6" placeholder="Detailed product description, uses, grades, etc.">{{ old('description', $product->description ?? '') }}</textarea>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="form-card">
            <div class="form-section-title">Pricing</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
                <div class="f-group">
                    <label class="f-label">Unit Price</label>
                    <input type="number" name="price" class="f-control" step="0.01" min="0"
                           value="{{ old('price', $product->price ?? '') }}" placeholder="0.00">
                    <span class="f-hint">Leave blank = "Price on Request"</span>
                </div>
                <div class="f-group">
                    <label class="f-label">Price Per</label>
                    <select name="price_unit" class="f-control">
                        @php $pu = old('price_unit', $product->price_unit ?? 'kg'); @endphp
                        @foreach(['kg','lb','ton','g','unit','box','bag','litre'] as $u)
                            <option value="{{ $u }}" {{ $pu === $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Currency</label>
                    <select name="currency" class="f-control">
                        @php $cur = old('currency', $product->currency ?? 'USD'); @endphp
                        @foreach(['USD','EUR','GBP','AUD','CAD','LKR'] as $c)
                            <option value="{{ $c }}" {{ $cur === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:.75rem">
                <div class="f-group">
                    <label class="f-label">Min. Order Qty</label>
                    <input type="number" name="min_order_qty" class="f-control" step="0.01" min="0"
                           value="{{ old('min_order_qty', $product->min_order_qty ?? '') }}" placeholder="e.g. 100">
                </div>
                <div class="f-group">
                    <label class="f-label">MOQ Unit</label>
                    <select name="min_order_unit" class="f-control">
                        @php $mu = old('min_order_unit', $product->min_order_unit ?? 'kg'); @endphp
                        @foreach(['kg','lb','ton','g','units','boxes','bags'] as $u)
                            <option value="{{ $u }}" {{ $mu === $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Price Variants --}}
        <div class="form-card">
            <div class="form-section-title" style="display:flex;align-items:center;justify-content:space-between">
                Price Variants
                <button type="button" id="add-variant" class="a-btn a-btn-ghost" style="padding:.3rem .75rem;font-size:.72rem">
                    + Add Variant
                </button>
            </div>
            <p style="font-size:.78rem;color:var(--a-muted);margin-bottom:1rem">Optional. Add size/grade variants with individual prices and images (e.g. 1kg Pack, 5kg Pack). Leave empty to use the single price above.</p>
            <div id="variants-list">
                @php $variants = old('variants', $product->variants ?? []); @endphp
                @forelse($variants as $vi => $variant)
                <div class="variant-row" data-index="{{ $vi }}">
                    <div class="variant-row-header">
                        <span class="variant-row-num">Variant {{ $vi + 1 }}</span>
                        <button type="button" class="remove-variant" title="Remove">✕</button>
                    </div>
                    <div class="variant-fields">
                        <div class="f-group">
                            <label class="f-label">Label</label>
                            <input type="text" name="variants[{{ $vi }}][name]" class="f-control" value="{{ $variant['name'] ?? '' }}" placeholder="e.g. 1kg Pack">
                        </div>
                        <div class="f-group">
                            <label class="f-label">Price</label>
                            <input type="number" name="variants[{{ $vi }}][price]" class="f-control" step="0.01" min="0" value="{{ $variant['price'] ?? '' }}" placeholder="0.00">
                        </div>
                        <div class="f-group">
                            <label class="f-label">Unit</label>
                            <select name="variants[{{ $vi }}][price_unit]" class="f-control">
                                @foreach(['kg','lb','ton','g','unit','box','bag','litre'] as $u)
                                <option value="{{ $u }}" {{ ($variant['price_unit'] ?? 'kg') === $u ? 'selected' : '' }}>{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f-group" style="grid-column:span 3">
                            <label class="f-label">Variant Image</label>
                            @if(!empty($variant['image']))
                            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.4rem">
                                <img src="{{ asset('storage/'.$variant['image']) }}" style="height:60px;width:60px;object-fit:cover;border-radius:6px;border:1px solid var(--a-border)">
                                <label style="display:flex;align-items:center;gap:.35rem;font-size:.75rem;color:var(--a-muted);cursor:pointer">
                                    <input type="checkbox" name="variants[{{ $vi }}][remove_image]" value="1"> Remove image
                                </label>
                            </div>
                            <input type="hidden" name="variants[{{ $vi }}][existing_image]" value="{{ $variant['image'] }}">
                            @endif
                            <input type="file" name="variant_images[{{ $vi }}]" accept="image/*" style="font-size:.8rem">
                            <span class="f-hint">JPG, PNG, WebP — max 2MB</span>
                        </div>
                    </div>
                </div>
                @empty
                <div id="no-variants-msg" style="font-size:.82rem;color:var(--a-muted);padding:.5rem 0">No variants added yet.</div>
                @endforelse
            </div>
        </div>

        {{-- Product Specs --}}
        <div class="form-card">
            <div class="form-section-title">Product Specifications</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                <div class="f-group">
                    <label class="f-label">Origin</label>
                    <input type="text" name="origin" class="f-control"
                           value="{{ old('origin', $product->origin ?? 'Sri Lanka') }}" placeholder="Sri Lanka">
                </div>
                <div class="f-group">
                    <label class="f-label">Weight per Unit (kg)</label>
                    <input type="number" name="weight_per_unit" class="f-control" step="0.01" min="0"
                           value="{{ old('weight_per_unit', $product->weight_per_unit ?? '') }}" placeholder="e.g. 1.00">
                </div>
                <div class="f-group">
                    <label class="f-label">Certifications</label>
                    <input type="text" name="certifications" class="f-control"
                           value="{{ old('certifications', $product->certifications ?? '') }}" placeholder="ISO, Organic, Fair Trade…">
                </div>
                <div class="f-group">
                    <label class="f-label">Shelf Life</label>
                    <input type="text" name="shelf_life" class="f-control"
                           value="{{ old('shelf_life', $product->shelf_life ?? '') }}" placeholder="e.g. 24 months">
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right column ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- Main Image --}}
        <div class="form-card">
            <div class="form-section-title">Main Image</div>
            <div class="img-upload-zone" id="mainImgZone">
                <input type="file" name="image" accept="image/*" id="mainImgInput" class="iuz-input">
                @if(!empty($product->image))
                <img src="{{ asset('storage/'.$product->image) }}" id="img-preview" class="iuz-preview">
                <div class="iuz-overlay">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Replace Image
                </div>
                @else
                <div class="iuz-placeholder" id="iuzPlaceholder">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.4"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span style="font-size:.85rem;font-weight:600;color:var(--a-muted)">Click or drag to upload</span>
                    <span class="f-hint">JPG, PNG, WebP — max 2MB</span>
                </div>
                @endif
            </div>
            @if(!empty($product->image))
            <label class="iuz-remove-label" id="iuzRemoveWrap">
                <input type="checkbox" name="remove_image" value="1" id="removeImageCheck">
                Remove current image
            </label>
            @endif
        </div>

        {{-- Gallery Images --}}
        <div class="form-card">
            <div class="form-section-title">Gallery Images</div>
            <p style="font-size:.78rem;color:var(--a-muted);margin-bottom:.85rem">Additional images shown in the product gallery thumbnails. Up to 8 images, max 2MB each.</p>

            {{-- Existing gallery --}}
            @if(!empty($product->gallery) && is_array($product->gallery) && count($product->gallery))
            <div id="gallery-existing" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.5rem;margin-bottom:.85rem">
                @foreach($product->gallery as $gi => $gimg)
                <div style="position:relative" data-gallery-item>
                    <img src="{{ asset('storage/'.$gimg) }}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:6px;border:1px solid var(--a-border)">
                    <label style="position:absolute;top:4px;right:4px;background:rgba(0,0,0,.55);color:#fff;font-size:.65rem;padding:2px 5px;border-radius:3px;cursor:pointer;display:flex;align-items:center;gap:3px">
                        <input type="checkbox" name="gallery_remove[]" value="{{ $gimg }}" style="width:10px;height:10px">
                        Del
                    </label>
                    <input type="hidden" name="gallery_existing[]" value="{{ $gimg }}">
                </div>
                @endforeach
            </div>
            @endif

            <input type="file" name="gallery_images[]" accept="image/*" multiple id="galleryInput" style="font-size:.8rem;color:var(--a-muted)">
            <span class="f-hint">Select multiple files at once — JPG, PNG, WebP — max 2MB each</span>

            {{-- Preview strip for newly selected --}}
            <div id="gallery-new-preview" style="display:flex;flex-wrap:wrap;gap:.5rem;margin-top:.65rem"></div>
        </div>

        {{-- Category & Order --}}
        <div class="form-card">
            <div class="form-section-title">Category & Order</div>
            <div class="f-group">
                <label class="f-label">Category</label>
                <select name="category_id" class="f-control">
                    <option value="">— No Category —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->parent_id ? '↳ ' : '' }}{{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="f-group">
                <label class="f-label">Sort Order</label>
                <input type="number" name="sort_order" class="f-control" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0">
            </div>
        </div>

        {{-- Inventory --}}
        <div class="form-card">
            <div class="form-section-title">Inventory</div>
            <div class="toggle-wrap" style="margin-bottom:.75rem">
                <label class="toggle">
                    <input type="checkbox" name="in_stock" value="1" {{ old('in_stock', $product->in_stock ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
                <span class="f-hint">In Stock</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                <div class="f-group">
                    <label class="f-label">Stock Qty</label>
                    <input type="number" name="stock_qty" class="f-control" min="0"
                           value="{{ old('stock_qty', $product->stock_qty ?? '') }}" placeholder="Leave blank = unlimited">
                </div>
                <div class="f-group">
                    <label class="f-label">Low Stock Alert</label>
                    <input type="number" name="low_stock_threshold" class="f-control" min="0"
                           value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 10) }}" placeholder="10">
                </div>
            </div>
        </div>

        {{-- Flags --}}
        <div class="form-card">
            <div class="form-section-title">Flags</div>
            <div class="checkbox-group">
                @foreach(['is_featured'=>'Featured','is_bestseller'=>'Best Seller','is_new_arrival'=>'New Arrival','is_export_ready'=>'Export Ready'] as $key => $label)
                <label class="a-checkbox">
                    <input type="checkbox" name="{{ $key }}" value="1"
                           {{ old($key, $product->$key ?? false) ? 'checked' : '' }}>
                    {{ $label }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- Status --}}
        <div class="form-card">
            <div class="form-section-title">Status</div>
            <div class="toggle-wrap">
                <label class="toggle">
                    <input type="checkbox" name="status" value="1"
                           {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
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

<style>
/* Image upload zone */
.img-upload-zone{position:relative;border:2px dashed var(--a-border,#e5e7eb);border-radius:var(--a-radius,8px);overflow:hidden;min-height:160px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color .2s,background .2s;background:var(--a-surface,#fafafa)}
.img-upload-zone:hover,.img-upload-zone.drag-over{border-color:var(--a-primary,#16a34a);background:rgba(22,163,74,.04)}
.iuz-input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;font-size:0;z-index:2}
.iuz-preview{max-width:100%;max-height:220px;object-fit:contain;display:block;margin:0 auto;border-radius:4px}
.iuz-placeholder{display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:1.5rem;text-align:center}
.iuz-overlay{position:absolute;inset:0;background:rgba(0,0,0,.5);color:#fff;display:none;align-items:center;justify-content:center;gap:.5rem;font-size:.82rem;font-weight:600;pointer-events:none}
.img-upload-zone:hover .iuz-overlay{display:flex}
.iuz-remove-label{display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:#dc2626;cursor:pointer;margin-top:.5rem}
.iuz-remove-label input{cursor:pointer}
.variant-row{background:var(--a-surface,#f9f9f9);border:1px solid var(--a-border,#e5e7eb);border-radius:8px;padding:1rem;margin-bottom:.75rem}
.variant-row-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem}
.variant-row-num{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--a-muted,#6b7280)}
.remove-variant{background:none;border:none;cursor:pointer;color:#dc2626;font-size:1rem;padding:.15rem .35rem;border-radius:4px;transition:background .15s}
.remove-variant:hover{background:#fee2e2}
.variant-fields{display:grid;grid-template-columns:1fr 1fr 1fr;gap:.6rem}
</style>
<script>
(function(){
    var list = document.getElementById('variants-list');
    var addBtn = document.getElementById('add-variant');
    var noMsg = document.getElementById('no-variants-msg');
    function getCount(){ return list.querySelectorAll('.variant-row').length; }
    function makeRow(idx){
        var units = ['kg','lb','ton','g','unit','box','bag','litre'].map(function(u){
            return '<option value="'+u+'"'+(u==='kg'?' selected':'')+'>'+u+'</option>';
        }).join('');
        return '<div class="variant-row" data-index="'+idx+'">'
            +'<div class="variant-row-header">'
            +'<span class="variant-row-num">Variant '+(idx+1)+'</span>'
            +'<button type="button" class="remove-variant" title="Remove">✕</button>'
            +'</div>'
            +'<div class="variant-fields">'
            +'<div class="f-group"><label class="f-label">Label</label>'
            +'<input type="text" name="variants['+idx+'][name]" class="f-control" placeholder="e.g. 1kg Pack"></div>'
            +'<div class="f-group"><label class="f-label">Price</label>'
            +'<input type="number" name="variants['+idx+'][price]" class="f-control" step="0.01" min="0" placeholder="0.00"></div>'
            +'<div class="f-group"><label class="f-label">Unit</label>'
            +'<select name="variants['+idx+'][price_unit]" class="f-control">'+units+'</select></div>'
            +'<div class="f-group" style="grid-column:span 3"><label class="f-label">Variant Image</label>'
            +'<input type="file" name="variant_images['+idx+']" accept="image/*" style="font-size:.8rem">'
            +'<span class="f-hint">JPG, PNG, WebP — max 2MB</span></div>'
            +'</div></div>';
    }
    if(addBtn) addBtn.addEventListener('click', function(){
        if(noMsg) noMsg.style.display='none';
        var idx = getCount();
        list.insertAdjacentHTML('beforeend', makeRow(idx));
    });
    list.addEventListener('click', function(e){
        var btn = e.target.closest('.remove-variant');
        if(!btn) return;
        btn.closest('.variant-row').remove();
        if(getCount()===0 && noMsg) noMsg.style.display='';
        list.querySelectorAll('.variant-row').forEach(function(row, i){
            row.dataset.index = i;
            row.querySelector('.variant-row-num').textContent = 'Variant '+(i+1);
        });
    });
})();

// Main image upload zone
(function(){
    var zone     = document.getElementById('mainImgZone');
    var input    = document.getElementById('mainImgInput');
    var preview  = document.getElementById('img-preview');
    var pholder  = document.getElementById('iuzPlaceholder');
    var rmCheck  = document.getElementById('removeImageCheck');

    if(!zone || !input) return;

    function showPreview(src){
        if(!preview){
            preview = document.createElement('img');
            preview.id = 'img-preview';
            preview.className = 'iuz-preview';
            zone.insertBefore(preview, zone.querySelector('.iuz-input'));
        }
        preview.src = src;
        preview.style.display = '';
        if(pholder) pholder.style.display = 'none';
        // Show overlay hint on hover
        if(!zone.querySelector('.iuz-overlay')){
            var ov = document.createElement('div');
            ov.className = 'iuz-overlay';
            ov.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Replace Image';
            zone.appendChild(ov);
        }
    }

    input.addEventListener('change', function(){
        var file = input.files[0];
        if(!file) return;
        var reader = new FileReader();
        reader.onload = function(e){ showPreview(e.target.result); };
        reader.readAsDataURL(file);
        if(rmCheck) rmCheck.checked = false;
    });

    // Drag & drop
    zone.addEventListener('dragover', function(e){ e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', function(){ zone.classList.remove('drag-over'); });
    zone.addEventListener('drop', function(e){
        e.preventDefault();
        zone.classList.remove('drag-over');
        var dt = e.dataTransfer;
        if(dt && dt.files.length){
            var reader = new FileReader();
            reader.onload = function(ev){ showPreview(ev.target.result); };
            reader.readAsDataURL(dt.files[0]);
            // Transfer files to input
            try{
                var transfer = new DataTransfer();
                transfer.items.add(dt.files[0]);
                input.files = transfer.files;
            }catch(ex){}
        }
    });

    // Remove toggle
    if(rmCheck){
        rmCheck.addEventListener('change', function(){
            if(rmCheck.checked){
                if(preview) preview.style.display = 'none';
                if(pholder){ pholder.style.display = ''; }
            } else {
                if(preview) preview.style.display = '';
                if(pholder) pholder.style.display = 'none';
            }
        });
    }
})();

// Gallery new-image preview
(function(){
    var inp = document.getElementById('galleryInput');
    var wrap = document.getElementById('gallery-new-preview');
    if(!inp || !wrap) return;
    inp.addEventListener('change', function(){
        wrap.innerHTML = '';
        Array.from(inp.files).forEach(function(file){
            if(!file.type.startsWith('image/')) return;
            var reader = new FileReader();
            reader.onload = function(e){
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:70px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb';
                wrap.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
})();
</script>
