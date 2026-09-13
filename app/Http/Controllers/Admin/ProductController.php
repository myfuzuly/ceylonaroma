<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->search)      $query->where('name','like','%'.$request->search.'%');
        if ($request->category_id) $query->where('category_id',$request->category_id);
        if ($request->status !== null && $request->status !== '') $query->where('status',$request->status);
        if ($request->stock === 'low') $query->whereNotNull('stock_qty')->whereColumn('stock_qty','<=','low_stock_threshold');
        if ($request->stock === 'out') $query->where(fn($q) => $q->where('in_stock',false)->orWhere('stock_qty',0));
        $products   = $query->orderBy('sort_order')->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.products.index', compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::where('status',true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'sku'                 => 'nullable|string|max:60',
            'category_id'         => 'nullable|exists:categories,id',
            'short_description'   => 'nullable|string|max:300',
            'description'         => 'nullable|string',
            'image'               => 'nullable|image|max:4096',
            'gallery_images.*'    => 'nullable|image|max:4096',
            'price'               => 'nullable|numeric|min:0',
            'price_unit'          => 'nullable|string|max:30',
            'currency'            => 'nullable|string|max:5',
            'min_order_qty'       => 'nullable|numeric|min:0',
            'min_order_unit'      => 'nullable|string|max:30',
            'weight_per_unit'     => 'nullable|numeric|min:0',
            'origin'              => 'nullable|string|max:100',
            'certifications'      => 'nullable|string|max:255',
            'shelf_life'          => 'nullable|string|max:100',
            'stock_qty'           => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'in_stock'            => 'boolean',
            'is_featured'         => 'boolean',
            'is_bestseller'       => 'boolean',
            'is_new_arrival'      => 'boolean',
            'is_export_ready'     => 'boolean',
            'sort_order'          => 'integer',
            'status'              => 'boolean',
            'variants'            => 'nullable|array',
            'variant_images.*'    => 'nullable|image|max:4096',
        ]);

        $data['slug'] = Str::slug($data['name']);
        if (Product::where('slug',$data['slug'])->exists()) {
            $data['slug'] .= '-'.time();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeAsWebp($request->file('image'), 'products');
        }

        foreach (['in_stock','is_featured','is_bestseller','is_new_arrival','is_export_ready','status'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }

        $data['variants'] = $this->processVariants($request, []);
        $data['gallery']  = $this->processGallery($request, []);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status',true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'sku'                 => 'nullable|string|max:60',
            'category_id'         => 'nullable|exists:categories,id',
            'short_description'   => 'nullable|string|max:300',
            'description'         => 'nullable|string',
            'image'               => 'nullable|image|max:4096',
            'gallery_images.*'    => 'nullable|image|max:4096',
            'price'               => 'nullable|numeric|min:0',
            'price_unit'          => 'nullable|string|max:30',
            'currency'            => 'nullable|string|max:5',
            'min_order_qty'       => 'nullable|numeric|min:0',
            'min_order_unit'      => 'nullable|string|max:30',
            'weight_per_unit'     => 'nullable|numeric|min:0',
            'origin'              => 'nullable|string|max:100',
            'certifications'      => 'nullable|string|max:255',
            'shelf_life'          => 'nullable|string|max:100',
            'stock_qty'           => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'in_stock'            => 'boolean',
            'is_featured'         => 'boolean',
            'is_bestseller'       => 'boolean',
            'is_new_arrival'      => 'boolean',
            'is_export_ready'     => 'boolean',
            'sort_order'          => 'integer',
            'status'              => 'boolean',
        ]);

        if ($request->boolean('remove_image')) {
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $this->storeAsWebp($request->file('image'), 'products');
        }

        foreach (['in_stock','is_featured','is_bestseller','is_new_arrival','is_export_ready','status'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }

        $data['variants'] = $this->processVariants($request, $product->variants ?? []);
        $data['gallery']  = $this->processGallery($request, $product->gallery ?? []);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted.');
    }

    private function processGallery(\Illuminate\Http\Request $request, array $existing): array
    {
        $toRemove = $request->input('gallery_remove', []);
        $kept = array_filter($existing, fn($img) => !in_array($img, $toRemove));
        $kept = array_values($kept);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $kept[] = $this->storeAsWebp($file, 'products/gallery');
                }
            }
        }

        return array_slice($kept, 0, 8);
    }

    private function processVariants(\Illuminate\Http\Request $request, array $existing): array
    {
        $raw = $request->input('variants', []);
        if (empty($raw) || !is_array($raw)) return [];

        $variantImages = $request->file('variant_images', []);
        $result = [];

        foreach ($raw as $idx => $v) {
            if (empty($v['name'])) continue;
            $entry = [
                'name'       => trim($v['name']),
                'price'      => isset($v['price']) && $v['price'] !== '' ? (float)$v['price'] : null,
                'price_unit' => $v['price_unit'] ?? 'kg',
                'image'      => null,
            ];

            // Keep existing image unless removed
            $existingImg = $v['existing_image'] ?? ($existing[$idx]['image'] ?? null);
            if ($existingImg && empty($v['remove_image'])) {
                $entry['image'] = $existingImg;
            }

            // Upload new image if provided
            if (isset($variantImages[$idx]) && $variantImages[$idx]->isValid()) {
                $entry['image'] = $this->storeAsWebp($variantImages[$idx], 'products/variants');
            }

            $result[] = $entry;
        }

        return $result;
    }

    /**
     * Store an uploaded image as WebP and return its storage-relative path.
     * Falls back to the original file if GD can't decode it.
     */
    private function storeAsWebp(UploadedFile $file, string $directory): string
    {
        $source = match ($file->getMimeType()) {
            'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'image/png'  => @imagecreatefrompng($file->getRealPath()),
            'image/gif'  => @imagecreatefromgif($file->getRealPath()),
            'image/webp' => @imagecreatefromwebp($file->getRealPath()),
            default      => null,
        };

        if (!$source || !function_exists('imagewebp')) {
            return $file->store($directory, 'public');
        }

        imagepalettetotruecolor($source);
        imagealphablending($source, true);
        imagesavealpha($source, true);

        $path = trim($directory, '/').'/'.Str::uuid().'.webp';
        $fullPath = Storage::disk('public')->path($path);
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        imagewebp($source, $fullPath, 82);
        imagedestroy($source);

        return $path;
    }
}
